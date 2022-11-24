<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\OrderService;

use Validator;
use App\Http\Traits\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use Response;
    protected $order;

    public function __construct(OrderService $order) {
        $this->order = $order;
    }

    public function getOrders(Request $request) {
        try {
            $orders = $this->order->getOrders($request);
            return view('orders.index', compact('orders'));

        } catch (\Exception $e) {
           return $this->internalServerError($e);
        }
    }

    public function commissionReport(Request $request) {
        $title = 'Commission Report';
        $type = 'recent';
        $id = null;
        return view('reports.commission', compact('title', 'type', 'id'));
    }

    public function recentCommissionReports(Request $request){

        $type = $request->type;
        $id = $request->extra_id;
        $start = $request->start;
        $limit = $request->length ?? 10;
        $value = $request->search["value"];

        $startDate = $request->startDate;
        $endDate =  $request->endDate;

        $details = $this->getCommissionReport($type, $startDate, $endDate, $value, $start, $limit, $request->isDate, $id);
        $totalReports  = $details[0];
        $reports = $details[1];


        $data = [];
        foreach($reports as $report){
            $url = '/orders/' . $report->id;
            $nestedData['Invoice'] = $report->invoice_number;
            $nestedData['Purchaser'] = $report->user->first_name . ' ' . $report->user->last_name;
            $nestedData['Order Date'] = date_format(date_create($report->order_date),"F j, Y");
            $nestedData['Distributor'] = ($report->user->is_distributor) ? ($report->user->distributor ? $report->user->distributor->first_name . ' ' . $report->user->distributor->last_name : '') : '';
            // $nestedData['Referred Distributors'] = $report->invoice_number;
            // $nestedData['Order Total'] = $report->invoice_number;
            // $nestedData['Percentage'] = $report->invoice_number;
            // $nestedData['Commission'] = $report->invoice_number;
            $nestedData['options'] = "&emsp;<span> <a href='{$url}' class='btn btn-secondary waves-effect waves-light w-sm'><i class='fa fa-eye'></i> View</a></span>";
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => isset ( $request->draw ) ?
            intval( $request->draw ) :
            0,
            "recordsTotal" => intval($totalReports),
            "data" => $data,
            "recordsFiltered" => intval($totalReports)
        ];

        return json_encode($json_data);

    }

    private function getCommissionReport($type, $from, $to, $value, $start, $limit, $isDate, $id){
        switch ($type) {
            case 'recent':
                $details = $this->getRecent($start, $limit, $from, $to, $value, $isDate);
                return $details;
                break;
            default:
                $details = $this->getRecent($start, $limit, $from, $to, $value, $isDate);
                return $details;
                break;
        }
    }

    //get recent policy
    private function getRecent($start, $limit, $from, $to, $value, $isDate){
        if($value){
            $orders = Order::where('User', 'like', '%'.$value.'%')
                    ->offset($start)
                    ->limit($limit)
                    ->get();
         $totalReports  = Order::where('User', 'like', '%'.$value.'%')->count();
        } else if($isDate === "true"){
            $orders = Order::whereBetween('order_date', [$from, $to])
                    ->offset($start)
                    ->limit($limit)
                    ->get();
            $totalReports = Order::whereBetween('order_date', [$from, $to])->count();
        }
        else{
            $totalReports  = DB::table('orders')->count();
            $orders = Order::with(['user.distributor', 'user.is_distributor', 'count_referrals'])
            ->offset($start)
            ->limit($limit)
            ->get();
            // $orders = DB::table('orders')->offset($start)
            // ->join('users', 'users.id', '=', 'orders.purchaser_id')
            // ->limit($limit)
            // ->get(['orders.*', 'users.first_name', 'users.last_name', 'users.username', 'users.referred_by', 'users.enrolled_date']);
        }
        return [$totalReports, $orders];
    }

    public function viewOrder(Request $request, $id) {
        try {
            $order_info = $this->order->viewOrder($id);
            $invoice_id = '';
            if(count($order_info) > 0) {
                $invoice_id = $order_info[0]->invoice_number;
            }
            return view('orders.view_order', compact('order_info', 'invoice_id'));

        } catch (\Exception $e) {
           return $this->internalServerError($e);
        }
    }

    public function rankReport(Request $request) {
        try {
            return view('reports.rank');

        } catch (\Exception $e) {
           return $this->internalServerError($e);
        }
    }

    public function getrankReports(Request $request) {
        // DB::table('orders')->where('orders.id', $id)->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('products', 'products.id', '=', 'order_items.product_id')->get(['orders.*', 'order_items.order_id', 'order_items.qantity', 'order_items.product_id', 'products.sku', 'products.name', 'products.price']);

        // $details = DB::table('orders')->sum('orders.id', $id)->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('products', 'products.id', '=', 'order_items.product_id')->get(['orders.*', 'order_items.order_id', 'order_items.qantity', 'order_items.product_id', 'products.sku', 'products.name', 'products.price']);

        $details = DB::select('SELECT * from users left join user_category on user_category.user_id = users.id LEFT JOIN orders on orders.purchaser_id = users.id LEFT JOIN order_items on order_items.order_id = orders.id LEFT JOIN products on products.id = order_items.product_id WHERE user_category.category_id = 2 GROUP BY products.price * order_items.qantity DESC LIMIT 100');

        $data = [];
        $nestedData['Top'] = 0;
        foreach($details as $report){
            $nestedData['Top'] += 1;
            $nestedData['Distributor Name'] = $report->first_name . ' ' . $report->last_name;
            $nestedData['Total Sales'] = '$' . $report->qantity * $report->price;
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => isset ( $request->draw ) ?
            intval( $request->draw ) :
            0,
            "recordsTotal" => intval(count($details)),
            "data" => $data,
            "recordsFiltered" => intval(count($details))
        ];

        return json_encode($json_data);
    }
}

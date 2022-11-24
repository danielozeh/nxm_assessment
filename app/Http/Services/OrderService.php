<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Traits\Response;

class OrderService {
    use Response;

    /**
     * @author Daniel Ozeh hello@danielozeh.com.ng
     * Get all orders
     */
    public function getOrders($request) {
        $orders = DB::table('orders')->get();
        return $orders;
    }

    /**
     * @author Daniel Ozeh hello@danielozeh.com.ng
     */
    public function orderCount($request) {
        $order_count = DB::table('orders')->count();
        return $order_count;
    }

    /**
     * @author Daniel Ozeh hello@danielozeh.com.ng
     */
    public function commissionReportAction($request) {
        $order_count = DB::table('orders')->count();
        return $order_count;
    }

    public function viewOrder($id) {
        $order = DB::table('orders')->where('orders.id', $id)->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('products', 'products.id', '=', 'order_items.product_id')->get(['orders.*', 'order_items.order_id', 'order_items.qantity', 'order_items.product_id', 'products.sku', 'products.name', 'products.price']);
        return $order;
    }

}

?>
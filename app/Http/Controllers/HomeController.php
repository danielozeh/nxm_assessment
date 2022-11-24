<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;

use Validator;
use App\Http\Traits\Response;

class HomeController extends Controller
{
    use Response;
    protected $order;
    protected $product;

    public function __construct(OrderService $order, ProductService $product) {
        $this->order = $order;
        $this->product = $product;
    }

    public function index(Request $request) {
        try {
            $order_count = $this->order->orderCount($request);
            $product_count = $this->product->productCount($request);
            $product_sum = $this->product->productSum($request);
            return view('dashboard', compact('order_count', 'product_count', 'product_sum'));

        } catch (\Exception $e) {
           return $this->internalServerError($e);
        }
    }
}

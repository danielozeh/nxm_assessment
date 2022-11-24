<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Traits\Response;

class ProductService {
    use Response;

    /**
     * @author Daniel Ozeh hello@danielozeh.com.ng
     */
    public function productCount($request) {
        $product_count = DB::table('products')->count();
        return $product_count;
    }

    /**
     * @author Daniel Ozeh hello@danielozeh.com.ng
     */
    public function productSum($request) {
        $product_sum = DB::table('products')->sum('price');
        return $product_sum;
    }

}

?>
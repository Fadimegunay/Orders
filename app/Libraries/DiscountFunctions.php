<?php

namespace App\Libraries;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DiscountFunctions
{
	private $order;
	
	public function __construct(Order $order)
	{
        $this->order = $order;
    }

    public function percent10($totalDiscount)
    {
        $total = $this->order->total;

        $orderDiscount = ($total * 10) / 100;
        $totalDiscount += $orderDiscount;

        $discount = new Discount();
        $discount->discountReason = "10_PERCENT_OVER_1000";
        $discount->discountAmount =  $orderDiscount;
        $discount->subtotal = $total - $totalDiscount;
        $discount->totalDiscount = $totalDiscount;

        return $discount;
    }

    public function percent20($totalDiscount)
    {
        $categoryProducts = $this->order->products()
                                    ->leftJoin('products', 'products.id', '=', 'order_products.productId')
                                    ->where('products.category', 1)->orderByDesc('products.price')->get();

        if($categoryProducts->count() >= 2) {
            $orderDiscount = ($categoryProducts->first()->price * 20) / 100;
            $totalDiscount += $orderDiscount;

            $discount = new Discount();
            $discount->discountReason = "20_PERCENT";
            $discount->discountAmount =  $orderDiscount;
            $discount->subtotal = $this->order->total - $totalDiscount;
            $discount->totalDiscount = $totalDiscount;

           return $discount;
        }
        
        return [];
    }

    public function pay5($totalDiscount)
    {
        $category2Products = $this->order->products()
                                        ->leftJoin('products', 'products.id', '=', 'order_products.productId')
                                        ->select('products.price', DB::raw('sum(order_products.quantity) as stock'))
                                        ->where('products.category', 2)->orderByDesc('products.price')->get();
            
        if($category2Products &&  $category2Products->first()->stock == 6) {
            $orderDiscount = $category2Products->first()->price;
            $totalDiscount += $orderDiscount;

            $discount = new Discount();
            $discount->discountReason = "BUY_5_GET_1";
            $discount->discountAmount =  $orderDiscount;
            $discount->subtotal = $this->order->total - $totalDiscount;
            $discount->totalDiscount = $totalDiscount;
        
            return $discount;
        }

        return [];
    }
}
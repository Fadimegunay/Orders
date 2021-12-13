<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Libraries\DiscountFunctions;

use App\Http\Requests\OrderPostRequest;

class OrderController extends Controller
{
    public function list()
    {
        $orders = Order::with('products')->get();
        return response()->json($orders);
    }

    public function create(OrderPostRequest $request)
    {
        $total = 0;
        $quantity = $request->input('quantity');
        $order_products = [];
        foreach ($request->input('productId') as $key => $productId) {
            $product = Product::find($productId);
            if($product && $quantity[$key]) {
                $totalProduct= $product->price * $quantity[$key];
                $order_products [] = [
                    'productId' => $product->id,
                    'quantity' => $quantity[$key],
                    'unitPrice' => $product->price,
                    'totalPrice' => $totalProduct
                ];
                $total += $totalProduct;
            }
        }

        if(count($order_products) > 0) {
            $order = Order::create([
                'customerId' => $request->input('customerId'),
                'total' => $total
            ]);
            foreach ($order_products as $orderProduct) {
                $product = Product::find($orderProduct['productId']);
                if($orderProduct['quantity'] > $product->stock) {
                    $order->delete();
                    return response()->json('products.stock');
                }
                $order->products()->create([
                    'productId' => $orderProduct['productId'],
                    'quantity' => $orderProduct['quantity'],
                    'unitPrice' => $orderProduct['unitPrice'],
                    'totalPrice' => $orderProduct['totalPrice']
                ]);
                $product->update([
                    'stock' => $product->stock - $orderProduct['quantity'] 
                ]);
            } 
            return response()->json($order);
        }
    }

    public function delete($orderId) 
    {
        $order = Order::find($orderId);
        if($order) {
            $order->delete();
            return response()->json(true);
        }
        return response()->json(false);
    }


    public function discount_calcutation($orderId)
    {
        $order = Order::find($orderId);
        $totalDiscount = 0;
        $discounts = [];
        if($order) {
            $discountFunc = new DiscountFunctions($order, $totalDiscount);  
            if($order->total >= 1000) {
                $discount = $discountFunc->percent10($totalDiscount);
                $totalDiscount = $discount->totalDiscount;
                $discounts [] = $discount;
            }
            
            $discount = $discountFunc->pay5($totalDiscount);
            if(!empty($discount)) {
                $totalDiscount = $discount->totalDiscount;
                $discounts [] = $discount;
            }

            $discount = $discountFunc->percent20($totalDiscount);
            if(!empty($discount)) {
                $totalDiscount = $discount->totalDiscount;
                $discounts [] = $discount;
            }

            $result = [
                'orderId' => $orderId,
                'discounts' => $discounts,
                'totalDiscount' => $totalDiscount,
                'discountedTotal' => $order->total - $totalDiscount
            ];
    
            return response()->json($result);
        }
        return response()->json(false);
    }
    
}

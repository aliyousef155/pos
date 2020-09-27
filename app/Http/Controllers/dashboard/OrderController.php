<?php

namespace App\Http\Controllers\dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public  function __construct()
    {
        $this->middleware(['permission:orders_read'])->only('index');
        $this->middleware(['permission:orders_create'])->only('create');
        $this->middleware(['permission:orders_update'])->only('edit');
    }//end of construct
    public function index(request $request){

        $orders=Order::whereHas('client',function ($q)use ($request){
           return $q->where('name','like','%'.$request->search.'%');
        })->latest()->paginate(5);

        return view('dashboard.orders.index',compact('orders'));

    }//end of index
    public function products(Order $order){
        $products=$order->products;
        return view('dashboard.orders.products',compact('order','products'));
    }//end of products
//    public  function edit(Order $order,Client $client){
////        $products=Product::all();
//        return view('dashboard.clients.orders.edit',compact('order','client'));
//    }
    public function destroy(Order $order){
        foreach ($order->products as $product){

            $product->update([
               'stock'=>$product->stock+$product->pivot->quantity
            ]);
        }

        $order->delete();
        return redirect()->route('dashboard.orders.index');
    }//end of destroy
    public function confirmed_order(){

    }

}//end of controller

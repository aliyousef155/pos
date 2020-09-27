<?php

namespace App\Http\Controllers\dashboard\client;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {

    }// end of index6


    public function create(Client $client)
    {
        $categories=Category::with('products')->get();
        return view('dashboard.clients.orders.create',compact('categories','client'));
    }// end of create


    public function store(Request $request,Client $client)
    {

        $request->validate([
           'products'=>'required',
        ]);


        $total_price=0;

        foreach ($request->products as $id=>$quantity){
            $product=Product::findOrFail($id);
            if ($quantity['quantity'] < $product->stock ){
                $total_price +=$product->sale_price * $quantity['quantity'];
            }else{
                session()->flash('failed',__('site.not_enough_amount'));
                return redirect()->back();
            }//end of if
            $product->update([
                'stock'=>$product->stock - $quantity['quantity']
            ]);

        }//end of foreach

        $order=$client->orders()->create([]);
        $order->products()->attach($request->products);


        $order->update([
            'total_price'=>$total_price
        ]);

        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');


    }// end of store

    public function edit(Client $client,Order $order)
    {
        $categories=Category::all();
        return view('dashboard.clients.orders.edit',compact('order','client','categories'));

    }// end of edit


    public function update(Request $request,Client $client ,Order $order)
    {
        $request->validate([
            'products'=>'required',
        ]);
        $total_price=0;
        foreach ($request->products as $id=>$quantity){
            $product=Product::findOrFail($id);
            if ($quantity['quantity'] < $product->stock ){
                $total_price +=$product->sale_price * $quantity['quantity'];
            }else{
                session()->flash('failed',__('site.not_enough_amount'));
                return redirect()->back();
            }//end of if
            $product->update([
                'stock'=>$product->stock - $quantity['quantity']
            ]);

        }//end of foreach
        $new_order=$client->orders()->create([]);
        $new_order->products()->attach($request->products);


        $new_order->update([
            'total_price'=>$total_price
        ]);

        $this->detach_order($order);

                session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// end of update


    public function destroy(Order $order,Client $client)
    {
        //
    }// end of destroy


    private function detach_order($order){
        foreach ($order->products as $product){

            $product->update([
                'stock'=>$product->stock+$product->pivot->quantity
            ]);
        }

        $order->delete();

        return redirect()->route('dashboard.orders.index');
    }//end of detach


}// end of controller

<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $products_count=Product::count();
        $categories_count=Category::count();
        $clients_count=Client::count();
        $users_count=User::whereRoleIs('admin')->count();


        $sales_data=Order::select([
            DB::raw('YEAR(created_at)as year'),
            DB::raw('MONTH(created_at)as month'),
            DB::raw('SUM(total_price)as sum'),
        ])->groupBy('month')->get();
        return view('dashboard.adminDashboard',compact('products_count','categories_count','users_count','clients_count','sales_data'));
    }// end of index function
}// end of controller

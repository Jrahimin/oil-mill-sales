<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\Item;
use App\Model\SalePackage;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userCount = User::count();
        $customerCount = Customer::count();
        $dueCustomer = Customer::where('unpaid', '>', 0)->count();
        $saleCount = SalePackage::count();
        $totalSale = SalePackage::where('status', 1)->sum('total_price');
        $totalSaleToday = SalePackage::whereDate('created_at', date('y-m-d'))->where('status', 1)->sum('total_price');
        $totalDue = SalePackage::sum('unpaid');
        $itemCount = Item::count();
        return view('home', compact('userCount', 'customerCount', 'dueCustomer', 'saleCount', 'totalSale', 'totalSaleToday', 'totalDue', 'itemCount'));
    }
}

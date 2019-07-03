<?php

namespace App\Http\Controllers;

use App\Model\SalePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MemoController extends Controller
{
    public function index(Request $request)
    {
        try{
            $salePack = SalePackage::with('sales.item','sales.item_unit','user','vehicle','customer','route')->where('id', $request->packId)->firstOrFail();

            //dd($salePack->sales[0]);
            return view('sale.memo', compact('salePack'));
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
        }
    }
}

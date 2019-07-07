<?php

namespace App\Http\Controllers;

use App\Model\SalePackage;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MemoController extends Controller
{
    public function index(Request $request)
    {
        try{
            $salePack = SalePackage::with('sales.item','sales.item_unit','user','vehicle','customer','route')->where('id', $request->packId)->firstOrFail();
            /*$saleDate = date('d-m-Y', strtotime($salePack->created_at));

            $pdf = PDF::loadView('sale.memo', compact('salePack'));
            return $pdf->download("sale-{$saleDate}.pdf");*/

            return view('sale.memo', compact('salePack'));
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
        }
    }
}

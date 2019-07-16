<?php

namespace App\Http\Controllers;

use App\Model\SalePackage;
use App\Traits\QueryTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    use QueryTrait;

    public function memoList()
    {
        $salePacks = SalePackage::with('sales.item','sales.item_unit','user','vehicle','customer','route')->get();

        return view('reports.memo.index', compact('salePacks'));
    }

    public function generateMemo(Request $request)
    {
        try{
            $salePack = SalePackage::with('sales.item','sales.item_unit','user','vehicle','customer','route')->where('id', $request->packId)->firstOrFail();
            /*$saleDate = date('d-m-Y', strtotime($salePack->created_at));

            $pdf = PDF::loadView('sale.memo', compact('salePack'));
            return $pdf->download("sale-{$saleDate}.pdf");*/

            return view('reports.memo.memo', compact('salePack'));
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
        }
    }

    public function routeWiseReport()
    {
        $routes = __routesDropdown();
        return view('reports.routewise-memo.index', compact('routes'));
    }

    public function generateRouteWiseReport(Request $request)
    {
        $query = SalePackage::with('sales','customer','route')->where('route_id', $request->route_id);
        $query = self::filterDate($query,'created_at', $request->date_from, $request->date_to);

        $salePacks = $query->get();

        return view('reports.routewise-memo.memo', compact('salePacks'));
    }
}

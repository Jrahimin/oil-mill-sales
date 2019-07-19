<?php

namespace App\Http\Controllers;

use App\Model\SalePackage;
use App\Traits\ApiResponseTrait;
use App\Traits\QueryTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    use QueryTrait, ApiResponseTrait;

    public function memoList(Request $request)
    {
        try{
            if(!$request->wantsJson())
                return view('reports.memo.index', compact('salePacks'));

            $whereFilterList = ['customer_id', 'user_id', 'route_id'];
            $query = SalePackage::with('sales.item','sales.item_unit','user','vehicle','customer','route');
            $salePacks = $this->filterMemoList($request, $query, $whereFilterList)->paginate(2);

            return $this->successResponse($salePacks);
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
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

    protected function filterMemoList(Request $request, $query, $whereFilterList=[], $likeFilterList=[])
    {
        Log::debug("request: ".print_r($request->all(),true));
        Log::debug("status type: ".gettype($request->payment_status));
        Log::debug("whereFilter: ".print_r($whereFilterList,true));

        if($request->payment_status === '0')
            $query->where('unpaid', 0);
        if($request->payment_status === '1')
            $query->where('unpaid', '>', 0);

        $query = self::filterQuery($request, $query, $whereFilterList, $likeFilterList);

        $query = self::filterDate($query,'created_at', $request->from_date, $request->to_date);

        return $query;
    }
}

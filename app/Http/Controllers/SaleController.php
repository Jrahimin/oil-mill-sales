<?php

namespace App\Http\Controllers;

use App\Model\Item;
use App\Model\Sale;
use App\Model\SalePackage;
use App\Model\Stock;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sale.index');
    }

    public function getItemsForCategory($categoryId)
    {
        try{
            $items = Item::where('category_id', $categoryId)->has('stocks')->get();
            return $this->successResponse($items);
        }
        catch(\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    public function getStocks($itemId)
    {
        try{
            $stocks = Stock::where('status', 1)->where('item_id', $itemId)->where('no_of_items', '>', 0)->get()
                ->filter(function ($stock){
                    return $stock->no_of_items - $stock->sold > 0;
                });
            
            return $this->successResponse($stocks);
        }
        catch(\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    public function getSalePrice($stockId)
    {
        try{
            $stock = Stock::findOrFail($stockId);

            return $this->successResponse($stock->sale_price);
        }
        catch(\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateStoreRequest($request);
        try {
            $lastSalePack = SalePackage::latest('id')->first();
            $salePackCount = $lastSalePack ? $lastSalePack->id : 1;
            $serialNo = ($salePackCount + 1) . "-" . Str::random(3);
            $salePackData = array(
                "serial_no" => $serialNo,
                "user_id" => auth()->user()->id,
                "customer_id" => $request->customer_id,
                "status" => 1
            );

            DB::beginTransaction();

            $salePack = SalePackage::create($salePackData);

            $saleData = [];
            foreach ($request->sale_list as $sale) {
                $data = array(
                    "sale_package_id" => $salePack->id,
                    "item_id" => $sale['item_id'],
                    "stock_id" => $sale['stock_id'],
                    "no_of_items" => $sale['no_of_items'],
                    "unit_price" => $sale['unit_price'],
                    "total_price" => $sale['unit_price'] * $sale['no_of_items'],
                );

                $saleData[] = $data;

                Stock::findOrFail($sale['stock_id'])->increment('sold', $sale['no_of_items']);
            }

            Sale::insert($saleData);

            DB::commit();

            return $this->successResponseWithMsg("Successful sale");
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function validateStoreRequest(Request $request)
    {
        // validating request list => customer_id and sale_list check if exists
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required|integer',
            'sale_list' => 'required'
        ]);

        if($validator->fails()){
            throw new HttpResponseException(response()->json([
                'messages' => $validator->errors()->all(),
            ], 422));
        }

        //sale_list extracted and validated here
        foreach ($request->sale_list as $aData)
        {
            $validator = Validator::make($aData,[
                'unit_price' => 'required|numeric',
                'item_id' => 'required|integer',
                'category_id' => 'required|integer',
                'stock_id' => 'required|integer',
                'no_of_items' => 'required|integer',
            ]);

            if($validator->fails()){
                throw new HttpResponseException(response()->json([
                    'messages' => $validator->errors()->all(),
                ], 422));
            }
        }
    }
}

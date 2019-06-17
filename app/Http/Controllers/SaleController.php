<?php

namespace App\Http\Controllers;

use App\Model\Item;
use App\Model\SalePackage;
use App\Model\Stock;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
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
            $stocks = Stock::where('status', 1)->where('item_id', $itemId)->where('no_of_items', '>', 0)->get();
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
        $data = $request->all();
        foreach ($data as $aData)
        {
            $validator = Validator::make($aData,[
                'sale_price' => 'required|numeric',
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

        $lastSalePackId = SalePackage::latest()->id;
        $request['user_id'] = $request->user()->id;
        $request['customer_id'] = 1;
        $request['serial_no'] = ($lastSalePackId+1)."-".Str::random(3);

        return response()->json($data);
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
}

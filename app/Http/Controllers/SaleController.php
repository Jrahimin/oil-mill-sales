<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\Item;
use App\Model\ItemUnit;
use App\Model\Sale;
use App\Model\SalePackage;
use App\Model\Stock;
use App\Model\UnitConversion;
use App\Traits\ApiResponseTrait;
use App\Traits\QuantityFromConversionTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    use ApiResponseTrait, QuantityFromConversionTrait;
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
            $stocks = Stock::where('status', 1)->where('item_id', $itemId)->where('quantity', '>', 0)->get()
                ->filter(function ($stock){
                    return $stock->quantity - $stock->sold > 0;
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
        Log::debug(json_encode($request->all()));

        $this->validateStoreRequest($request);

        try {
            $lastSalePack = SalePackage::latest('id')->first();
            $salePackCount = $lastSalePack ? $lastSalePack->id : 1;
            $serialNo = ($salePackCount + 1) . "-" . Str::random(3);
            $salePackData = array(
                "serial_no" => $serialNo,
                "user_id" => auth()->user()->id,
                "customer_id" => $request->sale_pack['customer_id'],
                "vehicle_id" => $request->sale_pack['vehicle_id'] ?? null,
                "route_id" => $request->sale_pack['route_id'] ?? null,
                "status" => 1,
                "paid" => $request->sale_pack['paid']
            );

            DB::beginTransaction();

            $salePack = SalePackage::create($salePackData);

            $saleData = [];
            $salePackPrice = 0;
            foreach ($request->sale_list as $sale) {
                $saleTotal = $sale['unit_price'] * $sale['quantity']; // per sale total
                $salePackPrice += $saleTotal; // calculating full sale pack total price
                $data = array(
                    "sale_package_id" => $salePack->id,
                    "item_id" => $sale['item_id'],
                    "stock_id" => $sale['stock_id'],
                    "quantity" => $sale['quantity'],
                    "item_unit_id" => $sale['item_unit_id'],
                    "no_of_jar" => $sale['no_of_jar'],
                    "no_of_drum" => $sale['no_of_drum'],
                    "no_of_jar_return" => $sale['no_of_jar_return'],
                    "no_of_drum_return" => $sale['no_of_drum_return'],
                    "unit_price" => $sale['unit_price'],
                    "total_price" => $saleTotal,
                );

                $saleData[] = $data;

                // if stock unit and sale unit differs, we need to make conversion and adjust stock accordingly
                $stock = Stock::findOrFail($sale['stock_id']);

                $quantity = $this->getQuantity($sale, $stock);
                if(!$quantity){
                    Log::debug("Stock: ".json_encode($stock));
                    DB::rollBack();
                    return response()->json([
                        'messages' => ["Invalid Unit Conversion"],
                    ], 422);
                }

                if($stock->quantity - $stock->sold < $quantity){
                    $item = Item::findOrFail($sale['item_id']);
                    $saleUnit = ItemUnit::find($sale['item_unit_id']);

                    DB::rollBack();
                    return response()->json([
                        'messages' => ["{$quantity} {$saleUnit->name} {$item->title} is not in stock"],
                    ], 422);
                }

                $stock->increment('sold', $quantity);
            }

            $unpaid = $salePackPrice - $request->sale_pack['paid'];
            if($unpaid){
                $salePack->update([
                    "total_price" => $salePackPrice,
                    "unpaid" => $unpaid
                ]);

                $customer = Customer::findOrFail($request->sale_pack['customer_id']);
                $customer->increment('unpaid', $unpaid);
            }

            Sale::insert($saleData);

            DB::commit();

            return $this->successResponse($salePack->id);
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    public function getSaleQuantity(Request $request)
    {
        $sale = $request->only(['stock_id', 'item_unit_id', 'quantity']);

        $quantity = $this->getQuantity($sale);

        if(!$quantity){
            return response()->json([
                'messages' => ["Invalid Unit Conversion"],
            ], 422);
        }

        return response()->json($quantity);
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
        // validating sale_pack and sale_list if exist
        $validator = Validator::make($request->all(),[
            'sale_pack' => 'required',
            'sale_list' => 'required'
        ]);

        if($validator->fails()){
            throw new HttpResponseException(response()->json([
                'messages' => $validator->errors()->all(),
            ], 422));
        }

        // validating sale pack attributes
        if((int) $request->sale_pack['sale_type'] == 1){
            $validator = Validator::make($request->sale_pack,[
                'customer_id' => 'required|integer',
                'vehicle_id' => 'required|integer',
                'route_id' => 'required|integer',
                'paid' => 'required|numeric'
            ]);
        }else{
            $validator = Validator::make($request->sale_pack,[
                'customer_id' => 'required|integer',
                'paid' => 'required|numeric'
            ]);
        }

        if($validator->fails()){
            throw new HttpResponseException(response()->json([
                'messages' => $validator->errors()->all(),
            ], 422));
        }

        //sale_list extracted and validated here
        foreach ($request->sale_list as $aData)
        {
            // validating sale_list attributes
            $validator = Validator::make($aData,[
                'unit_price' => 'required|numeric',
                'item_id' => 'required|integer',
                'category_id' => 'required|integer',
                'stock_id' => 'required|integer',
                'quantity' => 'required|integer',
            ]);

            if($validator->fails()){
                throw new HttpResponseException(response()->json([
                    'messages' => $validator->errors()->all(),
                ], 422));
            }
        }
    }
}

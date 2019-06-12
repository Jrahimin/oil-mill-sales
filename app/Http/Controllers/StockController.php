<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stock\StockStoreRequest;
use App\Http\Requests\Stock\StockUpdateRequest;
use App\Model\Stock;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            //dd(Stock::with('item.category', 'user')->limit(2)->get());
            if(!$request->wantsJson())
                return view('stock.index');

            $data['stocks'] = Stock::with('item.category', 'user')->paginate(2);
            $data['items'] = __itemDropdown();

            return $this->successResponse($data);
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
    public function store(StockStoreRequest $request)
    {
        try{
            if(auth()->user()->type != 'admin')
                return $this->exceptionResponse('You are not allowed to add stock',401);

            $request['user_id'] = auth()->user()->id;
            $request['sold'] = 1;
            Stock::create($request->all());

            return $this->successResponseWithMsg('Item Added to stock Successfully');
        }
        catch (\Exception $e){
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
    public function update(StockUpdateRequest $request, $id)
    {
        try{
            if(auth()->user()->type != 'admin')
                return $this->exceptionResponse('You are not allowed to update stock',401);

            Stock::findOrFail($id)->update($request->all());
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if(auth()->user()->type != 'admin')
                return $this->exceptionResponse('You are not allowed to delete stock',401);

            Stock::destroy($id);
            return $this->successResponseWithMsg('stock Deleted Successfully');
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }
}

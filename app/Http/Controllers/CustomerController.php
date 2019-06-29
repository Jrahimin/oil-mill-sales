<?php

namespace App\Http\Controllers;

use App\Http\Requests\customer\CustomerStoreRequest;
use App\Http\Requests\customer\CustomerUpdateRequest;
use App\Model\Customer;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    use ApiResponseTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{

            if(!$request->wantsJson())
                return view('customer.index');
            $customers = Customer::paginate(2);

            return $this->successResponse($customers);

        }catch (\Exception $e)
        {
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something went wrong');
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
    public function store(CustomerStoreRequest $request)
    {
        try{
            Customer::create($request->all()) ;
            return $this->successResponseWithMsg('Successfully added customer');

        }catch (\Exception $e)
        {
          Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
          return $this->exceptionResponse('Something went wrong');
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
    public function update(CustomerStoreRequest $request, $id)
    {
        try{
            Customer::findOrFail($id)->update($request->all());
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

            Customer::destroy($id);
            return $this->successResponseWithMsg('Customer Deleted Successfully');
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }
}

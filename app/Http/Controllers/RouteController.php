<?php

namespace App\Http\Controllers;

use App\Http\Requests\route\RouteStoreRequest;
use App\Http\Requests\route\RouteUpdateRequest;
use App\Model\Route;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ApiResponseTrait;

    public function index(Request $request)
    {
        try{
            if(!$request->wantsJson())
                return view('route.index');

            $routes = Route::paginate(2);
            return $this->successResponse($routes);
        }catch (\Exception $e)
        {
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
    public function store(RouteStoreRequest $request)
    {
        try {

            Route::create($request->all());
        }
        catch (\Exception $e) {
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
    public function update(RouteUpdateRequest $request, $id)
    {
        try{
            if(auth()->user()->type != 'admin')
                return $this->exceptionResponse('You are not allowed to update item',401);

            Route::findOrFail($id)->update($request->all());
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
        try
        {
            if(auth()->user()->type != 'admin')
            {
                return $this->exceptionResponse('You are not allowed to delete route ',401);
            }
            Route::destroy($id);
            return $this->successResponseWithMsg('Successfully deleted route');
        }
        catch (\Exception $e)
        {
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something went wrong');
        }
    }
}

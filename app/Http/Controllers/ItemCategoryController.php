<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemCategory\ItemCategoryStoreRequest;
use App\Http\Requests\ItemCategory\ItemCategoryUpdateRequest;
use App\ItemCategory;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Log;

class ItemCategoryController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        try{
            if(!$request->wantsJson())
                return view('itemCategory.index');

            $itemCategories = ItemCategory::paginate(2);

            return $this->successResponse($itemCategories);
        }
        catch(\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    public function store(ItemCategoryStoreRequest $request) //php artisan make:request User/UserStoreRequest
    {
        try{
            if(auth()->user()->type != 'admin')
                return $this->exceptionResponse('You are not allowed to update user',401);

            ItemCategory::create($request->all());

            return $this->successResponseWithMsg('Item Category Created Successfully');
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }


    public function update(ItemCategoryUpdateRequest $request, $id)
    {
        try{
            if(auth()->user()->type != 'user')
                return $this->exceptionResponse('You are not allowed to update item category',401);

            ItemCategory::find($id)->update($request->all());
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

    public function destroy($id)
    {
        try{
            if(auth()->user()->type != 'admin')
                return $this->exceptionResponse('You are not allowed to update user',401);

            User::destroy($id);
            return $this->successResponseWithMsg('User Deleted Successfully');
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }

}

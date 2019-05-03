<?php

namespace App\Http\Controllers;

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
}

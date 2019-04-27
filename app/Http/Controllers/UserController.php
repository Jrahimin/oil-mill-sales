<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Traits\ApiResponseTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
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
            if(!$request->wantsJson())
                return view('user.index');

            $users = User::paginate(2);

            return $this->successResponse($users);
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
    public function store(UserStoreRequest $request) //php artisan make:request User/UserStoreRequest
    {
        $request['password'] = bcrypt($request->password);
        User::create($request->all());

        return $this->successResponseWithMsg('User Registered Successfully');
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
    public function update(UserUpdateRequest $request, $id)
    {
        User::findOrFail($id)->update($request->all());
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
            User::destroy($id);
            return $this->successResponseWithMsg('User Deleted Successfully');
        }
        catch (\Exception $e){
            Log::error($e->getFile().' '.$e->getLine().' '.$e->getMessage());
            return $this->exceptionResponse('Something Went Wrong');
        }
    }
}

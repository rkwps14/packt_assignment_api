<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => ['The Credentials do not match']
            ],400);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token'=> $token
        ];

        return response($response, 200);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response([
            'message' => ['The Record Register Success'],
            'status' => 200

        ],200);
    }

    public function getUsers(){
        $data = User::find(Auth::id());
        if(!empty($data)){
            return response([
                'data' => $data,
                'message' => 'All Users Data',
                'status' => 200

            ],200);
        }

        return response([
            'message' => 'Something Went Wrong. or User Not Found',
            'status' => 400

        ],200);
    }

    public function getEditUsers($id){
        $data = User::where('id','=',$id)->first();
        if(empty($data)){
            return response([
                'message' => ['Record Not Found'],
                'status' => 400

            ],400);
        }
        return response([
                'data' => $data,
                'message' => ['Record Founded'],
                'status' => 200
            ],200);
    }

    public function getUpdateUsers(Request $request, $id){

        $item= User::find($id);
        $item->name=$request->name;
        $item->email=$request->email;
        $item->update();

        return response([
            'message' => 'The Record Updated Succesfully',
            'status' => 200
        ],200);
    }

    public function getAllUser(){
        $data = User::all();
        if(!empty($data)){
            return response([
                'data' => $data,
                'message' => 'All Users Data',
                'status' => 200

            ],200);
        }

        return response([
            'message' => 'Something Went Wrong. or User Not Found',
            'status' => 400

        ],200);
    }
}

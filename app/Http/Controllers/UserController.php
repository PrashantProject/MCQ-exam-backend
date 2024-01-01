<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request){
       
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:8'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
       
       $User =new User;
       $User->name=$request->name;
       $User->email=$request->email;
       //
       $User->password=Hash::make($request->password);
       $User->save();
       if(!$User){
        return response()->json(['failed' => 'some thing went worng']);
       }
       return response()->json(['sucssec' => 'register Susccuse full']);
    }

    public function login(Request $request){
          $rules = [
            'email' => 'required|email',
            'password'=>'required'
        ];
       $validator = Validator::make($request->all(), $rules);
       $credentials=$request->all();
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return response()->json(['access_token' => $accessToken], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();
         return response()->json(['logout'], 401);;  
    }

    public function user(){
        $user=auth()->user();
        if(!$user){
            return response()->json(['error' => 'Unauthorized'],401);
        }
        $dtl=User::all();
        return response()->json($dtl,200);
    }
}

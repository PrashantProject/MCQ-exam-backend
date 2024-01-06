<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionSet as SET;
use Illuminate\Support\Facades\Validator;
use App\Models\SetToUser;

class QuestionSet extends Controller
{



    public function addSet(Request $request){
        $user=auth()->user();
        if ($user->role!='admin') {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'set_name' => 'required|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
       $set=new SET;
       $set->set_name=$request->set_name;
       $set->title=$request->title;
       $set->instruction=$request->instruction;
       $set->save();
       if(!$set){
        return response()->json(['failed' => 'some thing went worng'],500);
       }
       return response()->json(['sucssec' =>$set],200);
    }



    public function editSet(Request $request){
        $user=auth()->user();
        if ($user->role!='admin') {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'id' => 'required',
            'set_name' => 'required|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $set=SET::find($request->id);
        if(!$set){
            return response()->json(['failed' => 'set note found'],404); 
        }
        $set->set_name=$request->set_name;
        $set->title=$request->title;
        $set->instruction=$request->instruction;
        $set->save();
        if(!$set){
            return response()->json(['failed' => 'some thing went worng'],500);
           }
           return response()->json(['sucssec' =>  $set],200);
    }


    

    public function deletSet(Request $request){
        $user=auth()->user();
        if ($user->role!='admin') {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $set=SET::find($request->id);
        if(!$set){
            return response()->json(['failed' => 'set note found'],404); 
        }
        $set->delete();
        if(!$set){
            return response()->json(['failed' => 'some thing went worng'],500);
        }
           return response()->json(['sucssec' =>"deleted"],200);
    }



    public function setForUser(Request $request){
        $user=auth()->user();
        if ($user->role!='admin') {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'user_id' => 'required',
            'set_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $for=new SetToUser;
        $for->user_id=$request->user_id;
        $for->set_id=$request->set_id;
        $for->save();

        return response()->json(['sucssec' =>"done"],200);
    }


    public function Set(Request $request){
        $user=auth()->user();
        if (!$user) {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        if ($user->role=='admin') {
            $set=SET::with('questions')->with('questions.option')->get();
        }else{
            $set_for=SetToUser::where('user_id',$user->id)->first();
            if(!$set_for){
                return response()->json(['errors' =>'you do not have any set'], 404);
            }
            $set=SET::where('id', $set_for->set_id)->with('questions')->with('questions.option')->get();
        }
        return response()->json($set,200);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionSet as SET;
use Illuminate\Support\Facades\Validator;

class QuestionSet extends Controller
{



    public function addSet(Request $request){
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



    public function Set(Request $request){
        $set=SET::all();
        return response()->json($set,200);
    }
}

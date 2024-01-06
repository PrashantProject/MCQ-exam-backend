<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attempte;

class ExamController extends Controller
{
    public function addAnswer(Request $request){
        $user=auth()->user();
        if (!$user) {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'question_id' => 'required',
            'option_id'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $check=Attempte::where('user_id',$user->id)->where('question_id',$request->question_id)->first();
        if($check){
            $attempt=Attempte::find($check->id);
        }else{
            $attempt=new Attempte;
        }
        $attempt->user_id= $user->id;
        $attempt->question_id=$request->question_id;
        $attempt->option_id=$request->option_id;
        $attempt->save();

        return response()->json(['sucsses' =>'attempted'], 200);
    }



   
}

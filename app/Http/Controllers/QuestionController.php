<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\QuestionSet;
use App\Models\Question;
use App\Models\Option;
use App\Models\Answer;



class QuestionController extends Controller
{
    public function addQuestion(Request $request){
        $user=auth()->user();
        if ($user->role!='admin') {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'set_id' => 'required',
            'question' => 'required',
            'option'=>'required',
            'answer'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if(count($request->option)<$request->answer || $request->answer<0){
            return response()->json(['errors' => 'please selelect valid answer'], 422); 
        }
         $question=new Question;
         $question->set_id=$request->set_id;
         $question->question=$request->question;
         $question->save();
         for($i=0; $i<count($request->option); $i++){
            $option=new Option;
            $option->question_id=$question->id;
            $option->option=$request->option[$i];
            $option->save();
            if(($request->answer)-1==$i){
               $ans=new Answer;
               $ans->question_id=$question->id;
               $ans->option_id=$option->id;
               $ans->save();
            }
         }

         return response()->json(['success' => 'question added'], 201); 
     }
 
     public function editQuestion(Request $request){
        $user=auth()->user();
        if ($user->role!='admin') {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'question_id' => 'required',
            'question' => 'required',
            'option_id'=>'required',
            'option'=>'required',
            'answer'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $update =Question::find($request->question_id);
        $update->question=$request->question;
        $update->save();
        for($i=0; $i<count($request->option); $i++){
            $option=Option::find($request->option_id[$i]);
            $option->option=$request->option[$i];
            $option->save();
            if(($request->answer)-1==$i){
               $ans=new Answer;
               $ans->question_id=$question->id;
               $ans->option_id=$option->id;
               $ans->save();
            }
         }

         return response()->json(['success' => 'question updated'], 200); 

     }
 
 
     public function deleteQuestion(Request $request){
        $user=auth()->user();
        if ($user->role!='admin') {
            return response()->json(['errors' =>'Unauthorized'], 401);
        }
        $rules = [
            'question_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $delete=Question::find($request->question_id);
        if(!$delete){
            return response()->json(['error' => 'question note found'], 404); 
        }
        $delete->delete();

        return response()->json(['sucsses' => 'question deleted'], 200); 
     }
}

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

         return response()->json(['errors' => 'question added'], 201); 
     }
 
     public function editQuestion(Request $request){
         return 'ok';
     }
 
 
     public function deleteQuestion(Request $request){
         return 'ok';
     }
}

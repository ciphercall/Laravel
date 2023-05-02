<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function allAnswered()
    {
        
        $questions = Question::has('answer')
                            ->with('answer','item','user')
                            ->where('seller_id',auth('seller')->user()->id)
                            ->orderByDesc('id')
                            ->paginate(10);

        return view('seller.questions.index',compact('questions'));
    }

    public function allUnanswered()
    {
        $questions = Question::whereDoesntHave('answer')
                            ->with('item','user')
                            ->where('seller_id',auth('seller')->user()->id)
                            ->orderByDesc('id')
                            ->paginate(10);
        // dd($questions);
        return view('seller.questions.unanswered',compact('questions'));
    }

    public function answer(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|exists:questions,id',
            'answer' => 'required|string',
        ]);
    
        $seller = auth('seller')->user();
        $question = Question::findOrFail($request->id);
        if($seller->id == $question->seller_id){
            $question->answer()->create([
                'question_id' => $question->id,
                'answer'      => $request->answer
            ]);

            return redirect()->back()->with('success','Answer added successfully.');
        }
        return redirect()->back()->with('error','Operation not allowed');
    }
}

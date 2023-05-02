<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('answer','user','seller')->orderBy('id','desc')->paginate(20);

        return view('admin.question.index',compact('questions'));
    }
    public function approve(Request $request,Question $question)
    {
        $question->approved = !$question->approved;
        $question->update();

        return redirect()->back()->with(['status' => 'Question Status Updated successfully.']);
    }
}

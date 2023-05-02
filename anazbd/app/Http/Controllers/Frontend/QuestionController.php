<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, $productSlug)
    {
        $this->validate($request,[
            'question' => 'required|string|min:10',
        ]);

        if(auth('web')->check()){
            $user = auth('web')->user();
            $product = Item::where('slug',$productSlug)->first();
            if(!$product)
                return redirect()->back();
            
            Question::create([
                'user_id'   => $user->id,
                'item_id'   => $product->id,
                'seller_id' => $product->seller_id,
                'question'  => $request->question,
                'approved'  => false
            ]);

            notify('Question added. Waiting for approve.');
            return redirect()->back();
        }
        return redirect()->back()->withErrors(['status' => 'Error posting question. try again']);
    }
}

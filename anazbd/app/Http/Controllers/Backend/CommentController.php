<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Mckenziearts\Notify\Facades\LaravelNotify;

class CommentController extends Controller
{


    public function __construct()
    {

    }

    public function unpublished()
    {
        return view('backend.commnets.unpublished',['comments' => Comment::where('status',false)->paginate(20)]);
    }

    public function published()
    {
        return view('backend.commnets.published',['comments' => Comment::status()->paginate(20)]);
    }

    public function show($id)
    {
        // dd($id,Comment::where('id',$id)->first());
        $comment = Comment::findorFail($id);
        $comment->load('item','user');
        return view('backend.commnets.show',compact('comment'));
    }

    public function approve($id)
    {
        $comment = Comment::findorFail($id);
        if($comment->status == false){
            $comment->update([
                'status' => true,
            ]);
        }
        //rating here
        $this->rating($comment);

        return redirect()->route('backend.comment.unpublished')->with('message',"Comment Approved Successfully.");
    }

    private function rating($comment)
    {
        try {
            $rating = Comment::where('item_id',$comment->item_id)->sum('rating');
            $users  = Comment::where('item_id',$comment->item_id)->count('user_id');

            Item::findorFail($comment->item_id)->update([
               'rating' => ( round($rating/$users) <= round(2) ? round(2) : round($rating/$users) )
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($id)
    {
        $commnet = Comment::findorFail($id);

        if((strpos(url()->previous(), 'unpublished')  !== false) && (strpos(url()->previous(), 'show')  !== true))
        {
            $commnet->delete();
            return redirect()->route('backend.comment.unpublished')->with('message',"Comment deleted Successfully.");
        }
        elseif((strpos(url()->previous(), 'published')  !== false) && (strpos(url()->previous(), 'show')  !== true)){

            $commnet->delete();
            return redirect()->route('backend.comment.published')->with('message',"Comment deleted Successfully.");
        }
        else{
            if((strpos((string)($commnet->status), '0')  !== false) && (strpos(url()->previous(), 'show')  !== false)){

                $commnet->delete();
                return redirect()->route('backend.comment.unpublished')->with('message',"Comment deleted Successfully.");

            } else{

                $commnet->delete();
                return redirect()->route('backend.comment.published')->with('message',"Comment deleted Successfully.");

            }
        }
    }
}

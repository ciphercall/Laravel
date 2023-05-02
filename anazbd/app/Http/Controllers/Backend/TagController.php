<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::latest()->paginate(20);
        return view('admin.tags.index',compact('tags'));
    }

    public function create()
    {
        return view('backend.tag.create');
    }


    public function store(StoreRequest $request)
    {
        Tag::updateOrCreate(['id'=>$request->id],$request->all());
        $status = "Created";
        if($request->has('id')){
            $status = "Updated";
        }
        return redirect()->back()->with('message',"Tag $status Successfully.");
    }

    public function edit(Tag $tag)
    {
        return view('backend.tag.edit',compact('tag'));
    }


    public function update(UpdateRequest $request,Tag $tag)
    {
        $tag->update($request->all());
        return redirect()->route('backend.product.tags.index')->with('message','Tag Updated Successfully.');
    }


    public function destroy(Tag $tag)
    {
        $tag->delete($tag);
        return redirect()->back()->with('message','Tag Deleted Successfully.');
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Quickpage\QuickpageRequest;
use App\Http\Requests\Quickpage\QuickpageUpdateRequest;
use App\Models\QuickPage;

class QuickPageController extends Controller
{

    public function index()
    {
       $pages = QuickPage::latest()->paginate(10);
       return view ('admin.site-config.quick-page.index',compact('pages'));
    }

    public function create()
    {
        $page = null;
        return view('admin.site-config.quick-page.form',compact('page'));
    }

    public function store(QuickpageRequest $request)
    {
        $all = $request->all();
        QuickPage::create($all);
        return  redirect()
                ->route('backend.site_config.quick.page.index')
                ->with('message', 'Quick Page created Successfully.');

    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $page = QuickPage::find($id);
        return view ('admin.site-config.quick-page.form',compact('page'));
    }


    public function update(QuickpageUpdateRequest $request,QuickPage $quickPage)
    {
        $quickPage->update($request->all());
        return redirect()->route('backend.site_config.quick.page.index')->with('message', 'Quick Page updated Successfully.');
    }

    public function destroy($id)
    {
        $page = QuickPage::find($id);
        $page->delete();
        return back()->with('error', 'Quick Page deleted Successfully!.');
    }
}

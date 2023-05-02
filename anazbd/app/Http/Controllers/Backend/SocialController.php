<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sociallink;
// use App\Http\Requests\Social\SocialRequest;

class SocialController extends Controller
{
    
	public function index($value='')
	{
		return view('admin.social-links.index');
	}

    // public function createupdate(SocialRequest $socialRequest, $id = null )
    public function createupdate(Request $request, $id = null )
    {
      Sociallink::updateOrCreate([
        'id' => $id
      ],$request->all());
      return redirect()->back();
    
    }
}

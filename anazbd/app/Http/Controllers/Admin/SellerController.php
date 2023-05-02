<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::latest()->paginate(20);
        return view('admin.users.sellers.index', compact('sellers'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionalOffer;
use Illuminate\Http\Request;

class PromotionalOfferController extends Controller
{
    public function index()
    {
        $offers = PromotionalOffer::paginate(20);
        return view('admin.promotional-offer.index',compact('offers'));
    }

    public function create()
    {
        return view('admin.promotional-offer.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}

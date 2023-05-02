<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankInfo;
use App\Models\Category;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use NabilAnam\SimpleUpload\SimpleUpload;
use DB;

class SellerBankInfoController extends Controller
{

    public function sellerBankInfo(){

        return view('seller.profile.bank-info',[
            'bankNames' => BankInfo::all(),
        ]);
    }

    public function addSellerBankInfo(Request $request, $id=null){
        // dd($request->all());
        $this->validate($request,[
            'account_title' => 'required|string|min:6',
            'account_number' => 'required|numeric|min:10',
            'bank_name' => 'required',
            'barnch_name' => 'required|string|min:6',
            'routing_number' => 'required|numeric|min:7',
            'cheque_copy' => 'required|mimes:jpg,png,jpeg,pdf,doc,docx'
        ]);
        $chequeCopy = $request->file('cheque_copy');
        if(isset($id)){
            $accountInfo = BankAccount::find($request->id);
            if(isset($chequeCopy)){

                $accountInfo['cheque_copy'] = (new SimpleUpload)->file($request->cheque_copy)
                    ->dirName('bank-cheque')->deleteIfExists($accountInfo->cheque_copy)
                    ->save();
            }
            $accountInfo->account_title = $request->account_title;
            $accountInfo->account_number = $request->account_number;
            $accountInfo->bank_name = $request->bank_name;
            $accountInfo->barnch_name = $request->barnch_name;
            $accountInfo->routing_number = $request->routing_number;
            $accountInfo->save();
            return redirect('/seller/profile/bank-info');
        }else{
            $all = $request->all();
            $all['cheque_copy'] = (new SimpleUpload)->file($request->cheque_copy)
                ->dirName('bank-cheque')
                ->save();
            BankAccount::create($all);
            return redirect('/seller/profile/bank-info');
        }

    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Delivery;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentAllocatedArea;
use App\Models\AgentExtendArea;
use App\Models\City;
use App\Models\Division;
use App\Models\PostCode;
use App\Traits\ImageOperations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use NabilAnam\SimpleUpload\SimpleUpload;

class AgentController extends Controller
{
    use ImageOperations;
    public function index()
    {
        $agents =  Agent::paginate(20);
        return view('backend.agent.index',compact('agents'));
    }


    public function create()
    {
        $divisions  = Division::get(['id','name']);
        return view('backend.agent.create',compact('divisions'));
    }

    public function store(Request $request,SimpleUpload $upload, Agent $agent, Delivery $delivery)
    {

        $data               =   $request->all();
        $data['password']   =   Hash::make($request->password);
        $delivery_id        =   $delivery->create($data)->id;

        $data['phone']      =   $request->mobile;
//        $data['logo']       =   $upload->file($request->logo)
//                                        ->dirName('agents')
//                                        ->resizeImage('40','40')
//                                        ->save();
        if ($request->hasFile('logo')){
            $data['logo']       =   $this->saveImage('agents',$request->logo,'agent',false);
        }
        $data['delivery_id']=   $delivery_id;
        $agent_id           =   $agent->create($data)->id;

        $allocated          =   $this->agentallocated($request,$agent_id);
        $extendarea         =   $this->extendarea($request,$agent_id);

        AgentAllocatedArea  ::insert($allocated);
        AgentExtendArea     ::insert($extendarea);
        return redirect()->route('backend.agent.index')->with('message','Agent Added Successfully');

    }

    private function agentallocated($request,$agent_id)
    {
        $allocated = [];

        foreach($request->aarea_id as $area_id)
        {
            if(!empty($request->adiv_id))
            {
                    $allocated[] = [
                        'agent_id'      => $agent_id,
                        'division_id'   => $request->adiv_id,
                        'city_id'       => $request->acity_id,
                        'post_id'       => $area_id,
                    ];
            }
        }
        return $allocated ;

    }

     private function extendarea($request,$agent_id)
    {
        $extendarea = [];

        foreach($request->exarea_id as $area_id)
        {
            if(!empty($request->adiv_id))
            {
                    $extendarea[] = [
                        'agent_id'      => $agent_id,
                        'division_id'   => $request->exdiv_id,
                        'city_id'       => $request->excity_id,
                        'post_id'       => $area_id,
                    ];
            }
        }
        return $extendarea ;

    }


    public function show(Agent $agent)
    {
        return view('backend.agent.show',compact('agent'));
    }


    public function edit(Agent $agent)
    {
        $divisions  = Division::get(['id','name']);
        $cities     = City::get(['id','name']);
        $postcodes  = PostCode::get(['id','name']);
        return view('backend.agent.edit',compact('agent','divisions','cities','postcodes'));
    }


    public function update(Request $request,SimpleUpload $upload, Agent $agent)
    {

        $data           =   $request->all();
        $data['phone']  =   $request->mobile;
//        $data['logo']   =   $upload->file($request->logo)
//                                    ->dirName('agents')
//                                    ->deleteIfExists($agent->logo)
//                                    ->save();
        if ($request->hasFile('logo')){
            $data['logo']   =   $this->updateImage($agent->logo,$request->logo,"agents","agent");
        }

        $agent->update($data);


        // $allocateds      =   $this->agentallocated($request, $agent->id);

        // dd($allocated);
        // $extendarea     =   $this->extendarea($request, $agent->id);
        // $oldallcated    = AgentAllocatedArea::where('agent_id',$agent->id)->get();


        // dd($allocated);
        // dd(AgentAllocatedArea::first());

        // AgentExtendArea::where('agent_id',$agent->id)->update($extendarea)

         return redirect()->route('backend.agent.index')->with('message','Agent Updated Successfully');
    }


    public function destroy($id)
    {
        //
    }
    public function locatedarea($cityId)
    {
        $data = PostCode::where('city_id',$cityId)->get(['id','name']);
        return response()->json($data);
    }


    private function delivery(){

    }
}

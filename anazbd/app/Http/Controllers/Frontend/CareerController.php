<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerStore;
use App\Job;
use App\Models\Division;
use App\Models\Career;
use App\Models\CareerEducation;
use App\Traits\ImageOperations;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    use ImageOperations;
    
    public function index(Request $request)
    {
        $jobs = Job::where('status',true)
        ->when($request->title, function ($q) use ($request) {
            $q->where('title', 'LIKE', '%' . $request->title . '%');
        })
        ->when($request->location, function ($q) use ($request) {
            $q->where('location', 'LIKE', '%' . $request->location . '%');
        })
        ->latest()->simplePaginate(6);
        $divisions = Division::get(['name']);
        return view('frontend.pages.career',compact('jobs','divisions'));
    }

    public function apply($slug = null)
    {
        $job = Job::where('slug',$slug)
        ->whereDate('deadline','>',Carbon::now()->format("Y-m-d"))
        ->where('status',true)->first();
        if($job){
            $divisions = Division::get(['name']);
            return view('frontend.pages.career-apply',compact(['divisions','job']));
        }else{
            $divisions = Division::get(['name']);
            return view('frontend.pages.career-apply',compact(['divisions','job']))->with('message','Selected Job Circular not found. But Apply in your Area of Interest.');
        }
    }

    public function store(CareerStore $request)
    {
        $data = $request->validated();
        $job_title = "";
        if(array_key_exists("job_post",$data)){
            $job = Job::where('slug',$data['job_post'])->whereDate('deadline','>',Carbon::now()->format("Y-m-d"))->where('status',true)->first();
            $data["job_id"] = $job->id;
            foreach(explode(" ",$job->title) as $word){
                $job_title .= $word[0];
            }
        }else{
            foreach(explode(" ",$data["a_o_i"]) as $word){
                $job_title .= $word[0];
            }
        }
        if($request->has('image')){
            $data['image'] = $this->saveImage('career/'.$job_title."-".$request->email,$request->image,'image');
        }
        if($request->has('resume')){
            $data['resume'] = $this->saveImage('career/'.$job_title."-".$request->email,$request->resume,$job_title.'-resume-'.$request->email);
        }
        $career = Career::create($data);
        foreach($request->education_level ?? [] as $i => $data){
            CareerEducation::create([
                'career_id'      => $career->id,
                'institute_name' => $request->institute_name[$i],
                'gpa'            => $request->gpa[$i],
                'education_level' => $data,
                'passing_year' => $request->passing_year[$i],
                'location' => $request->location[$i]
            ]);
        }
        return redirect()->back()->with('success',"Your Records are Saved Successfully. We'll Contact You Soon.");
    }
}

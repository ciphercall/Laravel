<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\Store;
use App\Http\Requests\Job\Update;
use App\Job;
use App\Models\Career;
use App\Models\Division;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $model;

    public function __construct(Job $job)
    {
        $this->model = new Repository($job);
    }

    public function index()
    {
        $jobs = Job::withCount('applications')->latest()->paginate(15);
        return view('admin.jobs.index',compact('jobs'));
    }

    public function create()
    {
        $divisions = Division::get('name');
        return view('admin.jobs.create',compact('divisions'));
    }

    public function store(Store $request)
    {
        $data = $request->validated();
        $data["slug"] = az_slug($data["title"]."-".time());
        $this->model->create($data);
        return redirect()->route('jobs.index')->with("success","New Job Posting Created");
    }

    public function edit($id)
    {
        $job = $this->model->show([],$id);
        $divisions = Division::get('name');
        return view('admin.jobs.edit',compact('job','divisions'));
    }

    function show(Job $job){
        $job->LoadCount('applications');
        $career = Career::where('job_id',$job->id)->paginate(20);

        return view('admin.jobs.show',compact(['job','career']));
    }

    public function toggleStatus($id)
    {
        $job = Job::findOrFail($id);
        $job->status = !$job->status;
        $job->update();

        return redirect()->route('jobs.index')->with("success","Job Status Updated.");

    }

    public function update(Update $request,Job $job)
    {
        $data = $request->validated();
        $data["slug"] = az_slug($data["title"]."-".time());
        $this->model->update($data,$job->id);
        return redirect()->route('jobs.index')->with("success","Job Info Updated.");

    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with("success","Job Post Deleted.");
    }
}

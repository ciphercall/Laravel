@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">work</i> Show Job Post
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">

                <div class="card-header-primary">
                    {{ $job->title }} <sup><span class="badge badge-success">{{$job->applications_count}}</span></sup> <div class="text-right"><a href="{{ route('jobs.index') }}" class="btn btn-sm btn-primary">All Jobs</a></div>
                </div>
                    <div class="row card-body">

                        <div class="col-6 bg my-3">
                            <div class="row">
                                <div class="col-4 text-left">
                                    Title:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->title}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Salary:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->salary}} TK
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Experience:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->experience}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Min. Qualification:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->min_qualification}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Department:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->department}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Job Type:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->job_type}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Gender:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->gender ?? 'N/A'}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Deadline:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->deadline}} <br>
                                    <span class="text-muted" style="font-size: 7pt">{{$job->deadline->diffForHumans()}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Job Status:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->status ? "Live" : "Drafted"}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Contact Email:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->contact_email}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Contact Mobile:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->contact_mobile}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-left">
                                    Note:
                                </div>
                                <div class="col-8 text-left">
                                    {{$job->note}}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 bg my-3">
                            <h5>Description:</h5>
                            {!! $job->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-12 card">
            <div class="card-header-primary text-center">Application's for {{$job->title}}</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Personal Info</th>
                            <th>Perferred Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($career as $application)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <img src="{{asset($application->image)}}" width="150px" height="150px" class="img img-thumbnail" alt="Image">
                                        </div>
                                        <div class="col-6">
                                            <b>{{$application->name}}</b><br>
                                            <a href="tel:+{{$application->phone}}">{{$application->phone}}</a><br>
                                            <a href="mailto:{{$application->email}}">{{$application->email}}</a>
                                            <p>{{ $application->address }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$application->perferred_location}}</td>
                                <td>
                                    <a href="{{asset($application->resume)}}">Resume</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$career->links()}}
            </div>
        </div>
    </div>
    </div>
@endsection



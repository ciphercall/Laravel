@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">work</i> Jobs
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">

                <div class="card-header-primary">
                    All Jobs <div class="text-right"><a href="{{ route('jobs.create') }}" class="btn btn-sm btn-primary">Post New Job</a></div>
                </div>
                <div class="row card-body">
                    <div class="col card bg m-3">
                        <table class="table table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">SL</th>
                                    <th width="15%">Title</th>
                                    <th width="10%">Experience</th>
                                    <th width="10%">Salary</th>
                                    <th width="10%">Department</th>
                                    <th width="15%">Deadline</th>
                                    <th width="10%">Live</th>
                                    <th width="10%">Applied</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job)
                                    <tr>
                                        <td>{{ ($jobs->total()-$loop->index)-(($jobs->currentpage()-1) * $jobs->perpage() ) }}</td>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ $job->experience }}</td>
                                        <td>{{ $job->salary }}</td>
                                        <td>{{ $job->department }}</td>
                                        <td>{{ Carbon\Carbon::parse($job->deadline)->format("d-m-Y") }}</td>
                                        <td><span class="badge @if($job->status) badge-success @else badge-warning @endif">@if($job->status) Live @else Drafted @endif</span></td>
                                        <td>{{ $job->applications_count }}</td>
                                        <td>
                                            <div class="row justify-content-center">
                                                @if($job->status)
                                                    <a onclick="return confirm('Are You Sure ?')" href="{{ route('jobs.status.toggle',$job->id) }}" class="btn btn-sm btn-info">Deactivate</a>
                                                @else
                                                    <a onclick="return confirm('Are You Sure ?')" href="{{ route('jobs.status.toggle',$job->id) }}" class="btn btn-sm btn-primary">Activate</a>
                                                @endif
                                                <a href="{{ route('jobs.edit',$job->id) }}" class="btn btn-sm btn-warning"><i class="material-icons">edit</i></a>
                                                <a href="{{ route('jobs.show',$job->id) }}" class="btn btn-sm btn-primary"><i class="material-icons">visibility</i></a>
                                                <form action="{{ route('jobs.destroy',$job)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure to Delete This Job Post ?')"><i class="material-icons">delete</i></button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


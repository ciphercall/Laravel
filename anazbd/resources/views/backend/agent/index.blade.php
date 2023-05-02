{{--  @extends('backend.layouts.master')  --}}
@extends('admin.layout.master')

@section('title','Agent List')
@section('page-header')
    <i class="fa fa-list"></i> Agent List
@stop

@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'Create agent',
       'route' => route('backend.agent.create')
    ])  --}}
    <div class="row">
        <div class="col">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Delivery Agents</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.agent.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus">&nbsp; New Agent</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="simple-table" class="table  table-bordered table-hover">

                        <thead>
                            <tr>
                                <th class="bg-dark" style="">SL</th>
                                <th class="bg-dark" style="">Name</th>
                                <th class="bg-dark" style="width:20%">Phone/ Email</th>
                                <th class="bg-dark" style="width:5%">Type</th>
                                <th class="bg-dark" style="width:15%">Address</th>
                                <th class="bg-dark" style="width:10%">Image</th>
                                {{-- <th class="bg-dark" style=""> </th> --}}
                                <th class="bg-dark" style="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agents as $key => $agent)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $agent->name }}</td>
                                    {{-- <td>{{ $agent->phone }}</td> --}}
                                <td>{{ $agent->phone??" "}}<br>{{$agent->email??' '}}</td>
                
                                    {{-- <td>{{ }}</td> --}}
                                    {{-- <td></td> --}}
                                    {{-- @dd($agent->type) --}}
                                    <td class="hidden-480">
                                        @if($agent->type == 'personal')
                                            <span class="label label-sm label-success">Personal</span>
                                        @else
                                            <span class="label label-sm label-warning">Business</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $agent->address }}
                                    </td>
                                    <td>
                                        <img src="{{ asset($agent->logo) }}" alt="{{ asset($agent->logo) }}" width="100px" height="100px">
                                    </td>
                
                                    <td>
                                        <div class="btn-group btn-group-mini btn-corner">
                
                                            <a href="{{ route('backend.agent.show', $agent->id) }}"
                                                class="btn btn-xs btn-info"
                                                title="Show data"
                
                                                >
                                                 <i class="ace-icon fa fa-eye"></i>
                                            </a>
                
                                            <a href="{{ route('backend.agent.edit', $agent->id) }}"
                                               class="btn btn-xs btn-warning"
                                               title="Edit">
                                                <i class="ace-icon fa fa-edit"></i>
                                            </a>
                
                                            <button type="button" class="btn btn-xs btn-danger"
                                                    onclick="delete_check({{$agent->id}})"
                                                    title="Delete">
                                                <i class="ace-icon fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('backend.agent.destroy', $agent->id)}}"
                                              id="deleteCheck_{{ $agent->id }}" method="DELETE">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">No data available in table</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$agents->links()}}
                </div>
            </div>
        </div>
    </div>

    {{--  @include('backend.partials._paginate', ['data' => $agents])  --}}
@endsection

@push('js')
    <script type="text/javascript">
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })
        }
    </script>
@endpush

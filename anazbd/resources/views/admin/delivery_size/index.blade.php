@extends('admin.layout.master')
@section('title','Delivery Size List')
@section('page-header')
    <i class="fa fa-list"></i> Delivery Size List
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
    <div class="row">
        <div class="col-7">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Delivery Sizes
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>
                                    <table>
                                        <tr>
                                            <td colspan="2">Customer</td>
                                        </tr>
                                        <tr>
                                            <td>CTG</td>
                                            <td>Other</td>
                                        </tr>
                                    </table>
                                </th>
                                <th><table>
                                    <tr>
                                        <td colspan="2">Agent</td>
                                    </tr>
                                    <tr>
                                        <td>CTG</td>
                                        <td>Other</td>
                                    </tr>
                                </table></th>
                                <th>Action</th>
                            </tr>
                            @forelse($sizes as $key => $size)
                                <tr>
                                    <td>{{($sizes->total()-$loop->index)-(($sizes->currentpage()-1) * $sizes->perpage())}}</td>
                                    <td>{{ $size->name }}</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>{{ $size->customer_dhaka }}</td>
                                                <td>{{ $size->customer_other }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>{{ $size->agent_dhaka }}</td>
                                                <td>{{ $size->agent_other }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-minier btn-corner">
                                            {{-- <a href="{{ route('backend.econfig.delivery-size.edit', $size->id) }}"
                                               class="btn btn-xs btn-info"
                                               title="Edit">
                                                <i class="ace-icon fa fa-edit"></i>
                                            </a> --}}
                                            <button class="btn btn-xs btn-warning" id="editBtn" 
                                            data-id="{{ $size->id }}"
                                            data-customer_dhaka="{{ $size->customer_dhaka }}"
                                            data-customer_other="{{ $size->customer_other }}"
                                            data-agent_dhaka="{{ $size->agent_dhaka }}"
                                            data-agent_other="{{ $size->agent_other }}"
                                            data-name="{{ $size->name }}"
                                            ><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger"
                                                    onclick="delete_check({{$size->id}})"
                                                    title="Delete">
                                                <i class="ace-icon fa fa-trash"></i>
                                            </button>
                                        </div>
                
                                        <form action="{{ route('backend.econfig.delivery-size.destroy', $size->id)}}"
                                              id="deleteCheck_{{ $size->id }}" method="GET">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No data available in table</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $sizes->links() }}
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> Warranty
                </div>
                <div class="card-body">
                    <form id="form" action="{{route('backend.econfig.delivery-size.store')}}" method="POST">
                        @csrf
                        @if(old('id') > 0)
                            <input type="hidden" id="model_id" name="id" value="{{ old('id') }}">
                        @endif
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Customer (CTG)</label>
                                <input type="text" class="form-control" name="customer_dhaka" id="customer_dhaka" value="{{ old('customer_dhaka') }}">
                                @error('customer_dhaka') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Customer (Other)</label>
                                <input type="text" class="form-control" name="customer_other" id="customer_other" value="{{ old('customer_other') }}">
                                @error('customer_other') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Agent (CTG)</label>
                                <input type="text" class="form-control" name="agent_dhaka" id="agent_dhaka" value="{{ old('agent_dhaka') }}">
                                @error('agent_dhaka') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Agent (Other)</label>
                                <input type="text" class="form-control" name="agent_other" id="agent_other" value="{{ old('agent_other') }}">
                                @error('agent_other') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <button id="resetBtn" type="reset" class="btn btn-sm"><i class="fa fa-times"></i> Reset</button>
                        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript">
        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let customerDhaka = $(this).data('customer_dhaka');
            let customerOther = $(this).data('customer_other');
            let agentDhaka = $(this).data('agent_dhaka');
            let agentOther = $(this).data('agent_other');
            $('#model_id').remove();
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#name').val(name);
            $('#customer_dhaka').val(customerDhaka);
            $('#customer_other').val(customerOther);
            $('#agent_dhaka').val(agentDhaka);
            $('#agent_other').val(agentOther);
            $('#form-title').html('Edit');
        });
        $(document).on('click','#resetBtn',function(){
            $('#form-title').html('New');
            $('#name').val('');
            $('#customer_dhaka').val('');
            $('#customer_other').val('');
            $('#agent_dhaka').val('');
            $('#agent_other').val('');
            $('#model_id').remove();
        });
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

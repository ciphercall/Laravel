@extends('admin.layout.master')
@section("title","All Offers")
@section('page_header')
    <i class="material-icons">confirmation_number</i> All Coupons
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                
                <div class="card-header-primary">
                    Offers List
                    <a href="{{ route('admin.campaign.coupons.create') }}" class="text-white btn-sm" style="float: right"><i class="material-icons">add</i> New Coupon</a>
                </div>
                <div class="card-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>On</th>
                                <th>Valid For</th>
                                <th>Value</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Max Use</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ ($coupons->total()-$loop->index)-(($coupons->currentpage()-1) * $coupons->perpage() ) }}</td>
                                    <td>{{ $coupon->name }}</td>
                                    <td>{{ $coupon->type }}</td>
                                    <td>{{ $coupon->on }}</td>
                                    <td><span class="badge badge-primary">{{ $coupon->couponExtra != null ? $coupon->couponExtra->couponable->name : "" }}</span></td>
                                    <td>{{ $coupon->value }}</td>
                                    <td>{{ Carbon\Carbon::parse($coupon->from)->format('d-m-Y h:m A') }}</td>
                                    <td>{{ Carbon\Carbon::parse($coupon->to)->format('d-m-Y h:m A') }}</td>
                                    <td>{{ $coupon->max_use }}</td>
                                    <td>{{ $coupon->is_active }}</td>
                                    <td>
                                        <a href="{{ route("admin.campaign.coupons.edit",$coupon->id) }}" class="btn btn-sm btn-primary"><i class="material-icons">edit</i></a>
                                        <button data-id="{{ $coupon->id }}" id="deleteBtn" class="btn btn-sm btn-danger"><i class="material-icons">delete</i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $(document).on('click',"#deleteBtn",function(e){
                e.preventDefault();
                let id = $(this).data('id');
                if(confirm("Are you sure to delete this coupon ?")){
                    let url = "{{ url('/admin/coupons/destroy/') }}"
                    window.location.href = url+"/"+id
                }
            });
        });
    </script>
@endpush
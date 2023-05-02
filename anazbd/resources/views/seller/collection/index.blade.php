@extends('material.layouts.master')
@section('title','Collections List')
@section('page_header')
    <i class="fa fa-th"></i> Collection
@stop
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    {{--  @include('seller.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'Create Item',
       'route' => route('seller.product.items.create')
    ])  --}}
    <div class="card">
        <div class="card-header card-header-success">
            <h4 class="card-title">All Items</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                    <tr>
                        <th >SL</th>
                        <th >Collection Name</th>
                        <th >Image</th>
                        <th >Items</th>
                        <th >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($collections as $key => $item)
                        <tr>
                            <td>{{ ($collections->total()-$loop->index)-(($collections->currentpage()-1) * $collections->perpage() ) }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <img src="{{ asset($item->cover_photo) }}"
                                     height="30"
                                     width="120"
                                     alt="No Image">
                            </td>
                            <td>{{ $item->items_count }}</td>
                            <td>
                                <a href="{{route('seller.product.collection.create',az_hash($item->id))}}" class="btn btn-sm btn-primary">Add Item</a>
                                <a href="{{route('seller.product.collection.edit',az_hash($item->id))}}" class="btn btn-sm btn-warning">Update / Delete Item</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No data available in table</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $collections->links() }}
            {{--  @include('seller.partials._paginate', ['data' => $items])  --}}
        </div>
    </div>
@endsection


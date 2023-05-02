@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> New Order
@endsection
@section('title','New Order')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary">
                    Make New Order
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        @csrf
                        {{--  // select User ( auto populates delivery address area too )  --}}

                        {{--  // add Items  --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



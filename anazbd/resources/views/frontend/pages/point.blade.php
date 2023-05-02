@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Point Redeem
@endsection
@section('content')
     <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li>{{ collect(request()->segments())->last() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--about bg area start-->
    <div class="about_bg_area">
        <div class="container">

            <!--services img area-->
            <div class="about_gallery_section mb-55">
                <div class="row">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8 ">
                                <h3>Current Points: {{$point->amount}}</h3>
                                <hr>
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover text-center">
                                            <thead>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Value (TK)</th>
                                                <th>Status</th>
                                                <th>Validity</th>
                                            </thead>
                                            <tbody>
                                                @forelse($redeems as $index => $item) 
                                                    <tr>
                                                        <td>{{ $redeems->count() - $index }}</td>
                                                        <td>{{ $item->code }}</td>
                                                        <td>{{ $item->value }}</td>
                                                        <td>{{ $item->status }}</td>
                                                        <td>{{ $item->valid_till->format('d M Y h:i A') }} <br> <small class="text-muted">{{ $item->valid_till->diffForHumans() }}</small></td>
                                                    </tr>
                                                @empty 
                                                    <tr>
                                                        <td colspan="5">No Redeem Codes Found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                @if($point->amount > 0)
                                <h3>Redeem Points</h3>
                                <hr>
                                <form action="{{ route('user.account.point.redeem') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Point</label>
                                        <input type="number" name="point" placeholder="Enter The Amount of Points" class="form-control" required min="100" max="{{ $point->amount }}">
                                        @error('point') <small class="text-danger">{{ $message }}</small> @else <small class="text-muted">Amount of points must be less than current points.</small> @enderror
                                    </div>
                                    <hr>
                                    <div class="col-12 text-right">
                                        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                                    </div>
                                </form>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--services img end-->

        </div>
    </div>
    <!--about bg area end-->
@endsection

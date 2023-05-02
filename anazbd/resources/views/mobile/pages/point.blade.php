@extends('mobile.layouts.master')
@section('title')
    User Point
@endsection
@section('mobile')
    <!--wishlist area start -->
    <div class="wishlist_page_bg">
        <div class="container">
            <div class="row"><h4>Point Redeem</h4></div>

            <div class="wishlist_area">
                <div class="wishlist_inner">
                            <div class="row">
                                <div class="col-12">
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
                                <div class="col-12 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3>Current Points: {{$point->amount}}</h3>
                                            <hr>
                                            <table class="table table-responsible table-hover text-center">
                                                
                                                <tbody>
                                                    @forelse($redeems as $index => $item) 
                                                        <tr >
                                                            <div class="card card-body shadow rounded">
                                                                Code: {{$item->code}} <br>
                                                                Value: {{ $item->value }} TK <br>
                                                                <div class="row">
                                                                    <div class="col-12">Status: <span class="col-3 badge badge-{{$item->status == 'Active' ? 'success' : 'danger'}}">{{$item->status}}</span></div>
                                                                </div>
                                                                <div class="col-12">

                                                                    Validity: {{ $item->valid_till->format('d M Y h:i A') }} <br>
                                                                    <small style="font-size: 9px;" class="text-muted">{{ $item->valid_till->diffForHumans() }}</small>
                                                                </div>
                                                            </div>
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
                            </div>
                        </div>
            </div>
        </div>
    </div>


    <!--wishlist area end -->
@endsection
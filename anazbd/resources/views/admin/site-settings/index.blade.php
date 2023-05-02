@extends('admin.layout.master')
@section('title','Update Site Configurations')
@section('page_header')
    <i class="material-icons">edit</i> Site Configurations
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-7 col-md-7">
            <div class="card">
                <div class="card-header-primary">Current Configurations</div>
                <div class="card-body">
                    <form action="{{ route('admin.site.setting.store') }}" method="POST">
                        @csrf
                        @if ($config != null)
                            <input type="hidden" name="id" value="{{ $config->id }}">
                        @endif
                        <div class="row">
                            <div class="col form-group">
                                <input type="checkbox"
                                @if ($config != null && $config->is_cashback_enabled == true)
                                    checked="checked"
                                @endif
                                id="is_cashback_enable" name="is_cashback_enabled" value="true">
                                <small for="is_cashback_enable">Enable Cashback</small> <br>
                                <input type="checkbox"
                                @if ($config != null && $config->is_point_reward_enabled == true)
                                    checked="checked"
                                @endif
                                id="is_point_reward_enabled" name="is_point_reward_enabled" value="true">
                                <small for="is_point_reward_enabled">Enable Point Reward</small> 
                                <br>
                                <input type="checkbox" {{ $config->is_cod_enabled ? "checked='checked" : '' }} id="is_cod_enable" name="is_cod_enabled" value="true">
                                <small for="is_cod_enable">Enable Cash on Delivery for Everywhere</small>
                            </div>
                            <div class="col form-group">
                                <small for="amount">Cashback Amount</small>
                                <input type="text" name="cashback_amount" class="form-control" value="{{ $config != null ? $config->cashback_amount : "" }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="sr-only" for="inlineFormInputGroup">Point Unit</label>
                                <div class="input-group mb-2">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">1 BDT =</div>
                                  </div>
                                  <input type="text" value="{{ $config->point_unit }}" name="point_unit" class="col-3 form-control" id="inlineFormInputGroup" placeholder="100 Point">
                                  <label class="mt-2">&nbsp;Points</label>
                                </div>
                              </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">save</i></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header-primary">
                    System Notification Subscriber
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $subscriber)
                                <tr class="text-{{$subscriber->status ? 'success':'grey'}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$subscriber->name}}</td>
                                    <td>{{$subscriber->mobile}}</td>
                                    <td>{{$subscriber->email}}</td>
                                    <td>
                                        <a href="{{route('admin.site.subscriber.status',$subscriber->id)}}" class="btn btn-sm btn-{{$subscriber->status ? 'warning':'success'}}">{{$subscriber->status ? 'Deactivate':'Activate'}}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Subscriber Found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$subscribers->links()}}
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5">
            <div class="card">
                <div class="card-header-primary">
                    New System Notification Receiver
                </div>
                <div class="card-body">
                    <form action="{{route('admin.site.subscriber.store')}}" class="form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="">Name<sup class="text-danger">*</sup></label>
                                <input required value="{{old('name')}}" type="text" name="name" class="form-control">
                                @error('name') <small class="text-danger">{{$message}}</small> @enderror
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Mobile<sup class="text-danger">*</sup></label>
                                <input required value="{{old('mobile')}}" type="text" name="mobile" class="form-control">
                                @error('mobile') <small class="text-danger">{{$message}}</small> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="">Email</label>
                                <input value="{{old('email')}}" type="text" name="email" class="form-control">
                                @error('email') <small class="text-danger">{{$message}}</small> @enderror
                            </div>
                            <div class="col-6 form-group">
                                <input type="radio" id="male" name="status" value="1">
                                <label for="male">Active</label><br>
                                <input type="radio" checked="checked" id="female" name="status" value="0">
                                <label for="female">Deactive</label><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button class="btn btn-block btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header-primary">
                    Point Chart
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.point-chart.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Amount</label>
                                <input type="number" required name="amount" value="{{ old('amount') }}" class="form-control">
                                @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Point</label>
                                <input type="number" required name="point" value="{{ old('point') }}" class="form-control">
                                @error('point') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <button class="btn btn-sm" type="reset"><i class="fa fa-times"></i></button>
                                <button class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                            </div>
                        </div>
                    </form>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Amount(&#2547;)</th>
                                            <th>Point</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pointCharts as $item)
                                            <tr>
                                                <td>{{ $item->amount }}</td>
                                                <td>{{ $item->point }}</td>
                                                <td>
                                                    <form action="{{route('admin.point-chart.delete',$item->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No Data Found</td>
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
@endsection

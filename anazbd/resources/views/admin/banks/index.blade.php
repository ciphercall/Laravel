@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">account_balance</i> Banks
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                
                <div class="card-header-primary">
                    All Banks
                </div>
                <div class="row card-body">
                    <div class="col-sm-6 col-md-6 col-lg-6 card bg m-3">
                        <table class="table table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banks as $bank)
                                    <tr>
                                        <td>{{ ($banks->total()-$loop->index)-(($banks->currentpage()-1) * $banks->perpage() ) }}</td>
                                        <td>{{ $bank->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.bankinfo.delete',$bank->id) }}" class="btn btn-sm btn-danger"><i class="material-icons">delete</i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-5 ">
                        <div class="card bg-light text-dark">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <i class="fa fa-plus">Add New Bank</i>
                                    </div>
                                </div>
                                <hr>
                                <form action="{{ route('admin.bankinfo.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-9 my-2">
                                            <input type="text" name="name" placeholder="Name" class="form-control border-primary">
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-primary"><i class="fa fa-save"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


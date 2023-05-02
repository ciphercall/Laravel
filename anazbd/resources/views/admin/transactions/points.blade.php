@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">analytics</i> Point Transactions
@endsection
@section('title','Point Transactions')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    Point Transactions
                </div>
                <div class="row card-body">
                    <div class="col bg m-3">
                        <table class="table table-bodered text-center">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>User</th>
                                <th>Previous Point</th>
                                <th>Point</th>
                                <th>Type</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ ($transactions->total()-$loop->index)-(($transactions->currentpage()-1) * $transactions->perpage() ) }}</td>
                                    <td>{{ $transaction->user->name ?? $transaction->user->mobile }}</td>
                                    <td>{{ $transaction->previous_amount }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->type }}</td>
                                    <td>{{ Str::limit($transaction->note,60) }}</td>
                                    <td>{{ ucwords($transaction->status) }}</td>
                                    <td>{{ $transaction->created_at->format('d-m-y h:i A') }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
@endsection


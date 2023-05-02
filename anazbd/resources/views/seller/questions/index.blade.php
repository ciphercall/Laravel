@extends('material.layouts.master')
@section('title','Answered Questions List')
@section('page-header')
    <i class="material-icons">question_answer</i> Answered Questions List
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
    
<div class="card">
    <div class="card-header-primary">
        <div class="row">
            <div class="col">
                <h5>Answered Questions</h5>
            </div>
            <div class="col text-right">
                <a href="{{ route('seller.questions.answered') }}" class="btn btn-success">View Answered Questions</a>
            </div>
        </div>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th style="width: 4%">SL</th>
                    <th style="width: 14%">User</th>
                    <th style="width: 14%">Item</th>
                    <th style="width: 14%">Question</th>
                    <th style="width: 14%">Answer</th>
                    <th style="width: 14%">Asked At</th>
                    <th style="width: 14%">Answered</th>
                    <th style="width: 12%">Action</th>
                </tr>
                @forelse($questions as $key => $question)
                   <tr>
                        <td>{{ ($questions->total()-$loop->index)-(($questions->currentpage()-1) * $questions->perpage() ) }}</td>   
                        <td>{{ $question->user->name }}</td>   
                        <td>{{ $question->item->name }}</td>   
                        <td>{{ $question->question }}</td>   
                        <td>{{ $question->answer->answer }}</td>   
                        <td>{{ Carbon\Carbon::parse($question->created_at)->format('d-m-y h:i A') }}</td>   
                        <td>{{ Carbon\Carbon::parse($question->answer->created_at)->diffForHumans($question->created_at) }}</td>   
                        <td>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>    
                        </td>   
                    </tr> 
                @empty
                    <tr>
                        <td colspan="8">No data available in table</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $questions->links() }}
        </div>
    </div>
</div>

    {{--  @include('seller.partials._paginate', ['data' => $items])  --}}
@endsection



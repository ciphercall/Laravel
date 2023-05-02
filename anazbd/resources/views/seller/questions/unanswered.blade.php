@extends('material.layouts.master')
@section('title','Unanswered Questions List')
@section('page-header')
    <i class="material-icons">help</i> Unanswered List
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
                <h5>Unanswered Questions</h5>
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
                    <th style="width: 14%">Asked At</th>
                    <th style="width: 12%">Action</th>
                </tr>
                @forelse($questions as $key => $question)
                   <tr>
                        <td>{{ ($questions->total()-$loop->index)-(($questions->currentpage()-1) * $questions->perpage() ) }}</td>   
                        <td>{{ $question->user->name }}</td>   
                        <td>{{ $question->item->name }}</td>   
                        <td>{{ $question->question }}</td>   
                        <td>{{ Carbon\Carbon::parse($question->created_at)->format('d-m-y h:i A') }}</td>   
                        <td>
                            <button id="reply-btn" data-toggle="modal" data-target="#replyModal" data-id="{{ $question->id }}" class="btn btn-sm  btn-warning"><i class="fa fa-reply"></i></button>
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
        </div>
    </div>
</div>
    
    
        <!-- Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Add Reply to the Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('seller.question.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="question-id" value="">

                    <div class="form-group ">
                        <label for="answer">Your Answer</label>
                        <input type="text" name="answer" class="form-control">
                    </div>
                    <hr>
                    <div class="row text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    
                </form>
            </div>
            </div>
        </div>
        </div>
    {{--  @include('seller.partials._paginate', ['data' => $items])  --}}
@endsection

@push('js')
    <script>
        $(document).on('click','#reply-btn',function (){
            $('#question-id').val($(this).data('id'))
        });
    </script>
@endpush



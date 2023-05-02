@extends('admin.layout.master')

@section('title',' Questions List')
@section('page-header')
    <i class="fa fa-list"></i> Questions List
@stop

@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')

    <div class="col-12">
        <div class="card rounded shadow">
            <div class="card-header-primary">
                All Questions
            </div>
            <div class="card-body"> 
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th >SL</th>
                        <th >User</th>
                        <th >seller</th>
                        <th >Item</th>
                        <th >Question</th>
                        <th >Answer</th>
                        <th >Action</th>
                    </tr>
                    @forelse($questions as $key => $question)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $question->user->name }}</td>
                            <td>{{ $question->seller->shop_name }}</td>
                            <td>
                                <a href="{{ route('frontend.product',$question->item->slug) }}" >{{ $question->item->name }}</a>
                            </td>
                            <td>{{ $question->question }}</td>
                            <td>{{ $question->answer ? $question->answer->answer : 'No Answer found' }}</td>
                            <td>
                                <form action="{{ route('backend.questions.approve',$question) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn {{ $question->approved ? 'btn-success' :  'btn-danger' }}">{{ $question->approved ? 'Approved' : 'Hide' }}</button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No data available in table</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $questions->links() }}
            </div>
        </div>
    </div>

    
@endsection



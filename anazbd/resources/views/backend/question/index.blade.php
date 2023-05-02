@extends('backend.layouts.master')

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


    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 10px">SL</th>
            <th class="bg-dark">User</th>
            <th class="bg-dark">seller</th>
            <th class="bg-dark">Item</th>
            <th class="bg-dark">Question</th>
            <th class="bg-dark">Answer</th>
            <th class="bg-dark" style="">Action</th>
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

    @include('backend.partials._paginate', ['data' => $questions])
@endsection



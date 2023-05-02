@extends('admin.layout.master')

@section('title',' Offers Image List')
@section('page-header')
    <i class="fa fa-list"></i> Offers Image List
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
    <div class="row">
        <div class="col-6">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    Offer Images
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                        @forelse($offers as $key => $offer)
                            <tr>
                                <td>{{($offers->total()-$loop->index)-(($offers->currentpage()-1) * $offers->perpage())}}</td>
                                
                                <td>
                                    <img src="{{ asset($offer->image) }}"
                                         height="30"
                                         width="120"
                                         alt="{{$offer->image}}">
                                </td>
                                <td>{{ $offer->position }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        {{--  <a href="{{ route('backend.site_config.offer.edit', $offer->id) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </a>  --}}
                                        <button
                                        class="btn btn-xs btn-info"
                                        id="editBtn"
                                        data-id="{{ $offer->id }}"
                                        data-position="{{ $offer->position }}"
                                        ><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$offer->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.site_config.offer.destroy', $offer->id)}}"
                                          id="deleteCheck_{{ $offer->id }}" method="GET">
                                        @csrf
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
                    {{$offers->links()}}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> Unit
                </div>
                <div class="card-body">
                    <form id="form" enctype="multipart/form-data" action="{{route('backend.site_config.offer.store')}}" method="POST">
                        @csrf
                        @if(old('id') > 0)
                            <input type="hidden" id="model_id" name="id" value="{{ old('id') }}">
                        @endif
                        <div class="my-5">
                            <label for="">Image</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Position</label>
                            <input type="text" class="form-control" name="position" id="position" value="{{ old('position') }}">
                            @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <hr>
                        <button id="resetBtn" type="reset" class="btn btn-sm"><i class="fa fa-times"></i> Reset</button>
                        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript">
        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let position = $(this).data('position');
            $('#model_id').remove();
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#position').val(position);
            $('#form-title').html('Edit');
        });
        $(document).on('click','#resetBtn',function(){
            $('#form-title').html('New');
            $('#position').val('');
            $('#model_id').remove();
        });
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })
        }
    </script>
@endpush

@extends('backend.layouts.master')

@section('title','Slider List')
@section('page-header')
    <i class="fa fa-list"></i> Slider List
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
    @include('backend.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'Slider Create',
       'route' => route('backend.site_config.slider.create')
    ])

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 10px">SL</th>
            <th class="bg-dark" style="width: 40%">Image</th>
            <th class="bg-dark" style="width: 40%">Slug</th>
            <th class="bg-dark" style="">Action</th>
        </tr>
        @forelse($sliders as $key => $slider)
            <tr>
                <td>{{ $key + 1 }}</td>
                
                <td>
                    <img src="{{ asset($slider->image) }}"
                         height="30"
                         width="120"
                         alt="No Image">
                </td>
                <td>{{ $slider->slug }}</td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.site_config.slider.edit', $slider->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$slider->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.site_config.slider.destroy', $slider->id)}}"
                          id="deleteCheck_{{ $slider->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $sliders])
@endsection

@push('js')
    <script type="text/javascript">
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

@extends('backend.layouts.master')

@section('title','Banner List')
@section('page-header')
    <i class="fa fa-list"></i> Banner List
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
       'name' => 'Create Banner',
       'route' => route('backend.site_config.banner.create')
    ])

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 10px">SL</th>
            <th class="bg-dark" style="width: 30%">Image</th>
            <th class="bg-dark" style="width: 20%">Slug</th>
            <th class="bg-dark" style="width: 30%">display Show</th>
            <th class="bg-dark">Action</th>
        </tr>
        @forelse($banners as $key => $banner)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <img src="{{ asset($banner->image) }}"
                         height="30"
                         width="120"
                         alt="No Image">
                </td>
                <td>{{ $banner->slug }}</td>
                <td>
                    <label class=" inline">
                        {{-- <small class="muted smaller-90">Border:</small> --}}

                        {{-- <input id="id-button-borders" checked="checked"  type="checkbox" class="ace ace-switch ace-switch-5 toggle-class"> --}}
                        <input data-id="{{$banner->id}}" class="ace ace-switch ace-switch-5 toggle-class" type="checkbox" data-onstyle="success"
                        data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $banner->status == true? 'checked' : '' }}>
                        <span class="lbl middle"></span>
                    </label>
                </td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.site_config.banner.edit', $banner->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$banner->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.site_config.banner.destroy', $banner->id)}}"
                          id="deleteCheck_{{ $banner->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $banners])
@endsection

@push('js')

    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var banner_id = $(this).data('id');
                var url = "{{ route('backend.site_config.banner.status', ":banner_id") }}";
                url = url.replace(':banner_id', banner_id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    data: {'status': status},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            });
        });
    </script>
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

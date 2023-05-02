@extends('backend.layouts.master')
@section('title','Published Item List')
@section('page-header')
    <i class="fa fa-list"></i> Published Item List
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
    @include('backend.components.page_header')

    @include('backend.items.filter')

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 4%">SL</th>
                <th class="bg-dark" style="width: 14%">Name</th>
                <th class="bg-dark" style="width: 14%">Category</th>
                <th class="bg-dark" style="width: 14%">Sub Category</th>
                <th class="bg-dark" style="width: 14%">Brand</th>
                <th class="bg-dark" style="width: 14%">Slug</th>
                <th class="bg-dark" style="width: 14%">Image</th>
                <th class="bg-dark" style="width: 12%">Action</th>
            </tr>
            @forelse($items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->sub_category->name }}</td>
                    <td>{{ $item->brand->name }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        <img src="{{ asset($item->feature_image) }}"
                             height="30"
                             width="120"
                             alt="No Image">
                    </td>
                    <td>
                        <div class="btn-group btn-group-mini btn-corner">
                            <a href="{{ route('frontend.product', $item->slug) }}"
                               class="btn btn-xs btn-success"
                               target="_blank"
                               title="Show">
                                <i class="ace-icon fa fa-eye"></i>
                            </a>

                            <a href="{{ route('backend.product.items.published.edit', $item->id) }}"
                               class="btn btn-xs btn-info"
                               title="Edit">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-xs btn-danger"
                                    onclick="delete_check({{$item->id}})"
                                    title="Delete">
                                <i class="ace-icon fa fa-trash-o"></i>
                            </button>
                        </div>
                        <form action="{{ route('backend.product.items.destroy', $item->id)}}"
                              id="deleteCheck_{{ $item->id }}" method="GET">
                            @csrf
                        </form>
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

    @include('backend.partials._paginate', ['data' => $items])
@endsection

@push('js')
    <script type="text/javascript">
        jQuery(function ($) {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                //resize the chosen on window resize
                $(window).on('resize.chosen', function () {
                    $('.chosen-select').each(function () {
                        let $this = $(this);
                        $this.next().css({'width': '100%'});
                        // $this.next().css({'width': $this.parent().width()});
                    })
                }).trigger('resize.chosen');
            }

            const sub_category = $('#sub_category');
            $('#category').change(function () {
                sub_category.empty();
                sub_category.append($('<option>', {
                    value: '',
                    text: ''
                }));
                sub_category.val('').trigger('chosen:updated');

                const id = $(this).val().toString().trim()
                if (id > 0) {
                    $.get('items/ajax/sub-categories/' + id, function (res) {
                        if (res instanceof Array) {
                            res.forEach(function (s) {
                                sub_category.append($('<option>', {
                                    value: s.id,
                                    text: s.name
                                }));
                            });
                            sub_category.val('').trigger('chosen:updated');
                        }
                    });
                }
            });
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

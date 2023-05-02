@extends('material.layouts.master')
@section('title','Item List')
@section('page_header')
    <i class="fa fa-list"></i> Item List
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
    {{--  @include('seller.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'Create Item',
       'route' => route('seller.product.items.create')
    ])  --}}
    <div class="card">
        <div class="card-header card-header-success">
            <div class="row">
                <h4 class="col card-title">Filter</h4>
                <div class="col text-right">
                    <a href="{{ route('seller.product.items.create') }}" class="btn btn-success">Create Item</a>
                </div>
            </div>
            
        </div>
        <div class="card-body">
            <form class="form-horizontal table-responsive"
            method="get"
            action="{{route('seller.product.items.index')}}"
            role="form"
            enctype="multipart/form-data">
          <table class="table">
              <thead>
                <tr>
                    <th style="width: 22%">Category</th>
                    <th style="width: 22%">Sub Category</th>
                    <th style="width: 22%">Brand</th>
                    <th style="width: 22%">Name</th>
                    <th style="width: 12%;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td>
                        <select class="chosen-select" id="category" name="category" data-placeholder="- Category -">
                            <option value=""></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request()->query('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="chosen-select" id="sub_category" name="sub_category" data-placeholder="- Sub Category -">
                            <option value=""></option>
                            @foreach($sub_categories as $sub_category)
                                <option value="{{ $sub_category->id }}"
                                    {{ request()->query('sub_category') == $sub_category->id ? 'selected' : '' }}>
                                    {{ $sub_category->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="chosen-select" id="brand" name="brand" data-placeholder="- Brand -">
                            <option value=""></option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request()->query('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text"
                               id="name"
                               name="name"
                               placeholder="Name"
                               value="{{request()->query('name')}}"
                               class="input-sm form-control text-center">
                    </td>
                    <td>
                        <div class="btn-group btn-group-mini btn-corner">
                            <button type="submit"
                                    class="btn btn-xs btn-primary"
                                    title="Search">
                                <i class=" fa fa-search"></i>
                            </button>
    
                            <a href="{{ route('seller.product.items.index') }}"
                               class="btn btn-xs btn-info"
                               title="Show All">
                                <i class=" fa fa-list"></i>
                            </a>
                        </div>
                    </td>
                </tr>
              </tbody>
          </table>
      </form>
        </div>
    </div>

    
<div class="card">
    <div class="card-header card-header-success">
        <h4 class="card-title">All Items</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th style="width: 4%">SL</th>
                        <th style="width: 14%">Name</th>
                        <th style="width: 14%">Category</th>
                        <th style="width: 14%">Sub Category</th>
                        <th style="width: 14%">Brand</th>
                        <th style="width: 14%">Slug</th>
                        <th style="width: 14%">Image</th>
                        <th style="width: 7%">Tags</th>
                        <th style="width: 12%">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $key => $item)
                    <tr>
                        <td>{{ ($items->total()-$loop->index)-(($items->currentpage()-1) * $items->perpage() ) }}</td>
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
                        <td>{{ $item->tags_count }}</td>
                        <td>
                            <div class="btn-group btn-group-mini btn-corner">
                                <a href="{{ route('seller.product.items.edit', $item->id) }}"
                                   class="btn btn-xs btn-info"
                                   title="Edit">
                                    <i class="material-icons">edit</i>
                                </a>
    
                                <button type="button" class="btn btn-xs btn-danger"
                                        onclick="delete_check({{$item->id}})"
                                        title="Delete">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                            <form action="{{ route('seller.product.items.destroy', $item->id)}}"
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
        {{ $items->links() }}
        {{--  @include('seller.partials._paginate', ['data' => $items])  --}}
    </div>
</div>
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

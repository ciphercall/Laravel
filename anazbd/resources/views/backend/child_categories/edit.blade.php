@extends('backend.layouts.master')
@section('title','Edit Subcategory')
@section('page-header')
    <i class="fa fa-plus-circle"></i> Edit Subcategory
@stop

@section('content')
    @include('backend.components.page_header')

    <div class="col-sm-9">
        <form class="form-horizontal" method="post"
              action="{{route('backend.product.child_categories.update', $childCategory->id)}}" role="form"
              enctype="multipart/form-data">
        @csrf
        <!-- Name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Name <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           placeholder="Name"
                           name="name"
                           required
                           class="form-control input-sm"
                           value="{{$childCategory->name}}">
                    <strong class=" red">{{ $errors->first('name') }}</strong>
                </div>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="category_id">Category <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <div class="text-center">
                        <select class="chosen-select"
                                required
                                id="category_id"
                                name="category_id"
                                data-placeholder="- Category -">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{$childCategory->category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <strong class=" red">{{ $errors->first('category_id') }}</strong>
                </div>
            </div>

            <!-- Sub Category -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="subcategory_id">Sub Category <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <div class="text-center">
                        <select class="chosen-select"
                                required
                                id="subcategory_id"
                                name="subcategory_id"
                                data-placeholder="- Sub Category -">
                            <option></option>
                            @foreach($childCategory->category->sub_categories as $category)
                                <option value="{{ $category->id }}"
                                    {{$childCategory->subcategory_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <strong class=" red">{{ $errors->first('subcategory_id') }}</strong>
                </div>
            </div>

             <!-- Image -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Image </label>
                <div class="col-sm-4">
                    <input name="image"
                           type="file"
                           id="image"
                           class="form-control single-file">
                    @error('image')
                    <strong class="red">{{ $message }}</strong>
                    <br>
                    @enderror
                    <strong class="text-primary">Minimum 100x100 pixels</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit" type="submit">
                        <i class="fa fa-save"></i> Update
                    </button>

                    <a href="{{ route('backend.product.child_categories.index') }}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
     <div class="col-sm-3">
        <div class="widget-box first">
            <div class="widget-header">
                <h4 class="widget-name">Uploaded Image</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body"
                 style="display:flex; align-items: center; justify-content: center; height:100px;">
                <div class="widget-main">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <img src="{{asset($childCategory->image)}}"
                                 width="100"
                                 height="100"
                                 class="img-responsive center-block"
                                 alt="image">
                        </div>
                    </div>
                </div>
            </div>
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

            const category = $('#category_id');
            const subcategory = $('#subcategory_id');

            category.change(function () {
                category.prop("disabled", true);
                category.trigger("chosen:updated");
                subcategory.prop("disabled", true);
                subcategory.trigger("chosen:updated");

                let category_id = $('#category_id').val();
                category_id = category_id ? category_id : 0;

                $.get("{{route('backend.product.sub_categories.ajax.list',':id')}}".replace(':id', category_id),
                    null,
                    function (data) {
                        subcategory
                            .empty()
                            .append(new Option('', ''));

                        data.forEach(function (sub) {
                            subcategory.append(new Option(sub.name, sub.id));
                        });

                        category.prop("disabled", false);
                        subcategory.prop("disabled", false);

                        category.trigger("chosen:updated");
                        subcategory.trigger("chosen:updated");
                    });
            });
        });
    </script>
@endpush

@extends('backend.layouts.master')

@section('name','Edit Subcategory')
@section('page-header')
    <i class="fa fa-plus-circle"></i> Edit Subcategory
@stop

@section('content')
    @include('backend.components.page_header')

    <div class="col-sm-9">
        <form class="form-horizontal" method="post"
              action="{{route('backend.product.sub_categories.update', $subCategory->id)}}" role="form"
              enctype="multipart/form-data">
        @csrf
        <!-- name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">name <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           placeholder="name"
                           class="form-control"
                           name="name"
                           value="{{$subCategory->name}}">
                    <strong class=" red">{{ $errors->first('name') }}</strong>
                </div>
            </div>

            <!-- Parent -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="category_id">Parent <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <div class="text-center">
                        <select class="chosen-select" id="category_id" name="category_id">
                            <option value="">- Category -</option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{$subCategory->category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <strong class=" red">{{ $errors->first('category_id') }}</strong>
                </div>
            </div>

                 {{-- Commission --}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="commission">Commission <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <input type="text"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57 "
                            id="commission"
                            placeholder="percent(%) of commission "
                            class="form-control"
                            name="commission"
                            value="{{ ($subCategory->commission) }}">
                    <strong class=" red">{{ $errors->first('commission') }}</strong>
                </div>
            </div>

                {{-- vat --}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="vat">Vat <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <input type="text"
                           id="vat"
                           onkeypress="return event.charCode >= 48 && event.charCode <= 57 "
                           placeholder="percent(%) of vat "
                           class="form-control"
                           name="vat"
                           value="{{ ($subCategory->vat)}}">
                    <strong class=" red">{{ $errors->first('vat') }}</strong>
                </div>
            </div>
            
                {{-- vat --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="delivery_charge">Delivery Charge</label>
    
                    <div class="col-sm-4">
                        <input type="text"
                               id="delivery_charge"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57 "
                               placeholder="percent(%) of delivery charge "
                               class="form-control"
                               name="delivery_charge"
                               value="{{ ($subCategory->delivery_charge) }}">
                        <strong class=" red">{{ $errors->first('vat') }}</strong>
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
                    <button class="btn btn-sm btn-success submit"><i class="fa fa-save"></i> Update</button>

                    <a href="{{ route('backend.product.sub_categories.index') }}" class="btn btn-sm btn-gray"> <i
                            class="fa fa-refresh"></i>
                        Cancel</a>
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
                            <img src="{{asset($subCategory->image)}}"
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
        });
    </script>
@endpush

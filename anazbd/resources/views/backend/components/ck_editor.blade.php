@push('css')
	  <style>
	  	.ck-editor__editable {
            min-height: 250px !important;
        }

        .ck-editor__editable:nth-of-type(1) {
            margin-bottom: 20px;
        }
	  </style>
@endpush

<textarea class="ckeditor"  name="{{ $name }}">{{ $value??' ' }}</textarea>

@push('js')
@if(!isset($ckeditor))


<script src="{{asset('assets/js/ckeditor.js')}}"></script>


<script>
  	document.querySelectorAll('.ckeditor').forEach((editor) => {
	    ClassicEditor
	        .create(editor @if(!isset($ckimage)) @php echo " , {
	        	            removePlugins: ['CKFinder', 'Image', 'ImageToolbar', 'ImageUpload', 'ImageStyle'],
	        	        } "@endphp @endif)

	        .catch((error) => {
	            console.error(error);
	        });
     });
</script>

@php
	$ckeditor = true;
@endphp
@endif
@endpush

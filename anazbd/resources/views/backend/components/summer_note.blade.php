@push('css')
<link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet">
<style>
  .note-toolbar.panel-heading {
    background-color: #669FC7 !important;
  }

  .note-btn.btn.btn-default.btn-sm {
    background-color: white !important;
    border-color: #669FC7 !important;
    color: black !important;
  }
  .panel {
    margin-bottom: 0 !important;
  }
</style>
@endpush

<textarea id="summernote" class="form-control summernote" name="{{ $name }}">{{  $content ?? ''  }}</textarea>

@push('js')
<script src="{{ asset('assets/js/summernote.min.js') }}"></script>
<script>
  $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: {!! $placeholder ?? "'Write something...'" !!},
            height: {{ $height ?? 300 }}
        });
    });
</script>
@endpush

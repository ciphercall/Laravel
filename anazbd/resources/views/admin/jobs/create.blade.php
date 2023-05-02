@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">work</i> Create Job Post
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                
                <div class="card-header-primary">
                    New Job Post <div class="text-right"><a href="{{ route('jobs.index') }}" class="btn btn-sm btn-primary">All Jobs</a></div>
                </div>
                <form action="{{ route('jobs.store') }}" method="POST">

                <div class="row card-body">
                        
                    <div class="col bg m-3">
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Title <sup class="text-danger">*</sup></label>
                                <input type="text" name="title" required class="form-control">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Salary</label>
                                <input type="text" name="salary" class="form-control">
                                @error('salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Experience</label>
                                <input type="text" name="experience" class="form-control">
                                @error('experience')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Minimum Qualification</label>
                                <input type="text" name="min_qualification" class="form-control">
                                @error('min_qualification')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Department</label>
                                <input type="text" name="department" class="form-control">
                                @error('department')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Gender</label>
                                <input type="text" name="gender" class="form-control">
                                @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Job Location</label>
                                <select name="location" class="form-control">
                                    <option value="">Select Job Location</option>
                                    @foreach ($divisions as $item)
                                        <option value="{{$item->name}}" @if(old('location') == $item->name) selected="selected" @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Deadline<sup class="text-danger">*</sup></label>
                                <input type="date" required name="deadline" class="form-control">
                                @error('deadline')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Note</label>
                                <input type="text" name="note" value="{{ old('note') }}" class="form-control">
                                @error('note')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Job Type</label>
                                <select name="job_type" class="form-control" id="">
                                    <option value="Full Time" @if(old('job_type') == "Full Time") selected="selected" @endif>Full Time</option>
                                    <option value="Part Time" @if(old('job_type') == "Part Time") selected="selected" @endif>Part Time</option>
                                    <option value="Freelance" @if(old('job_type') == "Freelance") selected="selected" @endif>Freelance</option>
                                    <option value="Contractual" @if(old('job_type') == "Contractual") selected="selected" @endif>Contractual</option>
                                </select>
                                @error('job_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col form-group">
                                <label for="">Contact Email<sup class="text-danger">*</sup></label>
                                <input type="email" required name="contact_email" class="form-control">
                                @error('contact_email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Contact Mobile<sup class="text-danger">*</sup></label>
                                <input type="text" name="contact_mobile" value="{{ old('contact_mobile') }}" class="form-control">
                                @error('contact_mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="">Job Description <sup class="text-danger">*</sup></label>
                                <textarea name="description" class="ckeditor" id="job_description" cols="10" rows="30">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button type="reset" class="btn btn-sm btn-info"><i class="material-icons">dangerous</i> Reset</button>
                                <button class="btn btn-sm btn-primary"><i class="material-icons">done</i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/js/ckeditor.js')}}"></script>
    <script>
        ////////////// ck editor
        document.querySelectorAll('.ckeditor').forEach((editor) => {
            ClassicEditor
                .create(editor, {
                    removePlugins: ['CKFinder', 'Image', 'ImageToolbar', 'ImageUpload', 'ImageStyle'],
                })
                .catch((error) => {
                    console.error(error);
                });
        });    
    </script>    
@endpush


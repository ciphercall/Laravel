@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
	Lets get Started
@endsection
@section('content')
     <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="{{ url('/career') }}">Career</a></li>
                            <li>Apply</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--about bg area start-->
    <div class="about_bg_area" style="background-image: url('https://drive.google.com/uc?export=download&id=1xz5NBwIz2l8rR-R3izLyPVOJn4NaT-mv');background-repeat-y: no-repeat;background-position-y: bottom;">
        <div class="container">
            <!--about section area -->
            <section class="row mb-60 justify-content-center">
                <div class="col-sm-6 col-md-6 ">
                    <div class="card rounded shadow-sm text-center">
                        <div class="p-2">
                            <h3>Apply At ANAZ</h3>
                        </div>
                        <div class="col-12 ml-2 pl-3 ">
                            <form action="{{ route('frontend.career.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                            <div class="row">
                                <p  class="col text-center">Give Your Career a boost with Anaz. Apply Today </p>
                            </div>
                            <hr>
                            <div class="row form-group">
                                @if ($job)
                                    <div class="col text-center">Applying For <b>{{ $job->title }}</b></div>
                                    <input type="hidden" name="job_post" value="{{ $job->slug }}">
                                @else
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <label for="">Area Of Interest <sup class="text-danger">*</sup>:</label>
                                    </div>
                                    <div class="col">
                                        <select required name="a_o_i" id="" class="form-control">
                                            <option value="" disabled>Select Area Of Interest</option>
                                            <option value="sales_n_marketting" @if(old('a_o_i') == "sales_n_marketting") selected="selected" @endif>Sales & Marketting</option>
                                            <option value="engineering" @if(old('a_o_i') == "engineering") selected="selected" @endif>Engineering</option>
                                            <option value="accounts" @if(old('a_o_i') == "accounts") selected="selected" @endif>Accounts</option>
                                            <option value="hr" @if(old('a_o_i') == "hr") selected="selected" @endif>HR & Admin</option>
                                        </select>
                                        @error('interest')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif


                            </div>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Name <sup class="text-danger">*</sup>:</label>
                                </div>
                                <div class="col">
                                    <input required value="{{ old('name') }}" type="text" name="name" id="" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Email <sup class="text-danger">*</sup>:</label>
                                </div>
                                <div class="col">
                                    <input required value="{{ old('email') }}" type="text" name="email" id="" class="form-control">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Phone <sup class="text-danger">*</sup>:</label>
                                </div>
                                <div class="col">
                                    <input required value="{{ old('phone') }}" type="number" name="phone" id="" class="form-control">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Address:</label>
                                </div>
                                <div class="col">
                                    <textarea name="address" class="form-control" id="" cols="30" rows="2">{{ old('address') }}</textarea>
                                    @error('interest')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Photo:</label><br>
                                    <small class="text-muted">Passport Size</small>
                                </div>
                                <div class="col">
                                    <div class="custom-file">
{{--                                        <label class="custom-file-label" for="customFile">Choose Image</label>--}}
                                        <input type="file" class="form-control-file" name="image" id="customFile">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    Education<sup class="text-danger">*</sup> <button type="button" id="add_new_education" class="btn btn-sm"><i class="fa fa-plus"></i></button>
                                </div>

                                <div class="row mt-2" id="education_section">
                                    @php
                                        $arr = old('gpa') ?? [];
                                        $count = count($arr);
                                    @endphp
                                    @if ($count > 0)
                                        @for ($i = 0; $i < $count; $i++)
                                            <div class="row mx-3 p-1 border-bottom">
                                                <div class="col-sm-6 col-md-9 col-lg-9 form-group">
                                                    <label for="">Institute</label>
                                                    <input type="text" value="{{ old('institute_name.'.$i) }}" required placeholder="Ex. Chittagong University" name="institute_name[]" class="form-control">
                                                    @error("institute_name.$i")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                                    <label for="">GPA</label>
                                                    <input type="text" value="{{ old('gpa.'.$i) }}" required placeholder="Ex. 4.30" name="gpa[]" class="form-control">
                                                    @error("gpa.$i")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                                                    <label for="">Level</label>
                                                    <select required class="form-control" name="education_level[]" id="">
                                                        <option value="">Select Level</option>
                                                        <option value="SSC" @if(old('education_level.'.$i) == "SSC" ) selected @endif>SSC</option>
                                                        <option value="HSC" @if(old('education_level.'.$i) == "HSC" ) selected @endif>HSC</option>
                                                        <option value="Bechelors" @if(old('education_level.'.$i) == "Bechelors" ) selected @endif>Bechelors</option>
                                                        <option value="masters" @if(old('education_level.'.$i) == "masters" ) selected @endif>Masters</option>
                                                        <option value="PhD" @if(old('education_level.'.$i) == "PhD" ) selected @endif>PhD</option>
                                                    </select>
                                                    @error("education_level.$i")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                                                    <label for="">Passing Year</label>
                                                    <input type="number" placeholder="Ex. 2011" value="{{ old('passing_year.'.$i) }}" name="passing_year[]" class="form-control">
                                                    @error("passing_year.$i")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                                                    <label for="">Board / Location</label>
                                                    <input type="text" placeholder="Ex. DHAKA" value="{{ old('location.'.$i) }}" name="location[]" class="form-control">
                                                    @error("location.$i")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        @endfor
                                    @else
                                     <div class="row mx-3 p-1 border-bottom">
                                        <div class="col-sm-6 col-md-9 col-lg-9 form-group">
                                            <label for="">Institute</label>
                                            <input type="text" required placeholder="Ex. Chittagong University" name="institute_name[]" class="form-control">
                                            @error('institute_name*')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                                            <label for="">GPA</label>
                                            <input type="text" required placeholder="Ex. 4.30" name="gpa[]" class="form-control">
                                            @error('gpa*')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                                            <label for="">Level</label>
                                            <select required class="form-control" name="education_level[]" id="">
                                                <option value="">Select Level</option>
                                                <option value="SSC">SSC</option>
                                                <option value="HSC">HSC</option>
                                                <option value="Bechelors">Bechelors</option>
                                                <option value="masters">Masters</option>
                                                <option value="PhD">PhD</option>
                                            </select>
                                            @error('education_level*')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                                            <label for="">Passing Year</label>
                                            <input type="number" placeholder="Ex. 2011" name="passing_year[]" class="form-control">
                                            @error('passing_year*')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                                            <label for="">Board / Location</label>
                                            <input type="text" placeholder="Ex. DHAKA" name="location[]" class="form-control">
                                            @error('location*')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                     </div>
                                     <hr>
                                     @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Resume <sup class="text-danger">*</sup>:</label><br>
                                </div>
                                <div class="col">
                                    <div class="custom-file">
{{--                                        <label class="custom-file-label" for="customFile">Choose Resume</label>--}}
                                        <input type="file" class="form-control-file" name="resume" id="customFile">
                                        @error('resume')
                                            <span class="text-danger">{{ $message }}</span>
                                        @else
                                            <small class="text-muted">only pdf, doc, docx files are allowed.</small>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Cover Letter:</label>
                                </div>
                                <div class="col">
                                    <textarea name="cover_letter" class="form-control" id="" cols="30" rows="5">{{ old('name') }}</textarea>
                                    @error('interest')
                                        <span class="text-danger">{{ $message }}</span>
                                    @else
                                        <span class="text-muted">Not more than 500 words.</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-6 col-md-3 col-lg-3">
                                    <label for="">Preferred Job Location <sup class="text-danger">*</sup>:</label>
                                </div>
                                <div class="col">
                                    <select required name="perferred_location" id="" class="form-control">
                                        <option value="">Select Perferred Job Location</option>
                                        @foreach (collect($divisions) as $item)
                                            <option value="{{ $item->name }}" @if(old('perferred_location') == $item->name) selected="selected" @endif>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('interest')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-success">Apply</button>
                                </div>
                            </div>
                            <br>
                        </form>
                        </div>
                    </div>
                </div>
                @if ($job)

                    <div class="col-sm-6 col-md-5 col-lg-5">
                        <div class="card bg-white rounded p-3">
                            <div class="row">
                                <div class="col text-center"><b>Job Details</b></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Title: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    <h4>{{ $job->title }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Department: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    {{ $job->department ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Qualification: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    {{ $job->min_qualification ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Experience: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    {{ $job->experience ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Salary: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    {{ $job->salary ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Gender: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    {{ $job->gender ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Deadline: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    {{ $job->deadline->format('d M Y') ?? 'N/A' }} <br>
                                    <small class="text-muted">{{ $job->deadline->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Description: </label>
                                </div>
                                <div class="col-sm-6 col-md-9 bg-grey shadow-sm p-1">
                                    {!! $job->description !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <label for="">Contacts: </label>
                                </div>
                                <div class="col-sm-6 col-md-9">
                                    <a href="mailto:{{ $job->contact_email }}">{{ $job->contact_email }}</a> <br> <a href="tel:+{{ $job->contact_mobile }}">{{ $job->contact_mobile }}</a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col text-center text-muted"><small>{{ $job->note }}</small></div>
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on("click","#add_new_education",function(){
            let row = `<div class="row mx-3 p-1 border-bottom">
                <div class="col-sm-6 col-md-9 col-lg-9 form-group">
                    <label for="">Institute</label>
                    <input required type="text" placeholder="Ex. Dhaka University" name="institute_name[]" class="form-control">
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 form-group">
                    <label for="">GPA</label>
                    <input required type="text" placeholder="Ex. 4.30" name="gpa[]" class="form-control">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                    <label for="">Level</label>
                    <select required class="form-control" name="education_level[]" id="">
                        <option value="">Select Level</option>
                        <option value="SSC">SSC</option>
                        <option value="HSC">HSC</option>
                        <option value="Bechelors">Bechelors</option>
                        <option value="masters">Masters</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                    <label for="">Passing Year</label>
                    <input type="number" placeholder="Ex. 2011" name="passing_year[]" class="form-control">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4 form-group">
                    <label for="">Board / Location</label>
                    <input type="text" placeholder="Ex. DHAKA" name="location[]" class="form-control">
                </div>
             </div>
             <hr>`;
            $('#education_section').append(row);
        });
    </script>
@endpush

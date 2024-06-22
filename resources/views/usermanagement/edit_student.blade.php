
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Students</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Admin</a></li>
                                <li class="breadcrumb-item active">Edit Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                        <form action="{{ route('user/update') }}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{ $userView->id }}" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Student Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Student ID <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('admission_id') is-invalid @enderror" name="admission_id" placeholder="Enter Student ID" value="{{ $studentEdit->admission_id }}">
                                        @error('admission_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $studentEdit->first_name }}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Last Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $studentEdit->last_name }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Gender <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('gender') is-invalid @enderror" name="gender">
                                                <option selected disabled>Select Gender</option>
                                                <option value="Female" {{ $studentEdit->gender == 'Female' ? "selected" :"Female"}}>Female</option>
                                                <option value="Male" {{ $studentEdit->gender == 'Male' ? "selected" :""}}>Male</option>
                                                <option value="Others" {{ $studentEdit->gender == 'Others' ? "selected" :""}}>Others</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Date Of Birth <span class="login-danger">*</span></label>
                                            <input class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="text"  value="{{ $studentEdit->date_of_birth }}">
                                            @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--<div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Roll </label>
                                            <input class="form-control @error('roll') is-invalid @enderror" type="text" name="roll" value="{{ $studentEdit->roll }}">
                                            @error('roll')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>-->

                                  
                                    <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Religion <span class="login-danger">*</span></label>
        <select class="form-control select @error('religion') is-invalid @enderror" name="religion">
            <option selected disabled>Please Select Religion </option>
            <option value="Islam" {{ $studentEdit->religion == 'Islam' ? "selected" :""}}>Islam</option>
            <option value="Budha" {{ $studentEdit->religion == 'Budha' ? "selected" :""}}>Budha</option>
            <option value="Hindu" {{ $studentEdit->religion == 'Hindu' ? "selected" :""}}>Hindu</option>
            <option value="Christian" {{ $studentEdit->religion == 'Christian' ? "selected" :""}}>Christian</option>
            <option value="Others" {{ $studentEdit->religion == 'Others' ? "selected" :""}}>Others</option>
        </select>
        @error('religion')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

                                    <!--<div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>E-Mail <span class="login-danger">*</span></label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"  value="{{ $studentEdit->email }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>-->

                                    <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Class <span class="login-danger">*</span></label>
        <select class="form-control select @error('class_id') is-invalid @enderror" name="class_id">
            <option selected disabled>Please Select Class </option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ $studentEdit->class->id == $class->id ? "selected" : "" }}>{{ $class->class_name }}</option>
            @endforeach
        </select>
        @error('class_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
                                    
                                <!--<div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Admission ID </label>
                                            <input class="form-control @error('admission_id') is-invalid @enderror" type="text" name="admission_id" value="{{ $studentEdit->admission_id }}">
                                            @error('admission_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>-->

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Phone </label>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" name="phone_number" value="{{ $studentEdit->phone_number }}">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Status <span class="login-danger">*</span></label>
                                            <select class="form-control select" name="status">
                                                <option disabled>Select Status</option>
                                                <option value="Active" {{ $studentEdit->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Disable" {{ $studentEdit->status == 'Disable' ? 'selected' : '' }}>Disable</option>
                                                <option value="Inactive" {{ $studentEdit->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- LOGIN DETAILS -->
                                    <div class="col-12">
                                    <h5 class="form-title"><span>Login Details</span></h5>
                                </div>
                                <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Username <span class="login-danger">*</span></label>
        <input type="text" class="form-control @error('stud_username') is-invalid @enderror" name="stud_username" placeholder="Enter Username" value="{{ $studentEdit->stud_username }}">
        @error('stud_username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Email ID <span class="login-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Mail Id" value="{{ $studentEdit->email }}">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Password <span class="login-danger">*</span></label>
        <div class="input-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter Password"  value="{{ $studentEdit->password }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="togglePasswordVisibility">
                    <i class="far fa-eye"></i>
                </button>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Repeat Password <span class="login-danger">*</span></label>
        <div class="input-group">
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Repeat Password"  value="{{ $studentEdit->password}}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmationVisibility">
                    <i class="far fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#togglePasswordVisibility").click(function() {
            let passwordField = $("#password");
            if (passwordField.attr("type") === "password") {
                passwordField.attr("type", "text");
            } else {
                passwordField.attr("type", "password");
            }
        });
        $("#togglePasswordConfirmationVisibility").click(function() {
            let passwordConfirmationField = $("#password_confirmation");
            if (passwordConfirmationField.attr("type") === "password") {
                passwordConfirmationField.attr("type", "text");
            } else {
                passwordConfirmationField.attr("type", "password");
            }
        });
    });
</script>

                                <!-- ADDRESS DETAILS -->
                                <div class="col-12">
                                    <h5 class="form-title"><span>Address</span></h5>
                                </div>
                                <div class="col-12">
                                    <div class="form-group local-forms">
                                        <label>Address <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter address" value="{{ $studentEdit->address }}">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>City <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="Enter City" value="{{ $studentEdit->city }}">
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>State <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" placeholder="Enter State" value="{{ $studentEdit->state }}">
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Zip Code <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" placeholder="Enter Zip" value="{{ $studentEdit->zip_code }}">
                                        @error('zip_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Country <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" placeholder="Enter Country" value="{{ $studentEdit->country }}">
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                   <!-- <div class="col-12 col-sm-4">
                                        <div class="form-group students-up-files">
                                            <label>Upload Student Photo (150px X 150px)</label>
                                            <div class="uplod">
                                                <h2 class="table-avatar">
                                                    <a class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ Storage::url('student-photos/'.$studentEdit->upload) }}" alt="User Image">
                                                    </a>
                                                </h2>
                                                <label class="file-upload image-upbtn mb-0 @error('upload') is-invalid @enderror">
                                                    Choose File <input type="file" name="upload">
                                                </label>
                                                <input type="hidden" name="image_hidden" value="{{ $studentEdit->upload }}">
                                                @error('upload')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

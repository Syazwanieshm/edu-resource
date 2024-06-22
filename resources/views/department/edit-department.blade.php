
@extends('layouts.master')
@section('content')

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Department</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('department/list/page') }}">Department</a></li>
                            <li class="breadcrumb-item active">Edit Department</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                        <form action="{{ route('department/update') }}" method="POST">
                            @csrf
                      

                            <input type="hidden" class="form-control" name="d_id" value="{{ $departmentEdit->d_id }}">


                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Department Details</span></h5>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Department ID <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('dept_id') is-invalid @enderror" name="dept_id" placeholder="Enter Department ID" value="{{ $departmentEdit->dept_id }}">
                                        @error('dept_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Department Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('dept_name') is-invalid @enderror" name="dept_name" placeholder="Enter Department Name" value="{{ $departmentEdit->dept_name }}">
                                        @error('dept_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Head of Department <span class="login-danger">*</span></label>
        <select class="form-control select @error('hod') is-invalid @enderror" name="hod">
            <option selected disabled>Please Select HOD</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $departmentEdit->hod == $teacher->id ? "selected" : "" }}>{{ $teacher->full_name }}  </option>
            @endforeach
        </select>
        @error('hod')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>





                                <div class="col-12">
                                        <div class="student-submit">
                                        <!--<input type="hidden" name="dept_id" value="{{ $departmentEdit->dept_id }}">-->
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

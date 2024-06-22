@extends('layouts.master')
@section('content')

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Subject</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('subject/list/page') }}">Subject</a></li>
                            <li class="breadcrumb-item active">Edit Subject</li>
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
                        <form action="{{ route('subject/update') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="id" value="{{ $subjectEdit->id }}">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Subject Details</span></h5>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Subject ID <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('sub_id') is-invalid @enderror" name="sub_id" placeholder="Enter Subject ID" value="{{ $subjectEdit->sub_id }}">
                                        @error('sub_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Subject Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('sub_name') is-invalid @enderror" name="sub_name" placeholder="Enter Subject Name" value="{{ $subjectEdit->sub_name }}">
                                        @error('sub_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Description <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Description" value="{{ $subjectEdit->description }}">
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                        <div class="student-submit">
                                        <!--<input type="hidden" name="dept_id" value="{{ $subjectEdit->sub_id }}">-->
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

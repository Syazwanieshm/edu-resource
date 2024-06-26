@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">1 Brilliant: English</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Teacher</a></li>
                        <li class="breadcrumb-item active">Class </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
    <li class="nav-item">
    
        <a class="nav-link active" href="{{ route('subclass_t/main/page') }}">Announcement</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('subclass_t/material/page') }}">Materials</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('subclass_t/task/page') }}">Task</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('subclass_t/review/page') }}">Review</a>
    </li>
</ul>

                <div class="col">
                    <h1 class="page-title"></h1>
                    
                </div>
                <div class="col">
                    <h3 class="page-title">Announcement</h3>
                    
                </div>
                <div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-1 d-flex align-items-center justify-content-center"> <!-- Adjusted column width and added d-flex classes -->
                    <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid w-100 h-100"/> <!-- Added w-100 and h-100 classes to make the image the same size as the input -->
                </div>
                <div class="col-md-10">
                    <input class="form-control" type="text" placeholder="Make your Announcement here" >
                </div>
            </div>
        </div>
    </div>
</div>







</div>
</div>
@endsection
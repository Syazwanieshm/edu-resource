@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}


<!--HISTORY PAGE-->>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">History</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Student</a></li>
                        <li class="breadcrumb-item active">Class </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
    <li class="nav-item">
    
    <a class="nav-link active" href="{{ route('subclass/main/htr') }}">Announcement</a>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('subclass/material/htr')}}">Materials</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('subclass/task/htr') }}">Task</a>
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
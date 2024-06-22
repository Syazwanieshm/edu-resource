@extends('layouts.master')

@section('content')
    <style>
        .page-wrapper {
            padding: 20px;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item {
            font-size: 14px;
            color: #6c757d;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            display: inline-block;
            margin: 0 5px;
        }

        .breadcrumb-item.active {
            color: #007bff;
            font-weight: bold;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 0;
        }

        .card-body {
            padding: 20px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
            box-shadow: none;
            margin-bottom: 10px;
        }

        .btn {
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: none;
            margin-right: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .float-right {
            float: right;
        }
    </style>

    {{-- message --}}
    {!! Toastr::message() !!}

    @section('content')
    {{-- Include CSS and JavaScript --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h1>{{ $material->title }}</h1>
                        
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Student</a></li>
                            <li class="breadcrumb-item active">Class</li>
                        </ul>
                    </div>
                    <span class="text-secondary">{{ $material->created_at->format('M d, Y') }}</span>
                </div>
                <hr>
            </div>
            
            <div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-10">
                    <h5 class="mb-3">Description</h5>
                    <p>{{ $material->description }}</p>
                </div>
             
            </div>
         
                        @if($material->file_path)
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-10">
                        <h5 class="mb-3">File</h5>
                        <p>File Name: {{ basename($material->file_path) }}</p>
                        <a href="{{ route('subclass/viewFile', $material->id) }}" target="_blank">
                            View File
                        </a>
                    </div>
                    <div class="col-md-2 text-right">
                        <a href="{{ route('subclass/download', $material->id) }}">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif





                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Class Comments</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Add class comment..."></textarea>
                                        </div>
                                        <div class="float-right">
                                            <button class="btn btn-sm btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include JavaScript --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>



@endsection
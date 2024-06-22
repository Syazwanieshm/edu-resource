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
                            <li class="breadcrumb-item"><a href="#">Tutor</a></li>
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
                <div class="col-md-2 text-right">
                    <div class="dropdown d-inline">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('subclass_t/material/edit', $material->id) }}">Edit</a>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resourceDelete" data-id="{{ $material->id }}">Delete</button>
                        </div>
                    </div>
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
                        <a href="{{ route('subclass_t/viewFile', $material->id) }}" target="_blank">
                            View File
                        </a>
                    </div>
                    <div class="col-md-2 text-right">
                        <a href="{{ route('subclass_t/download', $material->id) }}">
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
<!-- Resource delete modal -->
<div class="modal fade contentmodal" id="resourceDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header pb-0 border-bottom-0 justify-content-end">
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="feather-x-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subclass_t/material/delete', $material->id) }}" method="POST" id="deleteResourceForm">
                    @csrf
                    <!-- Hidden input for resource ID -->
                    <input type="hidden" name="id" id="modal_res_id" value="">
                    <!-- Delete confirmation message and buttons -->
                    <div class="delete-wrap text-center">
                        <div class="del-icon">
                            <i class="feather-x-circle"></i>
                        </div>
                        <h2>Are you sure you want to delete this material?</h2>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-success me-2">Yes</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#resourceDelete"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const resourceId = this.getAttribute('data-id');
                document.getElementById('modal_res_id').value = resourceId;
            });
        });
    });
</script>
    <script>
        $(document).ready(function() {
            // Dropdown toggle
            $('.dropdown-toggle').on('click', function(e) {
                var $el = $(this).next('.dropdown-menu');
                $('.dropdown-menu').not($el).hide();
                $el.toggle();
                e.stopPropagation();
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').hide();
                }
            });
        });
    </script>
@endsection
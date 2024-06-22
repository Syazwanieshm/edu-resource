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

{{-- Include Toastr message --}}
{!! Toastr::message() !!}

{{-- Include CSS and JavaScript --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1>{{ $task->title }}</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Class</li>
                    </ul>
                </div>
                <span class="text-secondary">Uploaded At : {{ $task->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="text-secondary"><strong>Due : {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</strong> </span>
            </div>
            <div>
                <span class="text-secondary"><strong>{{ $task->marks }} marks</strong></span>
            </div>
            <hr>
        </div>
        <a href="{{ route('subclass/task/page') }}" class="back-icon"><i class="fas fa-arrow-left"></i> Back</a>

        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <h5 class="mb-3">Description</h5>
                            <p>{{ $task->description }}</p>
                        </div>
                        <div class="col-md-2 text-right">
                            <div class="dropdown d-inline">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('subclass_t/task/edit', $task->id) }}">Edit</a>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resourceDelete" data-id="{{ $task->id }}">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($task->file_path)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-10">
                                            <h5 class="mb-3">File</h5>
                                            <p>{{ basename($task->file_path) }}</p>
                                            <a href="{{ route('subclass/viewFile', $task->id) }}" target="_blank">View File</a>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a href="{{ route('subclass/download', $task->id) }}">
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
                            {{-- New Card for Your Work --}}
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="card-title">Your Work</h3>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-secondary float-right">
                                                @if($studentMarks !== null)
                                                    {{ $studentMarks }} / {{ $fullMarks }}
                                                @else
                                                    Ungraded / {{ $fullMarks }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('task.uploadStudentWork') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Upload Your Work:</label>
                                                    <input type="file" name="files[]" class="form-control-file" multiple required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="float-right">
                                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Display uploaded files --}}
                                    @if($studentWorks->isNotEmpty())
                                        <div class="mt-4">
                                            <h5>Uploaded Files:</h5>
                                            <ul>
                                                @foreach($studentWorks as $work)
                                                    <li>
                                                        {{ basename($work->file_path) }}
                                                        <form action="{{ route('task.deleteStudentWork', $work->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- End of Your Work Card --}}
                        </div>
                    </div>

                    {{-- Add class comments section --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-3">
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
    </div>
</div>
@endsection

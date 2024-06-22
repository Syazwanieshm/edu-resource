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

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #f8f9fa;
        }

        .table-striped tbody tr.no-submission td {
            color: #dc3545;
        }

        .table a {
            text-decoration: none;
            color: #007bff;
        }

        .late-submission {
            color: red;
            font-weight: bold;
        }
    </style>


{!! Toastr::message() !!}

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
       
            <h1>{{ $task->title }}</h1>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Teacher</a></li>
                <li class="breadcrumb-item active">Class</li>
            </ul>
            <div>
                <span class="text-secondary">Uploaded At : {{ $task->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="text-secondary"><strong>Due : {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</strong></span>
            </div>
            <div>
                <span class="text-secondary"><strong>{{ $task->marks }} marks</strong></span>
            </div>
            <hr>
        </div>
        <a href="{{ route('subclass_t/task/page') }}" class="back-icon"><i class="fas fa-arrow-left"></i> Back</a>
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
                                    <button class="dropdown-item delete-resource" data-id="{{ $task->id }}">Delete</button>
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
                                                <p>File Name: {{ basename($task->file_path) }}</p>
                                                <a href="{{ route('subclass_t/viewFileT', $task->id) }}" target="_blank">
                                                    View File
                                                </a>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <a href="{{ route('subclass_t/downloadTask', $task->id) }}">
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
                                    <h3 class="card-title">Student Submissions</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Submission Date</th>
                                                <th>File</th>
                                                <th>Grade</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($task->students as $student)
                                                @foreach($student->works as $work)
                                                    <tr>
                                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                                        <td class="{{ $work->created_at->gt($task->due_date)? 'late-submission' : '' }}">{{ $work->created_at->format('M d, Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('subclass_t/viewStudentFile', $work->id) }}" target="_blank">
                                                                View File
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="grade-link" data-student-id="{{ $student->id }}">
                                                                @if($student->grades->isNotEmpty())
                                                                    {{ $student->grades->first()->student_marks }}
                                                                @else
                                                                    Ungraded
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('subclass_t/downloadStudentF', $work->id) }}">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if($student->works->isEmpty())
                                                    <tr>
                                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                                        <td class="no-submission">No submission</td>
                                                        <td>-</td>
                                                        <td>
                                                            <a href="#" class="grade-link" data-student-id="{{ $student->id }}">
                                                                Ungraded
                                                            </a>
                                                        </td>
                                                        <td>-</td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="5">No students or submissions found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- Modal for editing grade -->
        <div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="gradeForm" action="{{ route('subclass_t/storeGrade', $task->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="gradeModalLabel">Edit Grade</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="studentId" name="student_id" value="">
                            <input type="number" id="studentMarks" name="student_marks" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    



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
                            <form action="{{ route('subclass_t/task/delete', $task->id) }}" method="POST" id="deleteResourceForm">
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle click on grade link
            $('.grade-link').on('click', function(e) {
                e.preventDefault();
                var studentId = $(this).data('student-id');
                var studentMarks = $(this).text().trim();

                $('#studentId').val(studentId);
                $('#studentMarks').val(studentMarks === 'Ungraded' ? '' : studentMarks);

                $('#gradeModal').modal('show');
            });

            // Handle delete resource modal
            $('.delete-resource').on('click', function(e) {
                var resourceId = $(this).data('id');
                $('#modal_res_id').val(resourceId);
                $('#resourceDelete').modal('show');
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

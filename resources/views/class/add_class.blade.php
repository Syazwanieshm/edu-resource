@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add Class</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="class.html">Class</a></li>
                        <li class="breadcrumb-item active">Add Class</li>
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
                        <form action="{{ route('class/save') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Class Details</span></h5>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Class ID <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('class_id') is-invalid @enderror"
                                            name="class_id" placeholder="Enter Class ID" value="{{ old('class_id') }}">
                                        @error('class_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Class Name <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('class_name') is-invalid @enderror"
                                            name="class_name" placeholder="Enter Class Name" value="{{ old('class_name') }}">
                                        @error('class_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Description <span class="login-danger">*</span></label>
                                        <input type="text" class="form-control @error('class_desc') is-invalid @enderror"
                                            name="class_desc" placeholder="Description" value="{{ old('class_desc') }}">
                                        @error('class_desc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Classroom Teacher</label>
        <select class="form-control @error('class_teacher') is-invalid @enderror" name="class_teacher">
            <option selected disabled>Please Select Classroom Teacher</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option> <!-- Assuming teacher's name is stored in 'full_name' field -->
            @endforeach
        </select>
        @error('class_teacher')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Subject</label>
        <select class="form-control select @error('sub_id') is-invalid @enderror"
            name="sub_id" id="subjectSelect">
            <option selected disabled>Please Select Subject</option>
            @foreach($subjectView as $subject)
                <option value="{{ $subject->id }}">{{ $subject->sub_name }}</option> <!-- Assuming subject name is stored in 'sub_name' field -->
            @endforeach
        </select>
        @error('sub_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>



<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Teacher for Subject</label>
        <select class="form-control select @error('teacher_id') is-invalid @enderror" name="teacher_id" id="teacherSelect">
            <option selected disabled>Please Select Teacher</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option> <!-- Assuming teacher's name is stored in 'full_name' field -->
            @endforeach
        </select>
        @error('teacher_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>



<div class="col-12 col-sm-4">
    <button type="button" class="btn btn-outline-primary" onclick="addSubject()">+ Add Subject</button>
</div>

<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
    <thead class="student-thread">
        <tr>
            <th>
                <div class="form-check check-tables">
                    <input class="form-check-input" type="checkbox" value="something">
                </div>
            </th>
            <th>Subject Name</th>
            <th>Subject Teacher</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>

    <tbody id="subjectTableBody">
        <tr class="no-data">
            <td colspan="4" class="text-center">No data available in this table</td>
        </tr>
    </tbody>
</table>

<div class="col-12">
    <div class="student-submit">
        <!--<button type="submit" class="btn btn-primary" onclick="submitForm()">Submit</button>-->
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

<script>
    function addSubject() {
        // Get the selected subject and teacher
        var selectedSubject = $('#subjectSelect').val();
        var selectedTeacher = $('#teacherSelect').val();

        // Check if the selected subject already exists in the table
        var exists = false;
        $('#subjectTableBody tr').each(function() {
            var subjectId = $(this).find('td:eq(1)').text(); // Assuming subject ID is in the second column
            if (subjectId == selectedSubject) {
                exists = true;
                return false; // Break the loop
            }
        });

        // If the subject already exists, show an error message
        if (exists) {
            toastr.error('Selected subject already exists in the table.');
            return;
        }

        // Add the new row to the table
        var newRow = '<tr>' +
            '<td>' +
            '<div class="form-check check-tables">' +
            '<input class="form-check-input" type="checkbox" value="something">' +
            '</div>' +
            '</td>' +
            '<td style="display:none;" class="subjectId">' + selectedSubject + '</td>' +
            '<td>' + $('#subjectSelect option:selected').text() + '</td>' +
            '<td>' + $('#teacherSelect option:selected').text() + '</td>' +
            '<td class="text-end">' +
            '<div class="actions">' +
            '<button type="button" class="btn btn-sm bg-danger-light class_delete" onclick="deleteRow(this)"><i class="feather-trash-2 me-1"></i></button>' +
            '</div>' +
            '</td>' +
            '</tr>';

        // Remove the initial "No data available in this table" row if it exists
        $('#subjectTableBody tr.no-data').remove();
        // Append the new row to the table
        $('#subjectTableBody').append(newRow);

        // Add selected subject and teacher IDs to hidden inputs as arrays
        $('<input>').attr({
            type: 'hidden',
            name: 'sub_id[]',
            value: selectedSubject
        }).appendTo('form');

        $('<input>').attr({
            type: 'hidden',
            name: 'teacher_id[]',
            value: selectedTeacher
        }).appendTo('form');
    }

    function deleteRow(btn) {
        var row = btn.parentNode.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function submitForm() {
        // Submit the form
        $('form').submit();
    }
</script>




@endsection

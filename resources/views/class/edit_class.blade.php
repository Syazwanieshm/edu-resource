@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Class</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('class/list/page') }}">Class</a></li>
                        <li class="breadcrumb-item active">Edit Class</li>
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
                    <form action="{{ route('class/update') }}" method="POST">
                @csrf
                            @if ($classEdit)
                            <input type="hidden" name="id" value="{{ $classEdit->id }}">

                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Class Details</span></h5>
                                </div>

                             <!-- Class ID -->
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Class ID <span class="login-danger">*</span></label>
        <input type="text" class="form-control @error('class_id') is-invalid @enderror" name="class_id" placeholder="Enter Class ID" value="{{ old('class_id', $classEdit->class_id) }}">
        @error('class_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<!-- Class Name -->
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Class Name <span class="login-danger">*</span></label>
        <input type="text" class="form-control @error('class_name') is-invalid @enderror" name="class_name" placeholder="Enter Class Name" value="{{ old('class_name', $classEdit->class_name) }}">
        @error('class_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<!-- Class Description -->
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Description <span class="login-danger">*</span></label>
        <input type="text" class="form-control @error('class_desc') is-invalid @enderror" name="class_desc" placeholder="Description" value="{{ old('class_desc', $classEdit->class_desc) }}">
        @error('class_desc')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<!-- Classroom Teacher -->
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Classroom Teacher</label>
        <select class="form-control @error('class_teacher') is-invalid @enderror" name="class_teacher">
            <option value="" selected disabled>Please Select Classroom Teacher</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $classEdit->teachers->contains('id', $teacher->id) ? "selected" : "" }}>{{ $teacher->full_name }}</option>
            @endforeach
        </select>
        @error('class_teacher')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<!-- Subject -->
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Subject</label>
        <select class="form-control select @error('sub_id') is-invalid @enderror" name="sub_id[]" id="subjectSelect">
            <option selected disabled>Please Select Subject</option>
            @foreach($subjectView as $subject)
                <option value="{{ $subject->id }}" {{ in_array($subject->id, old('sub_id', $classEdit->subjects->pluck('id')->toArray()))? "selected" : "" }}>
                    {{ $subject->sub_name }}
                </option>
            @endforeach
        </select>
        @error('sub_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<!-- Teacher for Subject -->
<div class="col-12 col-sm-4">
    <div class="form-group local-forms">
        <label>Teacher for Subject</label>
        <select class="form-control select @error('teacher_id') is-invalid @enderror" name="teacher_id[]" id="teacherSelect">
            <option selected disabled>Please Select Teacher</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ in_array($teacher->id, old('teacher_id', $classEdit->teachers->pluck('id')->toArray()))? "selected" : "" }}>
                    {{ $teacher->full_name }}
                </option>
            @endforeach
        </select>
        @error('teacher_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<!-- Add Subject Button -->
<div class="col-12 col-sm-4">
    <button type="button" class="btn btn-outline-primary" onclick="addSubject()">+ Add Subject</button>
</div>

<!-- Subjects Table -->
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
        @foreach($classEdit->subjects as $subject)
            <tr>
                <td>
                    <div class="form-check check-tables">
                        <input class="form-check-input" type="checkbox" name="delete_subjects[]" value="{{ $subject->id }}">
                    </div>
                </td>
                <td style="display:none;">{{ $subject->id }}</td>
                <td>{{ $subject->sub_name }}</td>
                <td>
                    @if($subject->pivot->teacher_id)
                        {{ \App\Models\Teacher::find($subject->pivot->teacher_id)->full_name }}@else
                        N/A <!-- Display N/A if the subject doesn't have an associated teacher -->
                    @endif
                </td>
                <td class="text-end">
                    <div class="actions">
                        <button type="button" class="btn btn-sm bg-danger-light class_delete" onclick="deleteRow(this)">
                            <i class="feather-trash-2 me-1"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Subject IDs -->
@foreach($classEdit->subjects as $subject)
    <input type="hidden" name="subject_id[]" value="{{ $subject->id }}">
    <input type="hidden" name="teacher_id[]" value="{{ $subject->pivot->teacher_id }}">
@endforeach

<!-- Submit Button -->
<div class="col-12">
    <div class="student-submit">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</div>
                            </div>
                            @else
                                <div class="alert alert-danger">
                                    Class not found.
                                </div>
                            @endif
                        </form>
                    </div>
                </div>                  
            </div>
        </div>
    </div>
</div>

<script>
const addSubject = () => {
    const selectedSubject = $('#subjectSelect').val();
    const selectedTeacher = $('#teacherSelect').val();

    // Check if the selected subject already exists in the table
    const exists = false;
    $('#subjectTableBody tr').each(function() {
        const subjectId = $(this).find('input[name="subject_id[]"]').val(); // Assuming subject ID is in the hidden input
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
    const newRow = '<tr>' +
        '<td>' +
        '<div class="form-check check-tables">' +
        '<input class="form-check-input" type="checkbox" name="delete_subjects[]" value="' + selectedSubject + '">' +
        '</div>' +
        '</td>' +
        '<td style="display:none;"><input type="hidden" name="subject_id[]" value="' + selectedSubject + '">' + selectedSubject + '</td>' +
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

    // Reset select fields
    $('#subjectSelect').val('');
    $('#teacherSelect').val('');
};

const deleteRow = (btn) => {
    const row = btn.parentNode.parentNode.parentNode;
    row.parentNode.removeChild(row);
};
</script>



@endsection

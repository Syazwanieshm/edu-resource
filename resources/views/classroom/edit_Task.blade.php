@extends('layouts.master')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Task</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Tutor</a></li>
                            <li class="breadcrumb-item active">Class</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('subclass_t/task/update', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ $task->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="file">Attach File</label>
                                <input type="file" class="form-control-file" id="file" name="file">
                                @if ($task->file_path)
                                    <p>Current File: <a href="{{ asset('storage/' . $task->file_path) }}" target="_blank">{{ $task->file_path }}</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="marks">Marks</label>
                                <input type="number" class="form-control" id="marks" name="marks" value="{{ $task->marks }}">
                            </div>
                            <div class="form-group">
                                <label for="class">Class</label>
                                <select class="form-control" id="class" name="class" required>
                                    @foreach($class as $cls)
                                        <option value="{{ $cls->id }}" {{ $task->class_id == $cls->id ? 'selected' : '' }}>{{ $cls->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="students">Students</label>
                                <select multiple class="form-control" id="students" name="students[]" required>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ in_array($student->id, $selectedStudents) ? 'selected' : '' }}>{{ $student->first_name }} {{ $student->last_name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="selectAllStudents">
                                    <label class="form-check-label" for="selectAllStudents">All Students</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="topic">Topic</label>
                                <select class="form-control" id="topic" name="topic">
                                    <option value="">No Topic</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}" {{ $task->topic_id == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                            <label for="subject">Subject</label>
                            <select class="form-control" id="subject" name="subject" required>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $task->sub_id == $subject->id ? 'selected' : '' }}>{{ $subject->sub_name }}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Update Task</button>
                                </div>
                                <div class="col text-right">
                                    <a href="{{ route('subclass_t/task/page') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const classSelect = document.getElementById('class');
            const studentsSelect = document.getElementById('students');
            const selectAllCheckbox = document.getElementById('selectAllStudents');

            classSelect.addEventListener('change', function () {
                const classId = this.value;
                fetch(`/api/class/${classId}/students`)
                    .then(response => response.json())
                    .then(data => {
                        studentsSelect.innerHTML = '';
                        data.students.forEach(student => {
                            const option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = `${student.first_name} ${student.last_name}`;
                            studentsSelect.appendChild(option);
                        });
                    });
            });

            selectAllCheckbox.addEventListener('change', function () {
                const options = studentsSelect.options;
                for (let i = 0; i < options.length; i++) {
                    options[i].selected = this.checked;
                }
            });
        });
    </script>
@endsection

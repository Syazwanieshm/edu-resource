@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload TextBook Resources</h2>
  
    <form id="uploadForm" action="{{ route('resources_a/uploadTb') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="fileInput">Upload TextBook:</label>
            <input type="file" class="form-control-file" id="fileInput" name="file" value="{{ old('file_name') }}">
            <span class="text-danger" id="fileError" style="display:none;">File is required.</span>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="res_name" value="{{ old('res_name') }}">
            <span class="text-danger" id="titleError" style="display:none;">Title is required.</span>
        </div>
        <div class="form-group">
            <label for="form">Form:</label>
            <select class="form-control" id="form" name="form">
                <option value="Form 1">1</option>
                <option value="Form 2">2</option>
                <option value="Form 3">3</option>
                <option value="Form 4">4</option>
                <option value="Form 5">5</option>
                <option value="Form 6">6</option>
            </select>
        </div>
        <input type="hidden" name="type" value="TEXTBOOK"> <!-- Add this hidden input field -->
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="{{ route('resources_a/textbook/page') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.getElementById('uploadTb').addEventListener('submit', function(event) {
        let isValid = true;

        const fileInput = document.getElementById('fileInput');
        const titleInput = document.getElementById('title');

        const fileError = document.getElementById('fileError');
        const titleError = document.getElementById('titleError');

        fileError.style.display = 'none';
        titleError.style.display = 'none';

        if (!fileInput.value) {
            fileError.style.display = 'block';
            isValid = false;
        }

        if (!titleInput.value) {
            titleError.style.display = 'block';
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
</script>
@endsection


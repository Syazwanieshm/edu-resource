@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Past Year Question Resources</h2>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('resources_a/updatePyqTutor', $resource->res_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control" name="res_id" value="{{ $resource->res_id }}" readonly>
        
        <div class="form-group">
            <label for="currentFile">Current File:</label>
            <p>
                <a href="{{ asset('uploads/' . $resource->file_name) }}" target="_blank">{{ $resource->file_name }}</a>
            </p>
        </div>
        
        <div class="form-group">
            <label for="fileInput">Upload New File (if want to change):</label>
            <input type="file" class="form-control-file" id="fileInput" name="file">
        </div>
        
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="res_name" value="{{ $resource->res_name }}">
        </div>
        
        <div class="form-group">
            <label for="form">Form:</label>
            <select class="form-control select @error('form') is-invalid @enderror" id="form" name="form">
                <option value="Form 1" {{ $resource->form == 'Form 1' ? 'selected' : '' }}>1</option>
                <option value="Form 2" {{ $resource->form == 'Form 2' ? 'selected' : '' }}>2</option>
                <option value="Form 3" {{ $resource->form == 'Form 3' ? 'selected' : '' }}>3</option>
                <option value="Form 4" {{ $resource->form == 'Form 4' ? 'selected' : '' }}>4</option>
                <option value="Form 5" {{ $resource->form == 'Form 5' ? 'selected' : '' }}>5</option>
                <option value="Form 6" {{ $resource->form == 'Form 6' ? 'selected' : '' }}>6</option>
            </select>
        </div>
        
        <input type="hidden" name="type" value="PYQ">
        
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('resources_a/pyqTutor/page') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection



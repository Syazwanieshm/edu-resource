@extends('layouts.master')

@section('content')
{{-- message --}}
{!! Toastr::message() !!}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0e263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha384-ZvpUoO/+P1k22xC6a7gTFOG9x5SA7Dwx1ucOM9omFwoiRMRlPQQHxz58yyMvm/5D" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    tinymce.init({
        selector: '#description',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });
</script>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">1 Brilliant : English</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Tutor</a></li>
                        <li class="breadcrumb-item active">Class </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('subclass_t/main/page') }}">Announcement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('subclass_t/material/page') }}">Materials</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('subclass_t/task/page') }}">Task</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('subclass_t/review/page') }}">Review</a>
            </li>
        </ul>

        <div class="col">
            <h1 class="page-title"></h1>
        </div>
        <div class="col">
            <h3 class="page-title">Materials</h3>
        </div>


        <div class="container">
            <div class="student-group-form">
                <div class="row">
                
                    <div class="col-12 col-sm-4">
                        <div class="form-group local-forms">
                            <form action="{{ route('subclass_t/material/page') }}" method="GET">
                                <select class="form-control select" name="topic_id" onchange="this.form.submit()">
                                    <option value="">All Topics</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}" {{ request()->query('topic_id') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="search-student-btn">
                        
                        <button class="btn btn-primary dropdown-toggle" type="button" id="createDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                + Create
                            </button>
                            <div class="dropdown-menu" aria-labelledby="createDropdown">

                                <a class="dropdown-item" href="{{ url('/subclass_t/create') }}">Notes / Material</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addTopicModal">Add Topic</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <style>
            .dropdown-item:hover,
            .dropdown-item:focus {
                background-color: #f1f1f1;
                color: #007bff;
            }

            .dropdown-item {
                font-weight: 400;
                font-size: 0.875rem;
                line-height: 1.5;
                white-space: nowrap;
            }
        </style>

        <style>
            .page-subtitle {
                border-bottom: 2px solid #000;
                display: inline-block;
                padding-bottom: 5px;
            }
        </style>

<div class="col">
    <h3 class="page-subtitle"> {{ $selectedTopicName }}</h3>
</div>
   
@foreach($materialsTutor as $material)

<div class="container clickable-card" data-url="{{ route('material.view', ['id' => $material->id]) }}">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-journal-bookmark-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                        <path d="M1 11.5v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                    </svg>
                </div>
                <div class="col-md-11 text-end">
                    <p>
                        <a class="float-left" href="{">
                            <strong>{{ $material->title }}</strong>
                        </a>
                        <span class="text-secondary">{{ $material->created_at->format('M d, Y') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event handler to all elements with class 'clickable-card'
    document.querySelectorAll('.clickable-card').forEach(function(card) {
        card.addEventListener('click', function() {
            var url = card.getAttribute('data-url');
            window.location.href = url;
        });
    });
});
</script>

<!-- Add Topic Modal -->
<div class="modal fade" id="addTopicModal" tabindex="-1" role="dialog" aria-labelledby="addTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTopicModalLabel">Add Topic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTopicForm" action="{{ route('materials.storeTopic') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="topic_name">Topic Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Topic</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


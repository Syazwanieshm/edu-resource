@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}


<!--MATH PAGE-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Mathematic</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Student</a></li>
                        <li class="breadcrumb-item active">Class </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
    <li class="nav-item">
    
        <a class="nav-link active" href="{{ route('subclass/main/math') }}">Announcement</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('subclass/material/math') }}">Materials</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('subclass/task/math') }}">Task</a>
    </li>
   
</ul>


               <div class="col">
                    <h1 class="page-title"></h1>
                    
                </div>
                <div class="col">
                    <h3 class="page-title">Task</h3>
                    
                </div>


<div class="container">


    <div class="student-group-form">

        <div class="row">
                
            <div class="col-12 col-sm-4">
            <div class="form-group local-forms">
                            <form action="{{ route('subclass/task/math') }}" method="GET">
                                <select class="form-control select" name="topic_id" onchange="this.form.submit()">
                                    <option value="">All Topics</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}" {{ request()->query('topic_id') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
            </div>

               


        </div>
   </div>
</div>

<style>
    .page-subtitle {
        border-bottom: 2px solid #000; /* You can adjust the color and thickness as needed */
        display: inline-block; /* Ensures the border only covers the width of the text */
        padding-bottom: 5px; /* Adjust the padding to control the distance between text and line */
    }
</style>

<div class="col">
    <h3 class="page-subtitle"> {{ $selectedTopicName }}</h3>
</div>
   
        @foreach($taskStud as $task)
      
        <div class="container clickable-card" data-url="{{ route('taskStudent.view', ['id' => $task->id]) }}">
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
                        <a class="float-left" href="">
                            <strong>{{ $task->title }}</strong>
                        </a>
                        <span class="text-secondary">{{ $task->created_at->format('M d, Y') }}</span>
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
        

</div>
</div>
@endsection
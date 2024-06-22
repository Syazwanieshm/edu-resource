@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Resources Materials </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Student</a></li>
                        <li class="breadcrumb-item active">Resources Materials</li>
                    </ul>
                </div>
            </div>
        </div>

        
     
        <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('resources_a/pyqStud/page') ? 'active' : '' }}" id="pyq-tab" href="{{ route('resources_a/pyqStud/page') }}" role="tab" aria-controls="pyq" aria-selected="{{ request()->is('resources_a/pyqTutor/page') ? 'true' : 'false' }}">Past Year Question</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('resources_a/textbookStud/page') ? 'active' : '' }}" id="textbook-tab" href="{{ route('resources_a/textbookStud/page') }}" role="tab" aria-controls="textbook" aria-selected="{{ request()->is('resources_a/textbookTutor/page') ? 'true' : 'false' }}">e-Text Book</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('resources_a/moduleStud/page') ? 'active' : '' }}" id="module-tab" href="{{ route('resources_a/moduleStud/page') }}" role="tab" aria-controls="module" aria-selected="{{ request()->is('resources_a/moduleTutor/page') ? 'true' : 'false' }}">Module</a>
    </li>
</ul>

        </ul>

        <div class="tab-content">
        @if(request()->is('student/resources') && request()->route()->named('resources.index'))

                <div class="tab-pane active" id="pyq" role="tabpanel" aria-labelledby="pyq-tab">
                    @include('resources.pyq_stud')
                </div>
            @else
                <div class="tab-pane" id="pyq" role="tabpanel" aria-labelledby="pyq-tab"></div>
            @endif

            @if(request()->is('student/resources') && request()->route()->named('resources.index'))

                 <div class="tab-pane" id="textbook" role="tabpanel" aria-labelledby="textbook-tab">
                   @include('resources.textbook_stud')
                </div>
                @else
                <div class="tab-pane" id="textbook" role="tabpanel" aria-labelledby="textbook-tab"></div>
                @endif
          
          <div class="tab-pane" id="module" role="tabpanel" aria-labelledby="module-tab">...</div>
          <div class="tab-pane" id="tips" role="tabpanel" aria-labelledby="tips-tab">...</div>
        
   

</div>

<script>
    $(document).ready(function() {
        // Get the active tab from session storage
        var activeTab = sessionStorage.getItem('activeTab');

        // Set the active tab
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }

        // Store the active tab in session storage when a tab is clicked
        $('#myTab a').on('click', function() {
            sessionStorage.setItem('activeTab', $(this).attr('href'));
        });
    });
</script>


        @endsection
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
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active">Resources Data</li>
                    </ul>
                </div>
            </div>
        </div>

        
     
        <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('resources_a/pyq/page') ? 'active' : '' }}" id="pyq-tab" href="{{ route('resources_a/pyq/page') }}" role="tab" aria-controls="pyq" aria-selected="{{ request()->is('resources_a/pyq/page') ? 'true' : 'false' }}">Past Year Question</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('resources_a/textbook/page') ? 'active' : '' }}" id="textbook-tab" href="{{ route('resources_a/textbook/page') }}" role="tab" aria-controls="textbook" aria-selected="{{ request()->is('resources_a/textbook/page') ? 'true' : 'false' }}">e-Text Book</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('resources_a/module/page') ? 'active' : '' }}" id="module-tab" href="{{ route('resources_a/module/page') }}" role="tab" aria-controls="module" aria-selected="{{ request()->is('resources_a/module/page') ? 'true' : 'false' }}">Module</a>
    </li>
</ul>

        </ul>

        <div class="tab-content">
        @if(request()->is('admin/resources') && request()->route()->named('resources.index'))

                <div class="tab-pane active" id="pyq" role="tabpanel" aria-labelledby="pyq-tab">
                    @include('resources.pyq_admin')
                </div>
            @else
                <div class="tab-pane" id="pyq" role="tabpanel" aria-labelledby="pyq-tab"></div>
            @endif

            @if(request()->is('admin/resources') && request()->route()->named('resources.index'))

                 <div class="tab-pane" id="textbook" role="tabpanel" aria-labelledby="textbook-tab">
                   @include('resources.textbook_admin')
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
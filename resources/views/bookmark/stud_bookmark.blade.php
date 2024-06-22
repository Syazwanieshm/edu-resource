@extends('layouts.master')
@section('content')
{{-- Include Toastr CSS and JS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.js"></script>

{!! Toastr::message() !!}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Bookmark List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Student</a></li>
                        <li class="breadcrumb-item active">Bookmarks</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search  ...">
                </div>
            </div>
            
            <div class="col-lg-2">
                <div class="search-student-btn">
                    <button type="btn" class="btn btn-primary">Search</button>
                </div>
            </div>
            
            <div class="col-lg-2">
                <div class="search-student-btn">
                    <button type="btn" class="btn btn-primary" data-toggle="modal" data-target="#addFolderModal"> + Add Folder</button>
                </div>
            </div>
            
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <select class="form-control select  @error('gender') is-invalid @enderror" name="gender">
                        <option selected disabled></option>
                        <option value="Female">Past Year Question</option>
                        <option value="Male">Revision</option>
                        <option value="Others">TextBook</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">File Name</th>
                    <th scope="col">Date Added</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookmarks as $bookmark)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $bookmark->resource->res_name }}</td>
                    <td>{{ $bookmark->created_at->format('d/m/Y') }}</td>
                    <td class="text-end">
    <div class="actions">
        <a href="{{ route('bookmark/view', $bookmark->resource->res_id) }}" target="_blank" class="btn btn-sm bg-danger-light"><i class="bi bi-box-arrow-up-right"></i></a>
        <a href="{{ route('bookmark/download', $bookmark->resource->res_id) }}" class="btn btn-sm bg-danger-light"><i class="bi bi-box-arrow-down"></i></a>
        <form action="{{ route('bookmark/delete', $bookmark->resource->res_id) }}" class="btn btn-sm bg-success-light" method="POST" style="display: inline;">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-sm bg-danger-light"><i class="feather-trash-2 me-1"></i></button>
        </form>
    </div>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Folder Modal -->
<div class="modal fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFolderModalLabel">New Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('folder.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="folderName">Folder Name</label>
                        <input type="text" class="form-control" id="folderName" name="folder_name" required>
                        @if($errors->has('folder_name'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('folder_name') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX38iFwJqQpHMaP4aMeiP5E1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Find all delete buttons
        const deleteButtons = document.querySelectorAll('.delete-resource');

        // Add click event listener to each delete button
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Get the resource ID from the button's data attribute
                const resourceId = button.dataset.resourceId;

                // Set the resource ID value in the modal form
                document.getElementById('bookmark_id').value = resourceId;

                // Show the delete modal
                $('#resourceDelete').modal('show');
            });
        });

        // Handle add folder modal
        @if($errors->any())
            $('#addFolderModal').modal('show');
        @endif

        // Toastr notifications
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    });
</script>

<!-- Include styles -->
<style>
    .pagination .page-link {
        font-size: 14px; /* Adjust the font size as needed */
    }
</style>

<!-- Include admin resources -->
@include('resources.admin_resources')


<!-- Content container -->
<div class="content container-fluid">
    <!-- Search form -->
    <div class="student-group-form">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" id="formSearchInput" placeholder="Search by Form ...">
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" id="subjectSearchInput" placeholder="Search by Subject ...">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="search-student-btn">
                    <button type="btn" class="btn btn-primary">Search</button>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="search-student-btn">
                    <a href="{{ route('resources_a/upload_form/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Resource listing table -->
    <table class="table">
        <!-- Table headers -->
        <thead class="thead-dark">
            <!-- Header rows -->
            <tr>
                <th scope="col">#</th>
                <th scope="col">Form</th>
                <th scope="col">Subject</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through resource list -->
            @foreach($pyqList as $Index => $resource)
            <tr class="resource-row">
                <!-- Display resource data -->
                <th scope="row" class="res_id">{{ $Index +1 }}</th>
                <td>{{ $resource->form }}</td>
                <td>{{ $resource->res_name }}</td>
                <td class="text-end">
    <div class="actions">
        <!-- Conditional edit and delete buttons -->
        @if($resource->uploaded_by == Auth::id())
            <a href="{{ url('resources_a/edit/'. $resource->res_id)}}" class="btn btn-sm bg-danger-light"><i class="feather-edit"></i></a>
            <a href="{{ url('resources_a/pyq/delete/'. $resource->res_id)}}" class="btn btn-sm bg-danger-light res_delete" data-bs-toggle="modal" data-bs-target="#resourceDelete" data-res-id="{{ $resource->res_id }}"><i class="feather-trash-2 me-1"></i></a>
        @endif
        <!-- Download button available for all users -->
        <a href="{{ url('resources_a/download/'. $resource->res_id)}}" class="btn btn-sm bg-success-light"><i class="feather-download"></i></a>
        <!-- View button available for all users -->
         <a href="{{ route('resources_a/view', $resource->res_id) }}" target="_blank" class="btn btn-sm bg-info-light"><i class="feather-eye"></i></a>
    </div>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Include pagination links -->
    {{ $pyqList->links() }}

<!-- Resource delete modal -->
<div class="modal fade contentmodal" id="resourceDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header pb-0 border-bottom-0 justify-content-end">
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="feather-x-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="deleteResourceForm">
                    @csrf
                    <div class="delete-wrap text-center">
                        <div class="del-icon">
                            <i class="feather-x-circle"></i>
                        </div>
                        <input type="hidden" name="res_id" id="modal_res_id" value="">
                        <h2>Are you sure you want to delete this resource?</h2>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-success me-2">Yes</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include scripts -->
@section('script')
<script>
    $(document).ready(function() {
        $('#formSearchInput, #subjectSearchInput').on('input', function() {
            var formValue = $('#formSearchInput').val().toLowerCase();
            var subjectValue = $('#subjectSearchInput').val().toLowerCase();
            
            $('.resource-row').each(function() {
                var formText = $(this).find('td:nth-child(2)').text().toLowerCase();
                var subjectText = $(this).find('td:nth-child(3)').text().toLowerCase();
                
                if (formText.indexOf(formValue) !== -1 && subjectText.indexOf(subjectValue) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endsection
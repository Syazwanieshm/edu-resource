<!-- Include styles -->
<style>
    .pagination .page-link {
        font-size: 14px; /* Adjust the font size as needed */
    }
</style>

@include('resources.stud_resources')



<!-- SEARCH SECTION -->
<div class="content container-fluid">

<div class="student-group-form">

            <div class="row">
                
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search by Form ...">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search by Subject ...">
                    </div>
                </div>
                

                <div class="col-lg-2">
                    <div class="search-student-btn">
                        <button type="btn" class="btn btn-primary">Search</button>
                    </div>
                </div>

               

            </div>
        </div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">       
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
            @foreach($moduleSList as $Index => $resource)
            <tr>
                <!-- Display resource data -->
                <th scope="row" class="res_id">{{ $Index +1 }}</th>
                <td>{{ $resource->form }}</td>
                <td>{{ $resource->res_name }}</td>
                <td class="text-end">
                    <div class="actions">
                       
                        <!-- Download button available for all users -->
                        <a href="{{ url('resources_a/download/'. $resource->res_id)}}" class="btn btn-sm bg-success-light"><i class="feather-download"></i></a>
                   
                        <!-- View button available for all users -->
                        <a href="{{ route('resources_a/view', $resource->res_id) }}" target="_blank" class="btn btn-sm bg-danger-light"><i class="bi bi-box-arrow-up-right"></i></a>
                        <button class="btn btn-sm bg-success-light bookmark-btn" data-resource-id="{{ $resource->res_id }}"><i class="feather-bookmark"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Include pagination links -->
    {{ $moduleSList->links() }}

<!-- Bookmark Button and JavaScript -->
<script>
$(document).ready(function() {
    $('.bookmark-btn').on('click', function() {
        var resourceId = $(this).data('resource-id');
        
        $.ajax({
            url: "{{ route('resources_a/store') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                resource_id: resourceId
            },
            success: function(response) {
                if(response.status == 'success') {
                    toastr.success(response.message);
                } else if(response.status == 'warning') {
                    toastr.warning(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
                console.log(xhr.responseText); // Log the error for debugging
            }
        });
    });
});


</script>

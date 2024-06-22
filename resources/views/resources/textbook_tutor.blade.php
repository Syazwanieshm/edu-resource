@include('resources.tutor_resources')

<!-- SEARCH SECTION -->
<div class="content container-fluid">

<div class="student-group-form">
        <form method="GET" action="{{ url('resources_a/textbookTutor/page') }}">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" name="form" class="form-control" placeholder="Search by Form ..." value="{{ request('form') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                        <input type="text" name="subject" class="form-control" placeholder="Search by Subject ..." value="{{ request('res_name') }}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="search-student-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
               
            </div>
        </form>
    </div>
        
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    
    <div class="d-flex flex-row flex-nowrap overflow-auto">
        @foreach($tbTList as $resource)
            <div class="card m-2" style="width: 15rem;">
            <img class="card-img-top" src="{{ URL::to('assets/img/biologyf4.jpeg') }}" alt="Card image cap">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $resource->res_name }}</h5>
                    <p class="card-text">{{ $resource->form }}</p>
                    <div class="mt-auto d-flex justify-content-between">
                      
                        <a href="{{ url('resources_a/view/' . $resource->res_id) }}" class="btn btn-primary">View</a>
                        <a href="{{ url('resources_a/download/' . $resource->res_id) }}" class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


<div class="mt-3">
    {{ $tbTList->links() }}
</div>
</div>
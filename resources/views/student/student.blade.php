
@extends('layouts.master')
@section('content')
{{-- message --}}
 {!! Toastr::message() !!}

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Students</h3>
                    <ul class="breadcrumb">
                        <<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Student Data</li>
                    </ul>
                </div>
            </div>
        </div>

          
        <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by ID ...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Name ...">
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table ">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Students</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <input id="file-upload" type="file" style="display:none;">
                                        <label for="file-upload" class="btn btn-outline-primary"><i class="fas fa-upload"></i> Import</label>
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                        <a href="{{ route('student/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>

                                   <!--Javascript for the file of student data (excel file) to be uploaded -->
                                   <script>
                                      document.getElementById('file-upload').addEventListener('change', handleFileUpload);

                                        function handleFileUpload(event) {
                                            const file = event.target.files[0];
                                                if (file) {
                                                // Here, you can implement code to handle the file upload
                                                console.log('File selected:', file.name);
                                                 // You can use JavaScript Fetch API or any other method to upload the file to your server
                                                 // Example using Fetch API:
                                                 // fetch('/upload', {
                                                 //     method: 'POST',
                                                 //     body: file
                                                 // })
                                                 // .then(response => {
                                                 //     console.log('File uploaded successfully.');
                                                 // })
                                                 // .catch(error => {
                                                 //     console.error('Error uploading file:', error);
                                                 // });
                                                } else {
                                                console.log('No file selected.');
                                               }
                                               }
                                     </script>


                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <!--<th>DOB</th>-->
                                            <!--<th>Parent Name</th>-->
                                            <th>Mobile Number</th>
                                            <th>Address</th>
                                            <th>Date Join</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentList as $list )
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td hidden class="id">{{ $list->id }}</td>
                                            <td>{{ $list->admission_id }}</td>

                                            <!-- GAMBAR YG DH DIUPLOAD -->
                                            <!--<td hidden class="avatar">{{ $list->upload }}</td>-->

                                            <td>
                                                <!--<h2 class="table-avatar">-->
                                                    <!--<a href="student-details.html"class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ Storage::url('student-photos/'.$list->upload) }}" alt="User Image">
                                                    </a>-->
                                                    <a href="student-details.html">{{ $list->first_name }} {{ $list->last_name }}</a>
                                                <!--</h2>-->
                                            </td>
                                            <!--<td>{{ $list->class }} </td>-->
                                            <td>{{ $list->class ? $list->class->class_name : '' }}</td>
                                            
                                            <!--<td>{{ $list->date_of_birth }}</td>-->
                                            <!--<td>Soeng Soeng</td>-->
                                            <td>{{ $list->phone_number }}</td>
                                            <td>{{ $list->address }}</td>
                                            <td>{{ $list->join_date }}</td>
                                            <td>
                                            <div class="edit-delete-btn">
                                                @if ($list->status === 'Active')
                                                <a class="text-success">{{ $list->status }}</a>
                                                @elseif ($list->status === 'Inactive')
                                                <a class="text-warning">{{ $list->status }}</a>
                                                @elseif ($list->status === 'Disable')
                                                <a class="text-danger" >{{ $list->status }}</a>
                                                @else 
                                                @endif
                                            </div>
                                        </td>
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ url('student/edit/'.$list->id) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-id="{{ $list->id }}" data-bs-target="#deleteStudent">
                                                    <i class="feather-trash-2 me-1"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for Student Delete --}}
    <div class="modal fade contentmodal" id="deleteStudent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header pb-0 border-bottom-0 justify-content-end">
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x-circle"></i></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="deleteStudentForm">
                        @csrf
                        @method('POST')
                        <div class="delete-wrap text-center">
                            <div class="del-icon">
                                <i class="feather-x-circle"></i>
                            </div>
                            <input type="hidden" name="id" class="e_id" value="">
                            <h2>Sure you want to delete?</h2>
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

    @section('script')
    {{-- Delete JavaScript --}}
    <script>
        $(document).on('click', '.student_delete', function() {
            var studentId = $(this).data('id');
            var url = "{{ route('student/delete', ':id') }}";
            url = url.replace(':id', studentId);
            $('#deleteStudentForm').attr('action', url);
        });
    </script>
    @endsection

@endsection

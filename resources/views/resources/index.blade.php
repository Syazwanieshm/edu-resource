@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Resources</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Resource Name</th>
                <th scope="col">File Name</th>
                <th scope="col">Type</th>
                <th scope="col">Uploaded By</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
            <tr>
                <th scope="row">{{ $resource->id }}</th>
                <td>{{ $resource->res_name }}</td>
                <td>{{ $resource->file_name }}</td>
                <td>{{ $resource->res_type }}</td>
                <td>{{ $resource->uploader->name }}</td>
                <td>
                    <form action="{{ route('resources.delete', $resource->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

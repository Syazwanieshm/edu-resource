<!DOCTYPE html>
<html>
<head>
    <title>Student Performance Report</title>
</head>
<body>
    <h1>Student Performance Report</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Form</th>
                <th>Class</th>
                <th>Average Carry Mark</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->student_id }}</td>
                <td>{{ $student->form }}</td>
                <td>{{ $student->class }}</td>
                <td>{{ $student->carryMarksDummy->avg('carry_mark') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

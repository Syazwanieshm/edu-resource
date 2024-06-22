@if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
@include('dashboard.admindash')
@endif

@if (Session::get('role_name') === 'Teachers')
@include('dashboard.teacher_dashboard')
@endif

@if (Session::get('role_name') === 'Student')
@include('dashboard.student_dashboard')
@endif
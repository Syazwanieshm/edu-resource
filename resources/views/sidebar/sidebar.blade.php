<!--ADMINNNNNN-->
<!--KALAU YANG LOGIN TU ADMIN, THEN DIA BOLEH ACCESS SEMUA NI-->
@if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!--MAIN MENU TEXT-->
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <!--SETTING-->
                <li class="{{set_active(['setting/page'])}}"><!--CODE YG MENAKTIFKAN SETTING PAGE UTK DIPLAY AS UI-->
                    <a href="{{ route('setting/page') }}"><!--REDIRRECT KE SETTING PAGE BILA USER TEKAN-->
                        <i class="fas fa-cog"></i> 
                        <span>Settings</span>
                    </a>
                </li>
                
                <!--DASHBOARD-->
                <li class="{{set_active(['home'])}}">
                    <a href="{{ route('home') }}" class="{{set_active(['home'])}}">
                        <i class="feather-grid"></i>
                        <span> Dashboard</span> 
                        <!--<span class="menu-arrow"></span>-->
                    </a>
                    <!--<ul>-->
                        <!--<li><a href="{{ route('home') }}" class="{{set_active(['home'])}}">Admin Dashboard</a></li>-->
                        <!--<li><a href="{{ route('teacher/dashboard') }}" class="{{set_active(['teacher/dashboard'])}}">Teacher Dashboard</a></li>-->
                        <!--<li><a href="{{ route('student/dashboard') }}" class="{{set_active(['student/dashboard'])}}">Student Dashboard</a></li>-->
                    <!--</ul>-->
                </li>
                
                <!--MANAGEMENT SECTION-->
                <li class="menu-title">
                    <span>Management</span>
                </li>

                <!--USER MANAGEMENT-->     
                <li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-shield-alt"></i>
                        <span>User Management</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <!--DISPLAY LIST OF USER-->
                        <li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>
                   </ul>
                </li>
                
                 <!--STUDENT DATA SECTION-->
                <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} ">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Students Data</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <!--BASED ON RESOURCES/VIEWS/STUDENT-->
                        <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                        <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                        <li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li>
                        <!--<li><a href=""  class="{{ (request()->is('student/profile/*')) ? 'active' : '' }}">Student View</a></li>-->
                    </ul>
                </li>
                
                <!--TUTOR DATA SECTION-->
                <li class="submenu  {{set_active(['teacher/add/page','teacher/list/page','teacher/grid/page','teacher/edit'])}} {{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span> Tutor Data</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <!--BASED ON RESOURCES/VIEWS/TEACHER-->
                        <li><a href="{{ route('teacher/list/page') }}" class="{{set_active(['teacher/list/page','teacher/grid/page'])}}">Tutor List</a></li>
                        <li><a href="{{ route('teacher/add/page') }}" class="{{set_active(['teacher/add/page'])}}">Tutor Add</a></li>
                        <li><a class="{{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">Tutor Edit</a></li>
                    </ul>
                </li>
                
                <li class="submenu {{set_active(['department/add/page','department/edit/page'])}}">
                    <a href="#"><i class="fas fa-building"></i>
                        <span> Departments Data</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('department/list/page') }}" class="{{set_active(['department/list/page'])}}">Department List</a></li>
                        <li><a href="{{ route('department/add/page') }}" class="{{set_active(['department/add/page'])}}">Department Add</a></li>
                        <li><a class="{{ (request()->is('department/edit/*')) ? 'active' : '' }}">Department Edit</a></li>
                        
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-book-reader"></i>
                        <span> Subject Data</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('subject/list/page') }}" class="{{set_active(['suject/list/page'])}}">Subject List</a></li>
                        <li><a href="{{ route('subject/add/page') }}" class="{{set_active(['subject/add/page'])}}">Subject Add</a></li>
                        <li><a class="{{ (request()->is('subject/edit/*')) ? 'active' : '' }}">Subject Edit</a></li>
                        
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-book-reader"></i>
                        <span>  Classroom Data</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="subjects.html">Classroom List</a></li>
                        <li><a href="add-subject.html">Add Classroom</a></li>
                        <!--<li><a href="edit-subject.html">Subject Edit</a></li>-->
                    </ul>
                </li>
                
                <!--RESOURCES MANAGEMENT-->
                <li class="{{set_active(['setting/page'])}}"><!--CODE YG MENAKTIFKAN RESOURCES PAGE UTK DIPLAY AS UI-->
                    <a href="{{ route('setting/page') }}"><!--REDIRRECT KE RESOURCES PAGE BILA USER TEKAN-->
                    <i class="fas fa-book-reader"></i> 
                        <span>Resources Materials</span>
                    </a>
                </li>


                <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span> Student Report </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="invoices.html">Invoices List</a></li>
                        <!--<li><a href="invoice-grid.html">Invoices Grid</a></li>-->
                        <!--<li><a href="add-invoice.html">Add Invoices</a></li>-->
                        <!--<li><a href="edit-invoice.html">Edit Invoices</a></li>-->
                        <!--<li><a href="view-invoice.html">Invoices Details</a></li>-->
                        <!--<li><a href="invoices-settings.html">Invoices Settings</a></li>-->
                    </ul>
                </li>
                
                
            </ul>
        </div>
    </div>
</div>
@endif

<!--TUTORRRRR-->
<!--KALAU YANG LOGIN TU TUTOR, THEN DIA BOLEH ACCESS SEMUA NI-->
@if (Session::get('role_name') === 'Teachers')
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!--MAIN MENU TEXT-->
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <!--SETTING-->
                <!--<li class="{{set_active(['setting/page'])}}">--><!--CODE YG MENAKTIFKAN SETTING PAGE UTK DIPLAY AS UI-->
                    <!--<a href="{{ route('setting/page') }}">--><!--REDIRRECT KE SETTING PAGE BILA USER TEKAN-->
                        <!--<i class="fas fa-cog"></i> 
                        <span>Settings</span>
                    </a>
                </li>-->
                
                <!--DASHBOARD-->
                <li class="{{set_active(['teacher/dashboard'])}}">
                    <a href="{{ route('teacher/dashboard') }}" class="{{set_active(['teacher/dashboard'])}}">
                        <i class="feather-grid"></i>
                        <span> Dashboard</span> 
                        <!--<span class="menu-arrow"></span>-->
                    </a>
                    <!--<ul>-->
                        <!--<li><a href="{{ route('home') }}" class="{{set_active(['home'])}}">Admin Dashboard</a></li>-->
                        <!--<li><a href="{{ route('teacher/dashboard') }}" class="{{set_active(['teacher/dashboard'])}}">Teacher Dashboard</a></li>-->
                        <!--<li><a href="{{ route('student/dashboard') }}" class="{{set_active(['student/dashboard'])}}">Student Dashboard</a></li>-->
                    <!--</ul>-->
                </li>
                
                <!--MANAGEMENT SECTION-->
                <li class="menu-title">
                    <span>Teaching Section</span>
                </li>

                <!--USER MANAGEMENT-->     
                <!--<li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">-->
                    <!--<a href="#"><i class="fas fa-shield-alt"></i>
                        <span>User Management</span> 
                        <span class="menu-arrow"></span>
                    </a>-->
                    <!--<ul>-->
                        <!--DISPLAY LIST OF USER-->
                        <!--<li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>-->
                   <!-- </ul>-->
                <!--</li>-->
                
                 <!--TEACHING SECTION-->
                <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} ">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Teaching Classroom</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <!--BASED ON RESOURCES/VIEWS/STUDENT-->
                        <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Subject_Name</a></li>
                        <!--<li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>-->
                        <!--<li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li>-->
                        <!--<li><a href=""  class="{{ (request()->is('student/profile/*')) ? 'active' : '' }}">Student View</a></li>-->
                    </ul>
                </li>
                
               <!--RESOURCES-->
                <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span> Resources </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="invoices.html">Invoices List</a></li>
                        <!--<li><a href="invoice-grid.html">Invoices Grid</a></li>-->
                        <!--<li><a href="add-invoice.html">Add Invoices</a></li>-->
                        <!--<li><a href="edit-invoice.html">Edit Invoices</a></li>-->
                        <!--<li><a href="view-invoice.html">Invoices Details</a></li>-->
                        <!--<li><a href="invoices-settings.html">Invoices Settings</a></li>-->
                    </ul>
                </li>
                
                
            </ul>
        </div>
    </div>
</div>
@endif

<!--STUDENT-->
<!--KALAU YANG LOGIN TU STUDENT, THEN DIA BOLEH ACCESS SEMUA NI-->
@if (Session::get('role_name') === 'Student')
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!--MAIN MENU TEXT-->
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                 <!--SETTING-->
                <!--<li class="{{set_active(['setting/page'])}}">--><!--CODE YG MENAKTIFKAN SETTING PAGE UTK DIPLAY AS UI-->
                    <!--<a href="{{ route('setting/page') }}">--><!--REDIRRECT KE SETTING PAGE BILA USER TEKAN-->
                        <!--<i class="fas fa-cog"></i> 
                        <span>Settings</span>
                    </a>
                </li>-->
                
                <!--DASHBOARD-->
                <li class="{{set_active(['student/dashboard'])}}">
                    <a href="{{ route('student/dashboard') }}" class="{{set_active(['student/dashboard'])}}">
                        <i class="feather-grid"></i>
                        <span> Dashboard</span> 
                        <!--<span class="menu-arrow"></span>-->
                    </a>
                    <!--<ul>-->
                        <!--<li><a href="{{ route('home') }}" class="{{set_active(['home'])}}">Admin Dashboard</a></li>-->
                        <!--<li><a href="{{ route('teacher/dashboard') }}" class="{{set_active(['teacher/dashboard'])}}">Teacher Dashboard</a></li>-->
                        <!--<li><a href="{{ route('student/dashboard') }}" class="{{set_active(['student/dashboard'])}}">Student Dashboard</a></li>-->
                    <!--</ul>-->
                </li>
                
                <!--MANAGEMENT SECTION-->
                <li class="menu-title">
                    <span>Learning Section</span>
                </li>

                <!--USER MANAGEMENT-->     
                <!--<li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">-->
                    <!--<a href="#"><i class="fas fa-shield-alt"></i>
                        <span>User Management</span> 
                        <span class="menu-arrow"></span>
                    </a>-->
                    <!--<ul>-->
                        <!--DISPLAY LIST OF USER-->
                        <!--<li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>-->
                   <!-- </ul>-->
                <!--</li>-->
                
                 <!--CLASSROOM SECTION-->
                <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} ">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span>Classroom _Name</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <!--BASED ON RESOURCES/VIEWS/STUDENT-->
                        <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Subject_Name</a></li>
                        <!--<li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>-->
                        <!--<li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li>-->
                        <!--<li><a href=""  class="{{ (request()->is('student/profile/*')) ? 'active' : '' }}">Student View</a></li>-->
                    </ul>
                </li>
                
               <!--RESOURCES-->
                <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span> Resources </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="invoices.html">Invoices List</a></li>
                        <!--<li><a href="invoice-grid.html">Invoices Grid</a></li>-->
                        <!--<li><a href="add-invoice.html">Add Invoices</a></li>-->
                        <!--<li><a href="edit-invoice.html">Edit Invoices</a></li>-->
                        <!--<li><a href="view-invoice.html">Invoices Details</a></li>-->
                        <!--<li><a href="invoices-settings.html">Invoices Settings</a></li>-->
                    </ul>
                </li>

                <!--BOOKMARKS-->
                <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span> Bookmarks </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="invoices.html">Bookmark List</a></li>
                        <!--<li><a href="invoice-grid.html">Invoices Grid</a></li>-->
                        <!--<li><a href="add-invoice.html">Add Invoices</a></li>-->
                        <!--<li><a href="edit-invoice.html">Edit Invoices</a></li>-->
                        <!--<li><a href="view-invoice.html">Invoices Details</a></li>-->
                        <!--<li><a href="invoices-settings.html">Invoices Settings</a></li>-->
                    </ul>
                </li>
                
                
            </ul>
        </div>
    </div>
</div>
@endif
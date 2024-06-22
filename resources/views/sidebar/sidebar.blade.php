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
               <!-- <li class="{{set_active(['setting/page'])}}">--><!--CODE YG MENAKTIFKAN SETTING PAGE UTK DIPLAY AS UI-->
                   <!-- <a href="{{ route('setting/page') }}">--><!--REDIRRECT KE SETTING PAGE BILA USER TEKAN-->
                        <!--<i class="fas fa-cog"></i> 
                        <span>Settings</span>
                    </a>
                </li>-->
                
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
                        <span> Teacher Data</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <!--BASED ON RESOURCES/VIEWS/TEACHER-->
                        <li><a href="{{ route('teacher/list/page') }}" class="{{set_active(['teacher/list/page','teacher/grid/page'])}}">Teacher List</a></li>
                        <li><a href="{{ route('teacher/add/page') }}" class="{{set_active(['teacher/add/page'])}}">Teacher Add</a></li>
                        <li><a class="{{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">Teacher Edit</a></li>
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
                        <li><a href="{{ route('class/list/page') }}" class="{{set_active(['class/list/page'])}}">Class List</a></li>
                        <li><a href="{{ route('class/add/page') }}" class="{{set_active(['class/add/page'])}}">Class Add</a></li>
                        <li><a class="{{ (request()->is('class/edit/*')) ? 'active' : '' }}">Class Edit</a></li>
                        
                    </ul>
                </li>
                
             <!-- RESOURCES MANAGEMENT -->
<li class="{{ set_active(['resources_a/view/page']) }}">
    <!-- CODE YG MENAKTIFKAN RESOURCES PAGE UTK DIPLAY AS UI -->
    <a href="{{ route('resources_a/pyq/page') }}">
        <!-- REDIRRECT KE RESOURCES PAGE BILA USER TEKAN -->
        <i class="fas fa-book-reader"></i>
        <span>Resources Materials</span>
    </a>
</li>



                <!-- REPORT MANAGEMENT -->
<li class="{{ set_active(['report.index.page']) }}">
    <!-- CODE TO ACTIVATE RESOURCE PAGE TO DISPLAY AS UI -->
    <a href="{{ route('report.index.page') }}">
        <!-- REDIRECT TO RESOURCE PAGE WHEN USER CLICKS -->
        <i class="fas fa-book-reader"></i> 
        <span>Annual Report</span>
    </a>
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

                <!--DASHBOARD-->
                <li class="{{ set_active(['teacher/dashboard']) }}">
                    <a href="{{ route('teacher/dashboard') }}" class="{{ set_active(['teacher/dashboard']) }}">
                        <i class="feather-grid"></i>
                        <span> Dashboard</span>
                    </a>
                </li>
                
                <!--MANAGEMENT SECTION-->
                <li class="menu-title">
                    <span>Teaching Section</span>
                </li>

<!-- TEACHING SECTION -->
<li class="submenu {{ set_active(['student/list', 'student/grid', 'student/add/page']) }} {{ (request()->is('student/edit/*')) ? 'active' : '' }}">
    <a href="#"><i class="fas fa-graduation-cap"></i>
        <span> Teaching Classroom</span>
        <span class="menu-arrow"></span>
    </a>
    <ul>
        <!-- BASED ON RESOURCES/VIEWS/STUDENT -->
        <li><a href="{{ route('subclass_t/main/page') }}" class="{{ set_active(['subclass_t/main/page']) }}">1 Brilliant : English </a></li>
        <li><a href="{{ route('subclass_t/main/page') }}" class="{{ set_active(['subclass_t/main/page']) }}">1 Creative : English </a></li>
        <li><a href="{{ route('subclass_t/main/page') }}" class="{{ set_active(['subclass_t/main/page']) }}">2 Brilliant : English </a></li>
        <!-- Replace 'Link Text' with actual text to display -->
    </ul>
</li>





         
   
       
                
               <!-- RESOURCES MANAGEMENT -->
<li class="{{ set_active(['resources_a/view/page']) }}">
    <!-- CODE YG MENAKTIFKAN RESOURCES PAGE UTK DIPLAY AS UI -->
    <a href="{{ route('resources_a/pyqTutor/page') }}">
        <!-- REDIRRECT KE RESOURCES PAGE BILA USER TEKAN -->
        <i class="fas fa-book-reader"></i>
        <span>Resources Materials</span>
    </a>
</li>
                
            </ul>
        </div>
    </div>
</div>
@endif

<!--STUDENT-->
@if (Session::get('role_name') === 'Student')
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <!-- Main Menu Text -->
                    <li class="menu-title">
                        <span>Main Menu</span>
                    </li>

                    <!-- Dashboard -->
                    <li class="{{ set_active(['student/dashboard']) }}">
                        <a href="{{ route('student/dashboard') }}" class="{{ set_active(['student/dashboard']) }}">
                            <i class="feather-grid"></i>
                            <span> Dashboard</span>
                        </a>
                    </li>

                    <!-- Learning Section -->
                    <li class="menu-title">
                        <span>Learning Section</span>
                    </li>

        


<!-- Display Class Name and Subjects -->

    <li class="{{ set_active(['subclass/main/page']) }}">
        <a href="#" class="not-clickable">
            <i class="fas fa-graduation-cap"></i>
           
           <span>Classroom</span>
            <span class="menu-arrow"></span>
        </a>
        <ul>
        
                <li>
                    <a href="{{ route('subclass/main/page') }}" class="{{ set_active (['subclass/main/page']) }}">
                     English
                    </a>
                </li>
                <li>
                    <a href="{{ route('subclass/main/math') }}" class="{{ set_active (['subclass/main/math']) }}">
                     Mathematic
                    </a>
                </li>
                <li>
                    <a href="{{ route('subclass/main/sn') }}" class="{{ set_active (['subclass/main/sn']) }}">
                     Science
                    </a>
                </li> <li>
                    <a href="{{ route('subclass/main/htr') }}" class="{{ set_active (['subclass/main/htr']) }}">
                     History
                    </a>
                </li> <li>
                    <a href="{{ route('subclass/main/page') }}" class="{{ set_active (['subclass/main/page']) }}">
                     Malay Language
                    </a>
                </li>
            
        </ul>
    </li>




                
                            <!-- RESOURCES MANAGEMENT -->
<li class="{{ set_active(['resources_a/view/page']) }}">
    <!-- CODE YG MENAKTIFKAN RESOURCES PAGE UTK DIPLAY AS UI -->
    <a href="{{ route('resources_a/pyqStud/page') }}">
        <!-- REDIRRECT KE RESOURCES PAGE BILA USER TEKAN -->
        <i class="fas fa-book-reader"></i>
        <span>Resources Materials</span>
    </a>
</li>

                <!--BOOKMARKS-->
                <li class="{{set_active(['bookmark/view/page'])}}"><!--CODE YG MENAKTIFKAN RESOURCES PAGE UTK DIPLAY AS UI-->
                    <a href="{{ route('bookmark/view/page') }}"><!--REDIRRECT KE RESOURCES PAGE BILA USER TEKAN-->
                    <i class="fas fa-book-reader"></i> 
                        <span>Bookmarks</span>
                    </a>
                </li>
                
                
            </ul>
        </div>
    </div>
</div>
@endif
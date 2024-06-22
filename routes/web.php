<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TypeFormController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TutorClassController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SidebarController;








/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('home');
    });
    Route::get('home',function()
    {
        return view('home');
    });
});

Auth::routes();


Route::controller(SidebarController::class)->group(function () {
   // Route::get('/sidebar', [SidebarController::class, 'sidebarData'])->middleware('auth')->name('sidebar');
    //Route::get('sidebar', [SidebarController::class, 'loadSidebar'])->name('sidebar.load');
    Route::get('/sidebar', 'SidebarController@sidebar')->name('sidebar');


});
// ----------------------------login ------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('change/password', 'changePassword')->name('change/password');
});

// ----------------------------- register -------------------------//
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register','storeUser')->name('register');    
});

// -------------------------- main dashboard ----------------------//
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->middleware('auth')->name('home');
    Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
    Route::get('admindash/dashboard', 'adminDashboardIndex')->middleware('auth')->name('admin/dashboard');
    Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
    Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
});

// ----------------------------- user controller -------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('list/users', 'index')->middleware('auth')->name('list/users');
    Route::post('change/password', 'changePassword')->name('change/password');
    Route::get('view/user/edit/{id}', 'userView')->middleware('auth');
    Route::post('user/update', 'userUpdate')->name('user/update');
    
    Route::post('user/delete/{id}', [UserManagementController::class, 'userDelete'])->name('user/delete');


    Route::get('role/view', 'showAddRole')->name('role/view');
    Route::post('role/save', 'addRole')->name('role/save'); // role name

    Route::get('admin/add/page', 'adminAdd')->middleware('auth')->name('admin/add/page'); // page admin
    Route::post('admin/add/save', 'adminSave')->name('admin/add/save'); // save record admin

    Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
    Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student

    Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page');
    Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save');
});

// ------------------------ setting -------------------------------//
Route::controller(Setting::class)->group(function () {
    Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
});

// ------------------------ student -------------------------------//
Route::controller(StudentController::class)->group(function () {
    Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
    Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
    Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
    Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
    Route::get('student/edit/{id}', 'studentEdit'); // view for edit
    Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
    Route::post('student/delete/{id}', [StudentController::class, 'studentDelete'])->name('student/delete');
    Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
});

// ------------------------ teacher -------------------------------//
Route::controller(TeacherController::class)->group(function () {
    Route::get('teacher/main/page', 'main')->middleware('auth')->name('teacher/main/page');
    Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page');
    Route::get('teacher/list/page', 'teacherList')->middleware('auth')->name('teacher/list/page');
    Route::get('teacher/grid/page', 'teacherGrid')->middleware('auth')->name('teacher/grid/page');
    Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save');
    Route::get('teacher/edit/{id}', 'editRecord');
    Route::post('teacher/update', 'updateRecordTeacher')->name('teacher/update');
    Route::post('teacher/delete/{id}', [TeacherController::class, 'teacherDelete'])->name('teacher/delete');

});

//Route::put('teacher/update/{id}', [TeacherController::class, 'updateRecordTeacher'])->name('teacher.update');

//Route::get('teacher/edit/{id}', [TeacherController::class, 'teacherEditView'])->name('teacher/edit');
//Route::get('teacher/edit/{id}', [TeacherController::class, 'departmentView'])->name('teacher/edit/{id}');
//Route::post('teacher/update/{id}', [TeacherController::class, 'updateRecordTeacher'])->name('teacher/update');

// ----------------------- department -----------------------------//

Route::controller(DepartmentController::class)->group(function () {
    Route::get('department/list/page', 'departmentList')->middleware('auth')->name('department/list/page');
    Route::get('department/add/page', 'departmentAdd')->middleware('auth')->name('department/add/page');
    Route::get('department/edit/{id}', 'departmentEdit'); // edit department
    Route::post('department/save', 'departmentSave')->middleware('auth')->name('department/save');
    Route::post('department/update', 'departmentUpdate')->name('department/update');
    Route::post('department/delete', 'departmentDelete')->name('department/delete');
});


// ----------------------- subject -----------------------------//

Route::resource('subject', SubjectController::class);
Route::controller(SubjectController::class)->group(function () {
    //Route::get('subject', [SubjectController::class, 'subject']);
    Route::get('/subject', 'SubjectController@subject')->name('subject');
    Route::get('subject/list/page', 'subjectList')->middleware('auth')->name('subject/list/page'); // subject/list/page
    Route::get('subject/add/page', 'subjectAdd')->middleware('auth')->name('subject/add/page'); // page add subject
    Route::get('subject/edit/{id}', 'subjectEdit'); // edit subject
    Route::post('subject/save', 'subjectSave')->middleware('auth')->name('subject/save'); // save record
    Route::post('subject/update', 'subjectUpdate')->middleware('auth')->name('subject/update'); // update record
    Route::post('subject/delete', 'subjectDelete')->name('subject/delete'); // delete record subject
});

// ----------------------- class -----------------------------//

Route::resource('class', ClassController::class);
Route::controller(ClassController::class)->group(function () {
    

    Route::get('/class', 'ClassController@class')->name('class');
    Route::get('class/list/page', 'classList')->middleware('auth')->name('class/list/page'); // class/list/page
    Route::get('class/add/page', 'classAdd')->middleware('auth')->name('class/add/page'); // page add class
    Route::get('class/edit/{id}', 'classEdit'); // edit subject
    Route::post('class/save', 'classSave')->middleware('auth')->name('class/save'); // save record

    Route::post('class/update', 'classUpdate')->middleware('auth')->name('class/update'); // update record
    Route::post('class/delete', 'classDelete')->name('class/delete'); // delete record class
      // Route for retrieving teacher assignments
    Route::get('class/assignments/{teacherId}', [ClassController::class, 'teacherAssignments'])->name('class/teacher/assignments');
    Route::get('class/teacherView/class', 'showTeacherClassButton')->middleware('auth')->name('class/teacherView/class'); // page add class

    
 
});
Route::post('/class/deleteSubjects', 'ClassController@deleteSubjects')->name('class.deleteSubjects');

//Route::get('class/add/page', [SubjectController::class, 'subjectView'])->name('class/add/page');

// ----------------------- Resources Materials-----------------------------//

Route::resource('resources_a', ResourcesController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/resources_a', [ResourcesController::class, 'resources'])->name('resources_a');

    //ADMIN
    Route::get('resources_a/view/page', [ResourcesController::class, 'main'])->name('resources_a/view/page'); // main
    Route::get('resources_a/pyq/page', [ResourcesController::class, 'pyq'])->name('resources_a/pyq/page'); 
    Route::get('resources_a/textbook/page', [ResourcesController::class, 'textbook'])->name('resources_a/textbook/page'); 
    Route::get('resources_a/module/page', [ResourcesController::class, 'module'])->name('resources_a/module/page'); 

    Route::get('resources_a/upload_form/page', [ResourcesController::class, 'showUploadForm'])->name('resources_a/upload_form/page'); 
    Route::get('resources_a/upload_module/page', [ResourcesController::class, 'showUploadModule'])->name('resources_a/upload_module/page'); 
    Route::get('resources_a/upload_tb/page', [ResourcesController::class, 'showUploadTb'])->name('resources_a/upload_tb/page'); 

    Route::post('resources_a/uploadPyq', [ResourcesController::class, 'uploadPyq'])->name('resources_a/uploadPyq'); // save record
    Route::post('resources_a/uploadModule', [ResourcesController::class, 'uploadModule'])->name('resources_a/uploadModule'); // save record
    Route::post('resources_a/uploadTb', [ResourcesController::class, 'uploadTb'])->name('resources_a/uploadTb'); // save record

    Route::get('resources_a/index/page', [ResourcesController::class, 'index'])->name('resources_a/index/page'); // main
    Route::get('resources_a/edit/{res_id}', [ResourcesController::class, 'edit'])->name('resources_a/edit'); // edit record pyq
    Route::get('resources_a/editModule/{res_id}', [ResourcesController::class, 'editModule'])->name('resources_a/editModule'); // edit record
    Route::get('resources_a/editTb/{res_id}', [ResourcesController::class, 'editTb'])->name('resources_a/editTb'); // edit record

    Route::post('resources_a/updatePyq/{res_id}', [ResourcesController::class, 'updatePyq'])->name('resources_a/updatePyq'); // update record
    Route::post('resources_a/updateModule/{res_id}', [ResourcesController::class, 'updateModule'])->name('resources_a/updateModule'); // update record
    Route::post('resources_a/updateTb/{res_id}', [ResourcesController::class, 'updateTb'])->name('resources_a/updateTb'); // update record


    //TEACHERS
    Route::get('resources_a/pyqTutor/page', [ResourcesController::class, 'pyqTutor'])->name('resources_a/pyqTutor/page'); 
    Route::get('resources_a/textbookTutor/page', [ResourcesController::class, 'textbookTutor'])->name('resources_a/textbookTutor/page'); 
    Route::get('resources_a/moduleTutor/page', [ResourcesController::class, 'moduleTutor'])->name('resources_a/moduleTutor/page'); 

    Route::get('resources_a/upload_pyq_tutor/page', [ResourcesController::class, 'showUploadPyqTutor'])->name('resources_a/upload_pyq_tutor/page'); 
    Route::get('resources_a/upload_module_tutor/page', [ResourcesController::class, 'showUploadModuleTutor'])->name('resources_a/upload_module_tutor/page'); 
    
    Route::post('resources_a/uploadPyqTutor', [ResourcesController::class, 'uploadPyqTutor'])->name('resources_a/uploadPyqTutor'); // save record
    Route::post('resources_a/uploadModuleTutor', [ResourcesController::class, 'uploadModuleTutor'])->name('resources_a/uploadModuleTutor'); // save record
    
    Route::get('resources_a/editPyqTutor/{res_id}', [ResourcesController::class, 'editPyqTutor'])->name('resources_a/editPyqTutor'); // edit record pyq
    Route::get('resources_a/editModuleTutor/{res_id}', [ResourcesController::class, 'editModuleTutor'])->name('resources_a/editModule'); // edit record

    Route::post('resources_a/updatePyqTutor/{res_id}', [ResourcesController::class, 'updatePyqTutor'])->name('resources_a/updatePyqTutor'); // update record
    Route::post('resources_a/updateModuleTutor/{res_id}', [ResourcesController::class, 'updateModuleTutor'])->name('resources_a/updateModuleTutor'); // update record


    Route::get('resources_a/download/{res_id}', [ResourcesController::class, 'download'])->name('resources_a/download');
    Route::get('resources_a/view/{res_id}', [ResourcesController::class, 'viewFile'])->name('resources_a/view');


     //STUDENT
     Route::get('resources_a/pyqStud/page', [ResourcesController::class, 'pyqStud'])->name('resources_a/pyqStud/page'); 
     Route::get('resources_a/textbookStud/page', [ResourcesController::class, 'textbookStud'])->name('resources_a/textbookStud/page'); 
     Route::get('resources_a/moduleStud/page', [ResourcesController::class, 'moduleStud'])->name('resources_a/moduleStud/page'); 
     Route::post('resources_a/store', [ResourcesController::class, 'store'])->name('resources_a/store');
     
     Route::post('resources_a/pyq/delete/{res_id}', [ResourcesController::class, 'resourceDelete'])->name('resources_a.pyq.delete');


     



    
});

//Route::post('resources_a/resourceDelete/{res_id}', [ResourcesController::class, 'resourceDelete'])->name('resources_a.resourceDelete');


//Route::post('resources_a/resourceDelete/{res_id}', [ResourcesController::class, 'resourceDelete'])->name('resources_a/resourceDelete');


//Route::resource('resources_a', ResourcesController::class)->only([
    ///'index', 'show', 'create', 'store', 'destroy'
//]);

//Route::group(['prefix' => 'resources_a', 'middleware' => 'auth'], function () {
    //Route::get('view/page', 'ResourcesController@main')->name('resources_a.view.page');
    //Route::get('pyq/page', 'ResourcesController@pyq')->name('resources_a.pyq.page'); 
    //Route::get('textbook/page', 'ResourcesController@textbook')->name('resources_a.textbook.page'); 
   // Route::get('module/page', 'ResourcesController@module')->name('resources_a.module.page'); 
   // Route::get('upload_form', [ResourcesController::class, 'showUploadForm'])->name('upload.form');
    //Route::post('upload', [ResourcesController::class, 'upload'])->name('upload');
   // Route::delete('resources/{id}', [ResourcesController::class, 'delete'])->name('resources.delete');
//});



// ----------------------- Admin Resources-----------------------------//

//Route::resource('resources_a', AdminResourcesController::class);
//Route::controller(AdminResourcesController::class)->group(function () {
    
    //Route::get('/resources_a', 'AdminResourcesController@resources')->name('resources_a');
   // Route::get('resources_a/view/page', 'main')->middleware('auth')->name('resources_a/view/page'); // main
    //Route::get('resources_a/pyq/page', 'pyq')->middleware('auth')->name('resources_a/pyq/page'); 
   // Route::get('resources_a/textbook/page', 'textbook')->middleware('auth')->name('resources_a/textbook/page'); 
    //Route::get('resources_a/module/page', 'module')->middleware('auth')->name('resources_a/module/page'); 
    
 
//});

// ----------------------- Tutor Resources-----------------------------//

Route::resource('resources', TutorResourcesController::class);
Route::controller(TutorResourcesController::class)->group(function () {
    
    Route::get('/resources', 'TutorResourcesController@resources')->name('resources');
    //Route::get('resources/view/page', 'main')->middleware('auth')->name('resources/view/page'); // main
    Route::get('resources/pyq/page', 'pyq')->middleware('auth')->name('resources/pyq/page'); 
    Route::get('resources/textbook/page', 'textbook')->middleware('auth')->name('resources/textbook/page'); 
    Route::get('resources/module/page', 'module')->middleware('auth')->name('resources/module/page'); 
    
 
});

// ----------------------- Student Resources-----------------------------//

Route::resource('resources', StudentResourcesController::class);
Route::controller(StudentResourcesController::class)->group(function () {
    
    Route::get('/resources', 'StudentResourcesController@resources')->name('resources');
    Route::get('resources/view/page', 'main')->middleware('auth')->name('resources/view/page'); // main
    Route::get('resources/pyq/page', 'pyq')->middleware('auth')->name('resources/pyq/page'); 
    Route::get('resources/textbook/page', 'textbook')->middleware('auth')->name('resources/textbook/page'); 
    Route::get('resources/module/page', 'module')->middleware('auth')->name('resources/module/page'); 
    

 
});

// ----------------------- Student Bookmarks-----------------------------//

Route::resource('bookmark',BookmarkController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/bookmark', [BookmarkController::class, 'book'])->name('book');
    Route::get('bookmark/view/page', [BookmarkController::class, 'main'])->middleware('auth')->name('bookmark/view/page');
    Route::post('/bookmark/store', [BookmarkController::class, 'store'])->name('bookmark.store');
    Route::get('bookmark/download/{res_id}', [BookmarkController::class, 'download'])->name('bookmark/download');
    Route::get('bookmark/view/{res_id}', [BookmarkController::class, 'viewFile'])->name('bookmark/view');
    Route::post('bookmark/delete/{res_id}', [BookmarkController::class, 'destroy'])->name('bookmark/delete');
   // Route::get('bookmark/index', [BookmarkController::class, 'getUserBookmarks'])->name('bookmark.index');
});

// ----------------------- Student Folder Bookmark-----------------------------//

Route::resource('folder',FolderController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/folder', [FolderController::class, 'folder'])->name('folder');
    Route::get('folder/create', [FolderController::class, 'create'])->name('folder.create');
    Route::post('folder/store', [FolderController::class, 'store'])->name('folder.store');

});
// ----------------------- Tutor Subject Class-----------------------------//


// Resource route for typical CRUD operations excluding 'show'
Route::resource('subclass_t', TutorClassController::class)->except(['show']);
// Additional routes grouped under the TutorClassController
Route::controller(TutorClassController::class)->middleware(['auth'])->group(function () {
    Route::get('/subclass_t', [TutorClassController::class, 'index'])->name('subclass_t.index');
    //Route::get('/subclass_t/class/{id}', [TutorClassController::class, 'show'])->name('subject.class');

    Route::get('subclass_t/main/page', [TutorClassController::class, 'main'])->middleware('auth')->name('subclass_t/main/page');
    Route::get('subclass_t/view/page', [TutorClassController::class, 'announcement'])->middleware('auth')->name('subclass_t/view/page'); 
    Route::get('subclass_t/material/page', [TutorClassController::class, 'material'])->middleware('auth')->name('subclass_t/material/page'); 
    Route::get('subclass_t/task/page', [TutorClassController::class, 'task'])->middleware('auth')->name('subclass_t/task/page'); 
    Route::get('subclass_t/review/page', [TutorClassController::class, 'review'])->middleware('auth')->name('subclass_t/review/page'); 



    //MATERIAL
    Route::get('/subclass_t/create', [TutorClassController::class, 'create'])->name('materials.create');
    Route::get('/subclass_t/topic', [TutorClassController::class, 'topic'])->middleware('auth')->name('materials.topic');
    Route::post('/subclass_t/store', [TutorClassController::class, 'store'])->name('materials.store');
    Route::post('/subclass_t/storeTopic', [TutorClassController::class, 'storeTopic'])->name('materials.storeTopic');
    Route::get('/api/class/{classId}/students', [TutorClassController::class, 'getStudents']);
    Route::resource('subclass_t', TutorClassController::class)->except(['show']);
    Route::get('subclass_t/material/{id}', [TutorClassController::class, 'viewMaterial'])->name('material.view');
   
   
    Route::get('subclass_t/edit/{id}', [TutorClassController::class, 'editMaterial'])->name('subclass_t/material/edit');
    Route::post('subclass_t/update/{id}', [TutorClassController::class, 'updateMaterial'])->name('subclass_t/material/update');
    Route::post('subclass_t/delete/{id}', [TutorClassController::class, 'destroyMaterial'])->name('subclass_t/material/delete');

    //TASK
    Route::get('subclass_t/createTask', [TutorClassController::class, 'createTask'])->name('tasks.create');
    Route::get('/subclass_t/topicTask', [TutorClassController::class, 'topicTask'])->middleware('auth')->name('tasks.topic');
    Route::post('/subclass_t/storeTask', [TutorClassController::class, 'storeTask'])->name('tasks.store');
    Route::post('/subclass_t/storeTopicTask', [TutorClassController::class, 'storeTopicTask'])->name('tasks.storeTopic');
    Route::get('/api/class/{classId}/students', [TutorClassController::class, 'getTStudents']);
    Route::get('subclass_t/task/{id}', [TutorClassController::class, 'viewTask'])->name('task.view');
   

    Route::get('subclass_t/editTask/{id}', [TutorClassController::class, 'editTask'])->name('subclass_t/task/edit');
    Route::post('subclass_t/updateTask/{id}', [TutorClassController::class, 'updateTask'])->name('subclass_t/task/update');
    Route::post('subclass_t/deleteTask/{id}', [TutorClassController::class, 'destroyTask'])->name('subclass_t/task/delete');

    Route::get('subclass_t/download/{id}', [TutorClassController::class, 'download'])->name('subclass_t/download');
    Route::get('subclass_t/downloadTask/{id}', [TutorClassController::class, 'downloadTask'])->name('subclass_t/downloadTask');
    Route::get('subclass_t/downloadStudent/{id}', [TutorClassController::class, 'downloadStudentFile'])->name('subclass_t/downloadStudentF');

    Route::get('subclass_t/viewM/{id}', [TutorClassController::class, 'viewMaterialFile'])->name('subclass_t/viewFileM');
    Route::get('subclass_t/viewT/{id}', [TutorClassController::class, 'viewTaskFile'])->name('subclass_t/viewFileT');


    Route::get('subclass_t/viewStudentFile/{id}', [TutorClassController::class, 'viewStudentFile'])->name('subclass_t/viewStudentFile');

    Route::post('subclass_t/grade/{id}', [TutorClassController::class, 'storeGrade'])->name('subclass_t/storeGrade');

  


    // Define the teaching_classroom route
    Route::get('teaching_classroom/{class_id}/{subject_id}', [TutorClassController::class, 'teachingClassroom'])
        ->middleware('auth')
        ->name('teaching_classroom');
});

// ----------------------- Student Subject Class-----------------------------//

Route::resource('subclass', StudentClassController::class);
Route::controller(StudentClassController::class)->group(function () {
   
    
    Route::get('/subclass', 'StudentClassController@subclass')->name('subclass');

    //ENGLISH
    Route::get('subclass/main/page', 'main')->middleware('auth')->name('subclass/main/page'); // main
    Route::get('subclass/view/page', 'announcement')->middleware('auth')->name('subclass/view/page'); 
    Route::get('subclass/material/page', 'material')->middleware('auth')->name('subclass/material/page'); 
    Route::get('subclass/task/page', 'task')->middleware('auth')->name('subclass/task/page'); 

    //MATH
    Route::get('subclass/main/math', 'mainMath')->middleware('auth')->name('subclass/main/math'); // main
    Route::get('subclass/material/math', 'materialMath')->middleware('auth')->name('subclass/material/math'); 
    Route::get('subclass/task/math', 'taskMath')->middleware('auth')->name('subclass/task/math'); 

    //SCIENCE
    Route::get('subclass/main/sn', 'mainSn')->middleware('auth')->name('subclass/main/sn'); // main
    Route::get('subclass/material/sn', 'materialSn')->middleware('auth')->name('subclass/material/sn'); 
    Route::get('subclass/task/sn', 'taskSn')->middleware('auth')->name('subclass/task/sn'); 

    //HISTORY
    Route::get('subclass/main/htr', 'mainHtr')->middleware('auth')->name('subclass/main/htr'); // main
    Route::get('subclass/material/htr', 'materialHtr')->middleware('auth')->name('subclass/material/htr'); 
    Route::get('subclass/task/htr', 'taskHtr')->middleware('auth')->name('subclass/task/htr'); 

    //MALAY LANGUAGE
    //Route::get('subclass/main/page', 'main')->middleware('auth')->name('subclass/main/ml'); // main
   // Route::get('subclass/view/page', 'announcement')->middleware('auth')->name('subclass/view/ml'); 
   // Route::get('subclass/material/page', 'material')->middleware('auth')->name('subclass/material/ml'); 
   // Route::get('subclass/task/page', 'task')->middleware('auth')->name('subclass/task/ml'); 
    
    Route::get('subclass/materialS/{id}', [StudentClassController::class, 'viewMaterialS'])->name('materialStudent.view');
    Route::get('subclass/taskS/{id}', [StudentClassController::class, 'viewTaskS'])->name('taskStudent.view');
    Route::post('subclass/upload', [StudentClassController::class, 'uploadStudentWork'])->name('task.uploadStudentWork');
    Route::post('subclass/deleteStudentWork/{id}', [StudentClassController::class, 'deleteStudentWork'])->name('task.deleteStudentWork');


    Route::get('subclass/download/{id}', [StudentClassController::class, 'downloadMat'])->name('subclass/download');
    Route::get('subclass/downloadTask/{id}', [StudentClassController::class, 'downloadMat'])->name('subclass/downloadTask');
    Route::get('subclass/view/{id}', [StudentClassController::class, 'viewFile'])->name('subclass/viewFile');
  

   // Route::middleware('auth:students')->group(function () {
   
       // Route::get('subclass/sidebar/list', [StudentClassController::class, 'subjectList'])->name('subclass/sidebar/list');
        //Route::get('/subclass/main/page', [StudentClassController::class, 'subjectPage'])->name('subclass/main/page');
    //});
});

// -----------------------Report-----------------------------//

Route::resource('report', ReportController::class);

// Custom routes for ReportController
Route::controller(ReportController::class)->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('report.index.page');
    Route::get('report/view/page', 'main')->middleware('auth')->name('report.view.page');
    Route::get('report/task/page', 'taskReport')->middleware('auth')->name('report.task.page');
    Route::get('report/performance/page', 'showPerformanceReport')->name('report.performance');
    Route::get('/report/pdf', [ReportController::class, 'generatePdf'])->name('generate.pdf'); // Adjusted route name here
});







<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::group(['middleware' => ['web']], function () {

Route::group(['middleware' => ['guest']], function ()
{

    Route::get('/', 'AuthController@showLogin');

    Route::post('/', 'AuthController@doLogin');

    Route::get('reset-password', 'AuthController@resetPassword');

    Route::post('reset-password', 'AuthController@processPasswordReset');

    Route::get('register', 'AuthController@showRegister');


});

Route::group(['middleware' => ['auth']], function ()
{
   
    Route::get('home', 'HomeController@index');

    Route::get('change-password', 'AuthController@changePassword');

    Route::post('change-password', 'AuthController@processPasswordChange');

    Route::get('logout', 'AuthController@doLogout');

    Route::get('welcome', 'AuthController@welcome');

    Route::get('not-found', 'AuthController@notFound');

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'AuthController@dashboard']);

    Route::get('profile', 'ProfileController@show');
    Route::get('showdata/{id}', 'ProfileController@showData');


    //Routes for add-employees

    Route::get('add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@addEmployee']);

    Route::post('add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@processEmployee']);

    Route::get('employee-manager', ['as' => 'employee-manager', 'uses' => 'EmpController@showEmployee']);

    Route::post('employee-manager', 'EmpController@searchEmployee');

    Route::get('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@importFile']);

    Route::post('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@uploadFile']);

    Route::get('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@showEdit']);

    Route::post('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@doEdit']);

    Route::get('delete-emp/{id}', ['as' => 'delete-emp', 'uses' => 'EmpController@doDelete']);

    //Routes for Bank Account details

    Route::get('bank-account-details', ['uses' => 'EmpController@showDetails']);

    Route::post('update-account-details', ['uses' => 'EmpController@updateAccountDetail']);

    //Routes for Team.

    Route::get('add-team', ['as' => 'add-team', 'uses' => 'TeamController@addTeam']);

    Route::post('add-team', ['as' => 'add-team', 'uses' => 'TeamController@processTeam']);

    Route::get('team-listing', ['as' => 'team-listing', 'uses' => 'TeamController@showTeam']);

    Route::get('edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@showEdit']);

    Route::post('edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@doEdit']);

    Route::get('delete-team/{id}', ['as' => 'delete-team', 'uses' => 'TeamController@doDelete']);

    //Routes for Role.

    Route::get('add-role', ['as' => 'add-role', 'uses' => 'RoleController@addRole']);

    Route::post('add-role', ['as' => 'add-role', 'uses' => 'RoleController@processRole']);

    Route::get('role-list', ['as' => 'role-list', 'uses' => 'RoleController@showRole']);

    Route::get('edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@showEdit']);

    Route::post('edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@doEdit']);

    Route::get('delete-role/{id}', ['as' => 'delete-role', 'uses' => 'RoleController@doDelete']);

    //Routes for Expense.

    Route::get('add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@addExpense']);

    Route::post('add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@processExpense']);

    Route::get('expense-list', ['as' => 'expense-list', 'uses' => 'ExpenseController@showExpense']);

    Route::get('edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@showEdit']);

    Route::post('edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@doEdit']);

    Route::get('delete-expense/{id}', ['as' => 'delete-expense', 'uses' => 'ExpenseController@doDelete']);

    //Routes for Leave.

    Route::get('add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@addLeaveType']);

    Route::post('add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@processLeaveType']);

    Route::get('leave-type-listing', ['as' => 'leave-type-listing', 'uses' => 'LeaveController@showLeaveType']);

    Route::get('edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@showEdit']);

    Route::post('edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@doEdit']);

    Route::get('delete-leave-type/{id}', ['as' => 'delete-leave-type', 'uses' => 'LeaveController@doDelete']);

    Route::get('apply-leave', ['as' => 'apply-leave', 'uses' => 'LeaveController@doApply']);

    Route::post('apply-leave', ['as' => 'apply-leave', 'uses' => 'LeaveController@processApply']);

    Route::get('my-leave-list', ['as' => 'my-leave-list', 'uses' => 'LeaveController@showMyLeave']);

    Route::get('total-leave-list', ['as' => 'total-leave-list', 'uses' => 'LeaveController@showAllLeave']);

    Route::post('total-leave-list', 'LeaveController@searchLeave');

    Route::get('leave-drafting', ['as' => 'leave-drafting', 'uses' => 'LeaveController@showLeaveDraft']);

    Route::post('leave-drafting', ['as' => 'leave-drafting', 'uses' => 'LeaveController@createLeaveDraft']);


    Route::get('add-leaves', ['uses' => 'LeaveController@addLeaves']);
    Route::get('add-employees-leaves', ['uses' => 'LeaveController@processLeaves']);
    Route::get('search_leaves_type', ['uses' => 'LeaveController@leaves_type'])->name('search');

    Route::get('resetleaves', ['uses' => 'LeaveController@resetleaves']);

    

    //Routes for Attendance.

    Route::get('attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@importAttendanceFile']);

    Route::post('attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@uploadFile']);

    Route::get('attendance-manager', ['as' => 'attendance-manager', 'uses' => 'AttendanceController@showSheetDetails']);

    Route::post('attendance-manager', ['as' => 'attendance-manager', 'uses' => 'AttendanceController@searchAttendance']);

    Route::get('delete-file/{id}', ['as' => 'delete-file', 'uses' => 'AttendanceController@doDelete']);

    //Routes for Assets.
    Route::get('export-asset', ['as' => 'export-asset', 'uses' => 'AssetController@exportAsset']);
    Route::get('upload-asset', ['as' => 'upload-asset', 'uses' => 'AssetController@uploadAssetView']);
    Route::post('upload-asset', ['as' => 'upload-asset', 'uses' => 'AssetController@uploadAsset']);

    Route::get('upload-accessory', ['as' => 'upload-accessory', 'uses' => 'AssetController@uploadAccessoryView']);
    Route::post('upload-accessory', ['as' => 'upload-accessory', 'uses' => 'AssetController@uploadAsset']);


    Route::get('add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@addAsset']);

    Route::post('add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@processAsset']);

    Route::get('add-accessory', ['as' => 'add-accessory', 'uses' => 'AssetController@addAccessory']);
    Route::post('add-accessory', ['as' => 'add-accessory', 'uses' => 'AssetController@processAccessory']);

    Route::get('asset-listing', ['as' => 'asset-listing', 'uses' => 'AssetController@showAsset']);
    Route::post('asset-listing', 'AssetController@showAsset');

    Route::get('asset-show/{id}', ['as' => 'asset-show', 'uses' => 'AssetController@showAssetInfo']);
    Route::get('assignment-show/{id}', ['as' => 'assignment-show', 'uses' => 'AssetController@showAssignmentInfo']);



    Route::get('edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@showEdit']);

    Route::post('edit-accessory/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@doAccessoryEdit']);
    Route::get('edit-accessory/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@showAccessoryEdit']);

    Route::post('edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@doEdit']);

    Route::get('delete-asset/{id}', ['as' => 'delete-asset', 'uses' => 'AssetController@doDelete']);

    Route::get('assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@doAssign']);

    Route::post('assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@processAssign']);

    Route::get('assignment-listing', ['as' => 'assignment-listing', 'uses' => 'AssetController@showAssignment']);
    Route::post('assignment-listing', ['as' => 'assignment-listing', 'uses' => 'AssetController@showAssignment']);


    Route::get('edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@showEditAssign']);

    Route::post('edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@doEditAssign']);

    Route::get('delete-asset-assignment/{id}', ['as' => 'delete-asset-assignment', 'uses' => 'AssetController@doDeleteAssign']);

    Route::get('hr-policy', ['as' => 'hr-policy', 'uses' => 'IndexController@showPolicy']);

    Route::get('download-forms', ['as' => 'download-forms', 'uses' => 'IndexController@showForms']);

    Route::get('download/{name}', 'DownloadController@downloadForms');

    Route::get('calendar', 'AuthController@calendar');

    //Routes for Leave and Holiday.

    Route::post('get-leave-count', 'LeaveController@getLeaveCount');

    Route::post('approve-leave', 'LeaveController@approveLeave');

    Route::post('disapprove-leave', 'LeaveController@disapproveLeave');

    Route::get('upload-holidays', 'LeaveController@showHolidays');
    Route::post('upload-holidays', 'LeaveController@processHolidays'); //upload via sheet


    Route::get('add-holiday', 'LeaveController@addHolidays');
    Route::post('add-holiday', 'LeaveController@addHoliday');  //manually

    Route::get('holiday-listing', 'LeaveController@showHoliday');
    Route::post('holiday-listing', 'LeaveController@searchHoliday');


    Route::get('edit-holiday/{id}', 'LeaveController@showEditHoliday');

    Route::post('edit-holiday/{id}', 'LeaveController@doEditHoliday');

    Route::get('delete-holiday/{id}', 'LeaveController@deleteHoliday');

    //Routes for Event.

    Route::get('create-event', ['as'=>'create-event','uses'=>'EventController@index']);

    Route::post('create-event', 'EventController@createEvent');

    Route::get('create-meeting', 'EventController@meeting');

    Route::post('create-meeting', 'EventController@createMeeting');

    //Routes for Award.

    Route::get('add-award', ['uses'=>'AwardController@addAward']);

    Route::post('add-award', ['uses'=>'AwardController@processAward']);

    Route::get('award-listing', ['uses'=>'AwardController@showAward']);

    Route::get('edit-award/{id}', ['uses'=>'AwardController@showAwardEdit']);

    Route::post('edit-award/{id}', ['uses'=>'AwardController@doAwardEdit']);

    Route::get('delete-award/{id}', ['uses'=>'AwardController@doAwardDelete']);

    Route::get('assign-award', ['uses'=>'AwardController@assignAward']);

    Route::post('assign-award', ['uses'=>'AwardController@processAssign']);

    Route::get('awardees-listing', ['uses'=>'AwardController@showAwardAssign']);

    Route::get('edit-award-assignment/{id}', ['uses'=>'AwardController@showAssignEdit']);

    Route::post('edit-award-assignment/{id}', ['uses'=>'AwardController@doAssignEdit']);

    Route::get('delete-award-assignment/{id}', ['uses'=>'AwardController@doAssignDelete']);

    //Routes for Prmotion.

    Route::get('promotion', ['uses'=>'EmpController@doPromotion']);

    Route::post('promotion', ['uses'=>'EmpController@processPromotion']);

    Route::get('show-promotion', ['uses'=>'EmpController@showPromotion']);

    Route::post('get-promotion-data', ['uses' => 'EmpController@getPromotionData']);

    //Routes for Training.

    Route::group(['middleware' => ['adminview']], function ()
    {

    Route::get('add-training-program', ['uses'=>'TrainingController@addTrainingProgram']);

    Route::post('add-training-program', ['uses'=>'TrainingController@processTrainingProgram']);

    Route::get('show-training-program', ['uses'=>'TrainingController@showTrainingProgram']);

    Route::get('edit-training-program/{id}', ['uses'=>'TrainingController@doEditTrainingProgram']);

    Route::post('edit-training-program/{id}', ['uses'=>'TrainingController@processEditTrainingProgram']);

    Route::get('delete-training-program/{id}',['uses'=>'TrainingController@deleteTrainingProgram']);

    Route::get('add-training-invite', ['uses'=>'TrainingController@addTrainingInvite']);

    Route::post('add-training-invite', ['uses'=>'TrainingController@processTrainingInvite']);

    Route::get('show-training-invite', ['uses'=>'TrainingController@showTrainingInvite']);

    // Route::get('edit-training-invite/{id}', ['uses'=>'TrainingController@doEditTrainingInvite']);

    // Route::post('edit-training-invite/{id}', ['uses'=>'TrainingController@processEditTrainingInvite']);

    Route::get('delete-training-invite/{id}',['uses'=>'TrainingController@deleteTrainingInvite']);

    Route::post('status-update', 'UpdateController@index');

    Route::post('post-reply', 'UpdateController@reply');

    Route::get('post/{id}', 'UpdateController@post');
    // edit
    Route::get('/search_program',['uses'=>'TrainingController@search_program'])->name('search');

    Route::post('/show-training-invite',['uses'=>'TrainingController@filter_program']);

    Route::get('/show_program_details/{id}',['uses'=>'TrainingController@showDetails']);

    });

    Route::get('/view_program',['uses'=>'TrainingController@viewProgram']);

    /** Routes for clients **/
    Route::get('add-client', 'ClientController@addClient')->name('add-client');

    Route::post('add-client', 'ClientController@saveClient');

    Route::get('list-client', 'ClientController@listClients')->name('list-client');

    Route::get('edit-client/{clientId}', 'ClientController@showEdit')->name('edit-client');

    Route::post('edit-client/{clientId}', 'ClientController@saveClientEdit');


    Route::get('delete-list/{clientId}', 'ClientController@doDelete');


    /** Routes for projects **/
    Route::get('validate-code/{code}', 'ClientController@validateCode');

    Route::get('add-project', 'ProjectController@addProject')->name('add-project');

    Route::post('add-project', 'ProjectController@saveProject');

    Route::get('edit-project/{projectId}', 'ProjectController@showEdit')->name('edit-project');

//    Route::post('edit-project/{projectId}', 'ProjectController@saveProjectEdit');

    Route::get('list-project', 'ProjectController@listProject')->name('list-project');

    Route::get('edit-project/{id}', ['as' => 'edit-project', 'uses' => 'ProjectController@showEdit']);

    Route::post('edit-project/{id}', ['as' => 'edit-project', 'uses' => 'ProjectController@doEdit']);

    Route::get('delete-project/{id}', ['as' => 'delete-project', 'uses' => 'ProjectController@doDelete']);

    Route::get('assign-project', ['as' => 'assign-project', 'uses' => 'ProjectController@doAssign']);

    Route::post('assign-project', ['as' => 'assign-project', 'uses' => 'ProjectController@processAssign']);

    Route::get('project-assignment-listing', ['as' => 'project-assignment-listing', 'uses' => 'ProjectController@showProjectAssignment']);


    Route::get('edit-project-assignment/{id}', ['as' => 'edit-project-assignment', 'uses' => 'ProjectController@showEditAssign']);

    Route::post('edit-project-assignment/{id}', ['as' => 'edit-project-assignment', 'uses' => 'ProjectController@doEditAssign']);

   
    Route::get('delete-project-assignment/{id}', ['as' => 'delete-project-assignment', 'uses' => 'ProjectController@doDeleteAssign']);
  
    Route::get('search-empcode',  ['uses' => 'EmpController@search_empcode'])->name('/search-empcode');
    Route::get('search-empemail',  ['uses' => 'EmpController@search_empemail'])->name('/search-empemail');


    Route::get('form/{key}', [ 'as' => 'form','uses' => 'ResignController@form_table']);


    //Routes for Separation.

    Route::post('form/{key}', ['uses' => 'ResignController@save_form']);

    Route::view('noaccess', 'hrms.noaccess');

    //Route::get('assign-project', 'ProjectController@assignProject')->name('assign-project');

    // Routes for Attendance

    Route::get('/attendance_login', ['uses' => 'AttendanceController@taskslogin']);

    Route::post('/attendance_login', ['uses' => 'AttendanceController@process_task_login']);


    Route::group(['middleware' => ['adminview']], function ()
    {
        Route::get('/attendance_list', ['uses' => 'AttendanceController@attendance_list']);

        Route::post('/attendance_list', 'AttendanceController@searchlist');

        Route::get('task_view/{id}', ['uses' => 'AttendanceController@task_view']);
    });


});
    Route::group(['middleware' => ['adminview']], function ()
{
    //Routes for Separation.

    Route::get('resignation', ['uses' => 'ResignController@addresign']);

    Route::post('resignation', ['uses' => 'ResignController@processresign']);

    Route::get('exit-formalities',  ['uses' => 'ResignController@formalities']);

    Route::post('exit-formalities',  ['uses' => 'MailController@send_email']);

    Route::get('exit-forms',  ['uses' => 'ResignController@show_exit_forms']);
     
    Route::get('search',  ['uses' => 'ResignController@searching'])->name('search');

    Route::get('search-employee',  ['uses' => 'ResignController@search_employee'])->name('search-employee');

    Route::get('/search1',  ['uses' => 'ResignController@design_table'])->name('search1');

    Route::get('resignation_form/{id}', ['uses' => 'ResignController@resignation_form']);

    

});




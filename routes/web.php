<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Mail\passwordSendMailable;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\DevicesController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\MonitoringDriverController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\PdfReportController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\SupportController;
use Illuminate\Support\Facades\Storage;

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
Route::get('/storage-link', function(){
    Artisan::call('storage:link');
    return  "Link storage created";
})->middleware('auth.admin');



//Inicio de sesion
Route::redirect('/','/logout' );

Route::get('/forgot-password', [ForgotPasswordController::class,'index'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class,'forgetPasswordPost'])->middleware('guest')->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get')->where("token",'[A-Za-z0-9-_]+');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::view('/login','auth.login');
Route::post('/login',[App\Http\Controllers\Auth\LoginController::class, 'postLogin'])->name('post.login');
Route::get('/logout',[App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('get.logout');

//Update User Details

Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile')->where("id", '[0-9]+');;
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword')->where("id", '[0-9]+');;

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);


//-----ROUTES ADMIN----
Route::middleware('auth.admin')->prefix('/admin')->group(function(){

//DASHBOARD
Route::get('/dashboard',[App\Http\Controllers\Admin\DashboardController::class,'index'])->name('admin.dashboard');
Route::get('/speeds/get',[App\Http\Controllers\Admin\DashboardController::class,'speeds'])->name('admin.speeds.get');

//PROFILE
Route::get('/profile',[App\Http\Controllers\HomeController::class, 'profileAdmin'])->name('admin.profile');


//USERS
Route::resource('users',UsersController::class);

//DEVICES
Route::resource('devices',DevicesController::class);
Route::post('/devices/search',[DevicesController::class,'searchDevice'])->name('admin.search.devices');
Route::get('/speeds/get/{id}',[DevicesController::class,'speedsDevice'])->name('admin.speeds.device.get');
Route::get('/devices/filter/{filter}',[DevicesController::class,'filterDevice'])->name('admin.devices.filter')->where("filter",'[A-Za-z]+');

//DEVICES:Monitoring Driver Only
Route::post('/driver/link',[DriverController::class,'LinkDriver'])->name('admin.link.driver');
Route::delete('/driver/{id}/remove',[DriverController::class,'RemoveDriver'])->name('admin.remove.driver')->where("id", '[0-9]+');;
Route::post('/driver/{id}/update',[DriverController::class,'UpdateDriver'])->name('admin.update.driver')->where("id", '[0-9]+');;

Route::get('/driver/view/{id}',[MonitoringDriverController::class,'index'])->name('admin.monitoring.driver')->where("id", '[0-9]+');;

//DOWNLOAD-SCRIPT-ARDUINO
Route::get ('/script/{id}',[MonitoringDriverController::class,'scriptArduino'])->name('admin.script.download')->where("id", '[0-9]+');;
//MAPS
Route::get('/map/analytics',[MapController::class,'index'])->name('admin.map.analytics');

//reports
Route::get('/reports',[ReportController::class, 'index'])->name('admin.reports.index');
Route::post('/filter/reports',[ReportController::class,'filterReport'])->name('admin.filter.reports');

//Report PDF
Route::get('/pdf-reports',[PdfReportController::class,'PdfReportAdmin'])->name('admin.reports.pdf');

//Support
Route::get('/support/',[SupportController::class,'index'])->name('admin.support');
Route::get('/support/tutorial/',[SupportController::class,'tutorial'])->name('admin.support.tutorial');
//Support-contact
Route::post('/support/contact/',[SupportController::class,'contact'])->name('admin.support.contact');
});

//

//-----ROUTES USER------
Route::middleware('auth.user')->prefix('/user')->group(function(){
//PROFILE
Route::get('/profile',[App\Http\Controllers\HomeController::class, 'profileUser'])->name('user.profile');

Route::get('/dashboard',[App\Http\Controllers\User\DashboardController::class,'index'])->name('user.dashboard');

//Support
Route::get('/support/',[App\Http\Controllers\User\SupportController::class,'index'])->name('user.support');
Route::get('/support/tutorial/',[App\Http\Controllers\User\SupportController::class,'tutorial'])->name('user.support.tutorial');
//Support-contact
Route::post('/support/contact/',[App\Http\Controllers\User\SupportController::class,'contact'])->name('user.support.contact');

});


Route::get('credentials',function(){
    $correo=new passwordSendMailable;
    Mail::to('doncris5511@gmail.com')->send($correo);
    return "mensaje enviado";
});

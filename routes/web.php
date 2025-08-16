<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AnalyzeMedicalReportController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MedicalReportController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\FirstAidController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\SelfHelpController;
use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;


Route::get('/', function () { return view('welcome'); })->name('welcome');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::any('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// ----------------------- Home Page Routes ------------------------ //
Route::get('/call-ambulance', function () { return view('call-ambulance'); })->name('call-ambulance');
Route::get('/locate-medical-center', function () { return view('locate-medical-center');})->name('locate-medical-center');
Route::get('/give-first-aid', [FirstAidController::class, 'index'])->name('give-first-aid');
Route::get('/first-aid/fetch', [FirstAidController::class, 'fetch'])->name('first-aid.fetch');
Route::get('/store', function () {  return view('store');})->name('store');

# Authentication and Authorization Dashboard Middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'userDashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [Dashboard::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/doctor/dashboard', [Dashboard::class, 'doctorDashboard'])->name('doctor.dashboard');
});

// ------------------- Users Dashboard routes ------------------- //
# User Profile Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::get('/profile/edit/personal', [ProfileController::class, 'editPersonal'])->name('profile.edit.personal');
    Route::post('/profile/update/personal', [ProfileController::class, 'updatePersonal'])->name('profile.update.personal');
    Route::get('/profile/edit/kin', [ProfileController::class, 'editKin'])->name('profile.edit.kin');
    Route::post('/profile/update/kin', [ProfileController::class, 'updateKin'])->name('profile.update.kin');
    Route::get('/profile/edit/medical', [ProfileController::class, 'editMedical'])->name('profile.edit.medical');
    Route::post('/profile/update/medical', [ProfileController::class, 'updateMedical'])->name('profile.update.medical');
    
    # Other Routes to be included
    Route::get('/buy-prescription/{id}', function ($id) { return view('buy-prescription.index'); })->name('buy-prescription');
    Route::get('/my-order/{id}', function ($id) { return view('buy-prescription.index');})->name('my-order');
});

// ------------------------ Doctor Routes ------------------------ //
Route::get('/self-help', [SelfHelpController::class, 'index'])->name('self-help');
Route::get('/self-help/fetch', [SelfHelpController::class, 'fetch'])->name('self-help.fetch');
// Route::get('/notification', function () { return view('doctor.dashboard'); })->name('notification');
# Doctor Profile Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showDoctor'])->name('profile');
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::post('/profile/update/availability', [ProfileController::class, 'updateAvailability'])->name('profile.update.availability');
    Route::get('/profile/edit/personal', [ProfileController::class, 'editDoctorPersonal'])->name('profile.edit.personal');
    Route::post('/profile/update/personal', [ProfileController::class, 'updateDoctorPersonal'])->name('profile.update.personal');
});


# Appointment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index')->middleware('role:user');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store')->middleware('role:user');
    Route::get('/appointment/{id}', [AppointmentController::class, 'show'])->name('appointment.show')->middleware('role:user');
    Route::get('/appointment/video-call/{id}', [AppointmentController::class, 'videoCall'])->name('appointment.video-call');
    Route::get('/appointment/review/{id}', [AppointmentController::class, 'review'])->name('appointment.review')->middleware('role:user');
    Route::post('/appointment/review/{id}', [AppointmentController::class, 'storeReview'])->name('appointment.review.store')->middleware('role:user');
    Route::post('/appointment/store-room-url', [AppointmentController::class, 'storeRoomUrl'])->name('appointment.store-room-url');

    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
        Route::get('/doctor/appointment', [ScheduleController::class, 'appointments'])->name('schedule.appointment');
        Route::get('/schedule/history', [ScheduleController::class, 'history'])->name('schedule.history');
        Route::get('/schedule/{id}', [ScheduleController::class, 'show'])->name('schedule.show');
        Route::post('/schedule/accept/{id}', [ScheduleController::class, 'accept'])->name('schedule.accept');
        Route::get('/schedule/feedback/{id}', [ScheduleController::class, 'feedback'])->name('appointment.feedback');
        Route::post('/schedule/feedback/{id}', [ScheduleController::class, 'storeFeedback'])->name('appointment.feedback.store');
        
        # Analyze Medical Report Routes
        Route::get('/analyze-medical-report', [AnalyzeMedicalReportController::class, 'index'])->name('analyze-medical-report');
        Route::get('/analyze-medical-report/{id}', [AnalyzeMedicalReportController::class, 'show'])->name('analyze-medical-report.show');
        Route::post('/analyze-medical-report/{id}/feedback', [AnalyzeMedicalReportController::class, 'storeFeedback'])->name('medical-report.feedback.store');
        Route::get('/analyzed-reports', [AnalyzeMedicalReportController::class, 'analyzedReports'])->name('analyzed-reports');
    });
    
    # Medica Report
    Route::middleware(['role:user'])->group(function () {
        Route::get('/medical-report', [MedicalReportController::class, 'index'])->name('medical-report');
        Route::post('/medical-report', [MedicalReportController::class, 'store'])->name('medical-report.store');
        Route::get('/medical-report/{id}', [MedicalReportController::class, 'show'])->name('medical-report.show');
        Route::get('/medical-history', [MedicalHistoryController::class, 'index'])->name('medical-history');
    });
    
    # Call routes
    Route::post('/call/initiate', [CallController::class, 'initiateCall'])->name('call.initiate');
    Route::post('/call/cancel', [CallController::class, 'cancelCall'])->name('call.cancel');
    Route::post('/call/{callId}/accept', [CallController::class, 'acceptCall'])->name('call.accept');
    Route::get('/call/{callId}/video', [CallController::class, 'videoCall'])->name('call.video');
    Route::get('/call-doctor', function () {  return view('call.index');})->name('call-doctor');
    
    # Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update-password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
    Route::post('/settings/verify-email', [SettingsController::class, 'verifyEmail'])->name('settings.verify-email');
    Route::post('/settings/resend-verification', [SettingsController::class, 'resendVerification'])->name('settings.resend-verification');
    Route::post('/settings/update-phone', [SettingsController::class, 'updatePhone'])->name('settings.update-phone');
    Route::delete('/settings/delete-account', [SettingsController::class, 'deleteAccount'])->name('settings.delete-account');
});


   
# Wallet Routes
Route::get('/doctor/my-wallet', function () { return view('doctor.my-wallet');})->name('doctor.my-wallet');
Route::get('/doctor/fund-wallet', function () { return view('doctor.fund-wallet');})->name('doctor.fund-wallet');
Route::post('/doctor/process-payment', function() {
    return redirect()->back(); // Placeholder for payment processing
})->name('doctor.process-payment');

// ------------ Admin dashboard routes ------------------ //
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('store-doctor');
    Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('edit-doctor');
    Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('update-doctor');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('destroy-doctor');

    //Manage Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('edit-user');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy-user');
});

#App Settings
Route::get('/admin/app-settings', function () {    return view('admin.app-settings'); })->name('admin.app-settings');
Route::put('/admin/update-settings', function (Request $request) {
    // Validate and update settings here
    return redirect()->route('admin.app-settings')->with('success', 'Settings updated successfully');
})->name('admin.update-settings');
# Analytics and Logs
Route::get('/admin/analytics', function () { return view('admin.analytics'); })->name('admin.analytics');
Route::get('/admin/logs', function () { return view('admin.logs'); })->name('admin.logs');
Route::get('/admin/support-center', function () { return view('admin.support-center'); })->name('admin.support-center');
Route::get('/admin/view-ticket/{id}', function ($id) {
    // Fetch ticket data here in a real app
    return view('admin.view-ticket', ['ticket' => (object) ['id' => $id]]);
})->name('admin.view-ticket');

Route::get('/support-center', function () { return view('admin.dashboard');})->name('support-center');

require __DIR__.'/auth.php';

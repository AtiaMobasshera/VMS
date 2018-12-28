<?php

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

// Pages
Route::get('/', 'PagesController@home')->name('home');

// Auth
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('postLogin');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('postRegister');

// Dashboard
Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');

// VisitReasons
Route::resource('visitreasons', 'VisitReasonsController', ['only' => ['index', 'create', 'store', 'update', 'destroy']]);

// Designations
Route::resource('designations', 'DesignationsController', ['only' => ['index', 'create', 'store', 'update', 'destroy']]);

// Hosts
Route::resource('hosts', 'HostsController', ['only' => ['index', 'create', 'store', 'destroy']]);

// Visitors
Route::resource('visitors', 'VisitorsController', ['only' => ['index', 'destroy']]);

// Visits
Route::get('visits/approved', 'VisitsController@approved')->name('visits.approved');
Route::get('visits/pending', 'VisitsController@pending')->name('visits.pending');
Route::get('visits/rejected', 'VisitsController@rejected')->name('visits.rejected');
Route::resource('visits', 'VisitsController');

// Profiles
Route::resource('profiles', 'ProfilesController');

// Appointments
Route::get('appointments/specific/{id}', 'AppointmentsController@specific')->name('appointments.specific');
Route::get('appointments/approved', 'AppointmentsController@approved')->name('appointments.approved');
Route::get('appointments/pending', 'AppointmentsController@pending')->name('appointments.pending');
Route::get('appointments/rejected', 'AppointmentsController@rejected')->name('appointments.rejected');
Route::resource('appointments', 'AppointmentsController');

// Manage Visits
Route::get('managevisits/approved', 'ManageVisitsController@approved')->name('managevisits.approved');
Route::get('managevisits/pending', 'ManageVisitsController@pending')->name('managevisits.pending');
Route::get('managevisits/rejected', 'ManageVisitsController@rejected')->name('managevisits.rejected');
Route::resource('managevisits', 'ManageVisitsController');

// Visit Access Codes
Route::get('visits/approved/download/{id}', 'VisitAccessCodesController@download')->name('visitDownload');

// Manage Appointments
Route::get('manageappointments/approved', 'ManageAppointmentsController@approved')->name('manageappointments.approved');
Route::get('manageappointments/pending', 'ManageAppointmentsController@pending')->name('manageappointments.pending');
Route::get('manageappointments/rejected', 'ManageAppointmentsController@rejected')->name('manageappointments.rejected');
Route::resource('manageappointments', 'ManageAppointmentsController');

// Appointment Access Codes
Route::get('appointments/approved/download/{id}', 'AppointmentAccessCodesController@download')->name('appointmentDownload');

// Mail
Route::post('mail/{id}', 'MailController@send')->name('mail.send');

// Visit Reports
Route::get('checkvisits', 'VisitReportsController@index')->name('checkVisits.index');
Route::post('checkvisits', 'VisitReportsController@check')->name('checkVisits.check');
Route::post('checkvisits/proceed', 'VisitReportsController@proceed')->name('checkVisits.proceed');
Route::post('checkvisits/terminate', 'VisitReportsController@terminate')->name('checkVisits.terminate');

// Appointment Reports
Route::get('checkappointments', 'AppointmentReportsController@index')->name('checkAppointments.index');
Route::post('checkappointments', 'AppointmentReportsController@check')->name('checkAppointments.check');
Route::post('checkappointments/proceed', 'AppointmentReportsController@proceed')->name('checkAppointments.proceed');
Route::post('checkappointments/terminate', 'AppointmentReportsController@terminate')->name('checkAppointments.terminate');

// AR Visit Reports
Route::get('visitreports', 'ARVisitReportsController@index')->name('visitReports.index');
Route::get('visitreports/{id}', 'ARVisitReportsController@show')->name('visitReports.show');
Route::get('visitstoday', 'ARVisitReportsController@today')->name('visitReports.today');

// AR Appointment Reports
Route::get('appointmentreports', 'ARAppointmentReportsController@index')->name('appointmentReports.index');
Route::get('appointmentreports/{id}', 'ARAppointmentReportsController@show')->name('appointmentReports.show');
Route::get('appointmentstoday', 'ARAppointmentReportsController@today')->name('appointmentReports.today');

// Inbox
Route::get('inbox', 'InboxesController@index')->name('inbox.index');
Route::post('inbox/{id}', 'InboxesController@store')->name('inbox.store');

// Immediate Visits
Route::resource('immediatevisits', 'ImmediateVisitsController', ['only' => ['index', 'create', 'store', 'destroy']]);

// Immediate Appointments
Route::resource('immediateappointments', 'ImmediateAppointmentsController', ['only' => ['index', 'create', 'store', 'show', 'destroy']]);
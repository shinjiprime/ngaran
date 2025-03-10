<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProvincialController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\HealthFacilityController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\DiseaseGroupController;
use App\Http\Controllers\RHUController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginpage', [LoginController::class, 'loadLogin'])->name('loginpage');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//these routes need authemtication and user_type = 1
// Route::middleware(['auth', 'checkUserType:1'])->group(function () {
Route::get('/admin', [PageController::class, 'loadHome']);

Route::get('/diseases', [DiseaseController::class, 'index'])->name('diseases.index');

Route::post('/diseases/create', [DiseaseController::class, 'store'])->name('diseases.create');

Route::post('/diseases/update/{disease_code}', [DiseaseController::class, 'update'])->name('disease.update');

Route::post('/diseases/delete/{disease_code}', [DiseaseController::class, 'destroy'])->name('disease.delete');

Route::get('/disease-groups', [DiseaseGroupController::class, 'index'])->name('disease_groups.index');

Route::post('/disease-groups/create', [DiseaseGroupController::class, 'store'])->name('disease_groups.create');

Route::post('/disease-groups/update/{id}', [DiseaseGroupController::class, 'update'])->name('disease_groups.update');

Route::post('/disease-groups/delete/{id}', [DiseaseGroupController::class, 'destroy'])->name('disease_groups.delete');

Route::get('/municipalities', [MunicipalityController::class, 'index'])->name('municipalities.index');
Route::post('/municipalities/create', [MunicipalityController::class, 'store'])->name('municipalities.create');
Route::post('/municipalities/update/{id}', [MunicipalityController::class, 'update'])->name('municipalities.update');
Route::post('/municipalities/delete/{id}', [MunicipalityController::class, 'destroy'])->name('municipalities.delete');
Route::get('/barangays', [BarangayController::class, 'index'])->name('barangays.index');

    Route::post('/barangays/create', [BarangayController::class, 'store'])->name('barangays.create');

    Route::post('/barangays/update/{id}', [BarangayController::class, 'update'])->name('barangays.update');

    Route::post('/barangays/delete/{id}', [BarangayController::class, 'destroy'])->name('barangays.delete');

Route::prefix('health-facilities')->name('health-facilities.')->group(function () {
    Route::get('/', [HealthFacilityController::class, 'index'])->name('index');
    Route::post('/create', [HealthFacilityController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [HealthFacilityController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [HealthFacilityController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [HealthFacilityController::class, 'destroy'])->name('delete');

    
});
Route::get('/get-municipality-coordinates/{id}', [HealthFacilityController::class, 'getMunicipalityCoordinates']);
Route::get('/get-barangays/{municipality_id}', [HealthFacilityController::class, 'getBarangays']);
Route::get('/get-rhus/{municipality_id}', [HealthFacilityController::class, 'getRhus'])->name('get.rhus');
Route::get('/fetch-facs', [HealthFacilityController::class, 'getfacs'])->name('fetch.facs');

Route::prefix('rhus')->name('rhus.')->group(function () {
    Route::get('/', [RHUController::class, 'index'])->name('index'); // Display RHUs
    Route::post('/create', [RHUController::class, 'create'])->name('create'); // Create RHU
    Route::post('/update/{id}', [RHUController::class, 'update'])->name('update'); // Update RHU
    Route::get('/delete/{id}', [RHUController::class, 'destroy'])->name('delete'); // Delete RHU
});
Route::post('/update-location', [HealthFacilityController::class, 'updateLocation'])->name('healthfacility.updateLocation');
Route::get('/fetch-rhus', [RHUController::class, 'fetchRhus'])->name('fetch-rhus');
Route::post('/update-coords', [HealthFacilityController::class, 'updateLocation2'])->name('healthfacility.updateCoords');

Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name('index'); // Display Staff
    Route::post('/create', [StaffController::class, 'create'])->name('create'); // Create Staff
    Route::post('/update/{id}', [StaffController::class, 'update'])->name('update'); // Update Staff
    Route::get('/delete/{id}', [StaffController::class, 'destroy'])->name('delete'); // Delete Staff
    Route::post('/change-password/{id}', [StaffController::class, 'changePassword'])->name('changePassword');

});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index'); // Display Users
    Route::post('/create', [UserController::class, 'create'])->name('create'); // Create User
    Route::post('/update/{id}', [UserController::class, 'update'])->name('update'); // Update User
    Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('delete'); // Delete User
});

Route::prefix('patients')->name('patients.')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('index'); // Display Patients
    Route::post('/create', [PatientController::class, 'create'])->name('create'); // Create Patient
    Route::post('/update/{id}', [PatientController::class, 'update'])->name('update'); // Update Patient
    Route::get('/delete/{id}', [PatientController::class, 'destroy'])->name('delete'); // Delete Patient
});

// });


//these routes need authemtication and user_type = 2

Route::get('/phohome', [ProvincialController::class, 'loadHome']);
Route::get('/phomorbidity', [ProvincialController::class, 'morbidity'])->name('phopatient.now');

Route::get('/phomortality', [ProvincialController::class, 'mortality'])->name('phodeaths.now');
Route::get('/get-morbidity-mortality-data', [PatientController::class, 'getMorbidityMortalityData']);
Route::get('/get-mortality-data', [PatientController::class, 'getMortalityData']);

Route::get('/submissions', [ProvincialController::class, 'showSubmissions'])->name('submissions.show');
Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('sendNotification');
Route::get('/get-morbidity-map-data', [ProvincialController::class, 'getMorbidityMapData']);
Route::get('/get-mortality-map-data', [ProvincialController::class, 'getMortalityMapData']);
Route::get('/generate-disease-report', [ProvincialController::class, 'generateReport1'])->name('generate.disease.report');
Route::get('/generate-disease2-report', [ProvincialController::class, 'generateReport2'])->name('generate.disease2.report');
Route::get('/generate-disease3-report', [ProvincialController::class, 'generateReport3'])->name('generate.disease3.report');
Route::get('/generate-disease4-report', [ProvincialController::class, 'generateReport4'])->name('generate.disease4.report');

//these routes need authemtication and user_type = 3

Route::get('/rhuhome', [MunicipalityController::class, 'loadHome']);
Route::get('/rhumorbidity', [MunicipalityController::class, 'morbidity'])->name('rhurecord.now');
Route::get('/rhumortality', [MunicipalityController::class, 'mortality'])->name('rhudeath.now');
Route::get('/rhurequests', [MunicipalityController::class, 'pending']);

Route::get('/rhupatients', [MunicipalityController::class, 'morbidityall']);
Route::get('/rhupatientsnow', [MunicipalityController::class, 'morbiditynow'])->name('rhupatient.now');
Route::post('/patient/deceased/{id}', [MunicipalityController::class, 'markAsDeceased'])->name('patient.deceased');
Route::get('/rhuuser', [MunicipalityController::class, 'showHfUser'])->name('rhuuser');
Route::get('/submissionsrhu', [MunicipalityController::class, 'showSubmissions'])->name('submissions.show2');
Route::post('/send-notification2', [NotificationController::class, 'sendNotification2'])->name('sendNotification2');
Route::get('/get-morbidity-map-data2', [MunicipalityController::class, 'getMorbidityMapData']);
Route::get('/get-mortality-map-data2', [MunicipalityController::class, 'getMortalityMapData']);
Route::get('/generate-disease-report2', [MunicipalityController::class, 'generateReport1'])->name('generate.disease.report2');
Route::get('/generate-disease2-report2', [MunicipalityController::class, 'generateReport2'])->name('generate.disease2.report2');
Route::get('/generate-disease3-report2', [MunicipalityController::class, 'generateReport3'])->name('generate.disease3.report2');
Route::get('/generate-disease4-report2', [MunicipalityController::class, 'generateReport4'])->name('generate.disease4.report2');

//these routes need authemtication and user_type = 4
Route::get('/hfhome', [HealthFacilityController::class, 'loadHome']);

Route::get('/hfpatients', [PatientController::class, 'index2']);

Route::get('/hfrecords', [PatientController::class, 'morbidity']);
Route::get('/hfrecordsnow', [PatientController::class, 'morbiditynow'])->name('hfpatient.now');
Route::get('/hfrequests', [PatientController::class, 'requests']);
Route::get('/hfmortality', [PatientController::class, 'mortality']);
Route::get('/hfmortalitynow', [PatientController::class, 'mortalitynow']);
Route::get('/hfuser', [HealthFacilityController::class, 'showHfUser'])->name('hfuser');

//these routes need authemtication
Route::post('/export-disease-data', [DiseaseController::class, 'exportToExcel'])->name('export.disease.data');
Route::post('/export-diseasemt-data', [DiseaseController::class, 'exportToExcel2'])->name('export.diseasemt.data');

Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/delete-read', [NotificationController::class, 'deleteReadNotifications'])->name('notifications.deleteRead');
Route::get('/notifications/refresh', [NotificationController::class, 'refreshNotifications'])->name('notifications.refresh');
Route::post('/submit-record', [NotificationController::class, 'store']);
Route::get('/profile', [ProfileController::class, 'fetchProfile'])->name('profile.fetch');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
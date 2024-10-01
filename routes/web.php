<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UangKasController;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignPaymentController;

Route::get('/', function () {
    return view('index.index');
})->name('home');

Route::middleware(['authenticated'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['notauthenticated', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.index');
    Route::get('/settings', [AdminController::class, 'administrator'])->name('administrator');
    Route::post('/administrator/store', [AdminController::class, 'administrator_store'])->name('administrator.store');
    Route::post('/administrator/edit/{id}', [AdminController::class, 'administrator_edit'])->name('administrator.edit');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');

    Route::post('/profile/updateprofile/{id}', [AdminController::class, 'updateprofile'])
        ->name('admin.updateprofile')
        ->middleware('blockgetonpost');;
    Route::post('/profile/updatepassword/{id}', [AdminController::class, 'updatepassword'])
        ->name('admin.updatepassword')
        ->middleware('blockgetonpost');;


    Route::resource('alumni', AlumniController::class);
    Route::get('/alumni/editalumni/{slug}', [AlumniController::class, 'edit'])->name('alumni.editalumni');

    Route::resource('angkatan', AngkatanController::class);

    Route::resource('status', StatusController::class);
    
    
    Route::resource('/campaign', CampaignController::class);
    Route::get('/campaign/editcampaign/{slug}', [CampaignController::class, 'edit'])->name('campaign.editcampaign');
    Route::post('/update-publish-status-campaign/{id}', [CampaignController::class, 'updatePublishStatus']);
    Route::get('/pembukuan', [CampaignController::class, 'show'])->name('campaign.data');
    Route::get('/campaign/detaildatacampaign/{campaign_id}', [CampaignController::class, 'detaildatacampaign'])->name('campaign.detaildatacampaign');
    
    Route::resource('uangkas', UangKasController::class);
    Route::get('/dashboard/uangkas', [UangKasController::class, 'dashboard'])->name('dashboard.uangkas');
    Route::get('/uangkas/detail/{angkatan_id}', [UangKasController::class, 'detail'])->name('detail.uangkas');
    Route::get('/pengeluaran', [UangKasController::class, 'pengeluaran'])->name('pengeluaran.uangkas');
    Route::post('/pengeluaran/tambah', [UangKasController::class, 'tambahpengeluaran'])->name('pengeluaran.tambah');
    Route::post('/pengeluaran/edit/{id}', [UangKasController::class, 'editpengeluaran'])->name('pengeluaran.edit');
    Route::post('/pengeluaran/hapus/{id}', [UangKasController::class, 'hapuspengeluaran'])->name('pengeluaran.hapus');

});

Route::get('/daftarcampaign', [CampaignPaymentController::class, 'daftarcampaign'])->name('campaignpayment.daftarcampaign');
Route::get('/donasi/show/{slug}', [CampaignPaymentController::class, 'show'])->name('campaignpayment.show');

Route::get('/pembayaran/uangkas', [UangKasController::class, 'pembayaranuangkas'])->name('pembayaran.uangkas');
Route::get('/pembayaran/uangkas/angkatan/{angkatan_id}', [UangKasController::class, 'detailuangkas'])->name('pembayaran.uangkas.angkatan');

Route::get('/donasi/detail/{slug}', [CampaignPaymentController::class, 'detail'])->name('campaignpayment.detail');
Route::post('donasi', [CampaignPaymentController::class, 'donasi'])->name('campaignpayment.donasi');

Route::get('/donasi/payment/{donasi_id}', [CampaignPaymentController::class, 'payment'])->name('donasi.payment');
Route::get('/payment/success/{donasi_id}', [CampaignPaymentController::class, 'payment_success'])->name('payment.success');
Route::get('/payment/pending/{donasi_id}', [CampaignPaymentController::class, 'payment_pending'])->name('payment.pending');
Route::get('/payment/error/{donasi_id}', [CampaignPaymentController::class, 'payment_error'])->name('payment.error');



// Route::get('/payment/{uangkas}', [UangKasController::class, 'payment'])->name('payment');
// Route::post('/payment/update-status', [UangKasController::class, 'updatePaymentStatus'])->name('payment.update-status');



Route::get('/get-alumni-names', [AdminController::class, 'getNames']);
Route::get('/get-alumni-details/{id}', [AdminController::class, 'getDetails']);
Route::get('/get-alumni-data', [AdminController::class, 'getAlumniData']);
Route::get('/alumni-statistics', [AdminController::class, 'getAlumniStatistics']);




<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\MenuController;
use App\Http\Controllers\Vendor\VendorTransaksiController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\Admin\WeekEmpat;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\BarcodeScannerController;
use App\Http\Controllers\Vendor\VendorScannerController;
use App\Http\Controllers\Admin\TokoController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\Vendor\KunjunganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AbsensiController;

// SSE Antrian
Route::get('/sse/antrian', [AntrianController::class, 'stream'])->name('antrian.stream');

// Customer Antrian
Route::get('/antrian', [AntrianController::class, 'customer'])->name('antrian.customer');
Route::get('/papan-antrian', [AntrianController::class, 'papan'])->name('antrian.papan');
Route::post('/antrian/store', [AntrianController::class, 'store'])->name('antrian.store');



// halaman awal website
Route::get('/', function () {
    return redirect('/home');
});

// halaman home bisa diakses tanpa login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// auth bawaan laravel (login, register, logout, dll)
Auth::routes();


// Guest Routes (bisa diakses tanpa login) , bisa login untuk customer (agar bisa melihat riwayat order) 
Route::get('/order',[OrderController::class,'index']);
Route::get('/get-menu/{idvendor}',[OrderController::class,'getMenu']);
Route::post('/checkout',[OrderController::class,'checkout']);
Route::get('/payment/{id}', [OrderController::class,'payment']);
Route::get('/order/success/{id}', [OrderController::class,'success']);

Route::middleware(['auth'])->group(function(){

    Route::get('/order/history',
        [App\Http\Controllers\Guest\OrderController::class,'history']
    )->name('order.history');

});

// midtrans callback untuk menerima notifikasi pembayaran dari midtrans
Route::post('/midtrans/callback',[OrderController::class,'callback']);


// Google OAuth Routes
Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


// Route untuk testing halaman reset password, bisa diakses tanpa login
Route::get('/reset-test', function () {
    $user = User::first();

    return view('auth.passwords.reset', [
        'token' => Str::random(60),
        'email' => $user->email
    ]);
})->name('reset.test');


// Route yang login dan verifikasi OTP, untuk admin dan vendor
Route::middleware(['auth'])->group(function () {

   // Halaman form OTP
    Route::get('/otp', function () {
        return view('auth.otp');
    })->name('otp.form');

    Route::post('/otp-verifikasi', [OtpController::class, 'verify'])->name('otp.verify');

   //Admin Routes
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // KATEGORI
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::get('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');

        // BUKU
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
        Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::get('/buku/delete/{id}', [BukuController::class, 'delete'])->name('buku.delete');

        // BARANG
        Route::resource('barang', BarangController::class);
        Route::post('/barang/cetak', [BarangController::class,'cetak'])->name('barang.cetak');
        Route::get('/admin/barang/cetak', [PdfController::class, 'cetakTag']);

        // Studi Kasus
        Route::get('/studi-kasus2-table', function () {
            return view('admin.barang.studi-kasus2-table');
        });

        Route::get('/studi-kasus4', function () {
            return view('admin.barang.studi-kasus4');
        })->name('studi.kasus4');

        // Customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');

        Route::get('/customer/create-blob', [CustomerController::class, 'createBlob'])
            ->name('customer.createBlob');

        Route::post('/customer/store-blob', [CustomerController::class, 'storeBlob'])
            ->name('customer.storeBlob');

        Route::get('/customer/create-file', [CustomerController::class, 'createFile'])
            ->name('customer.createFile');

        Route::post('/customer/store-file', [CustomerController::class, 'storeFile'])
            ->name('customer.storeFile');

        // AJAX
        Route::get('/week4', [WeekEmpat::class, 'index'])->name('week4.index');
        Route::post('/week4/ajax_submit', [WeekEmpat::class, 'submit'])->name('week4.ajax_submit');

        Route::get('/wilayah', [WeekEmpat::class, 'wilayah'])->name('wilayah');
        Route::get('/wilayah-axios', [WeekEmpat::class, 'wilayahAxios'])->name('wilayah.axios');

        Route::post('/get-cities', [WeekEmpat::class, 'getCities'])->name('get.cities');
        Route::post('/get-districts', [WeekEmpat::class, 'getDistricts'])->name('get.districts');
        Route::post('/get-villages', [WeekEmpat::class, 'getVillages'])->name('get.villages');

        Route::get('/pos', [WeekEmpat::class, 'pos'])->name('pos');
        Route::get('/pos-axios', [WeekEmpat::class, 'posAxios'])->name('pos.axios');

        Route::post('/find-barang', [WeekEmpat::class, 'findBarang'])->name('find.barang');
        Route::post('/search-barang', [WeekEmpat::class,'searchBarang'])->name('search.barang');
        Route::post('/bayar', [WeekEmpat::class, 'bayar'])->name('bayar');

        // PDF Dinamis
        Route::get('/form-sertifikat', [PdfController::class, 'formSertifikat'])->name('form-sertifikat');
        Route::post('/generate-sertifikat', [PdfController::class, 'generateSertifikat'])->name('generate-sertifikat');

        Route::get('/form-undangan', [PdfController::class, 'formUndangan'])->name('form-undangan');
        Route::post('/generate-undangan', [PdfController::class, 'generateUndangan'])->name('generate-undangan');

        // PDF Statis
        Route::get('/sertifikat-statis', [PdfController::class, 'sertifikatStatis'])->name('sertifikat-statis');
        Route::get('/undangan-statis', [PdfController::class, 'undanganStatis'])->name('undangan-statis');

        // Scanner Barcode
        Route::get('/scanner-barcode', [BarcodeScannerController::class, 'index'])->name('scanner.barcode');
        Route::post('/scanner-barcode/get', [BarcodeScannerController::class, 'getBarang'])->name('scanner.barcode.get');

        // Geolocation Toko
        Route::get('/toko', [TokoController::class, 'index'])->name('admin.toko.index');
        Route::get('/toko/create', [TokoController::class, 'create'])->name('admin.toko.create');
        Route::post('/toko/store', [TokoController::class, 'store'])->name('admin.toko.store');
        Route::get('/toko/edit/{id}', [TokoController::class, 'edit'])->name('admin.toko.edit');
        Route::post('/toko/update/{id}', [TokoController::class, 'update'])->name('admin.toko.update');
        Route::get('/toko/delete/{id}', [TokoController::class, 'destroy'])->name('admin.toko.delete');

        // Antrian Management
        Route::get('/admin/antrian', [AntrianController::class, 'admin'])->name('antrian.admin');
        Route::get('/admin/antrian/history', [AntrianController::class, 'historyList'])->name('antrian.history');
        Route::post('/admin/antrian/panggil/{id}', [AntrianController::class, 'panggil'])->name('antrian.panggil');
        Route::post('/admin/antrian/recall/{id}', [AntrianController::class, 'recall'])->name('antrian.recall');
        Route::post('/admin/antrian/selesai/{id}', [AntrianController::class, 'selesai'])->name('antrian.selesai');
        Route::post('/admin/antrian/terlambat/{id}', [AntrianController::class, 'terlambat'])->name('antrian.terlambat');

        // NFC Attendance System
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::get('/absensi-nfc', [AbsensiController::class, 'index'])->name('absensi.nfc');
        Route::post('/absensi-nfc/store', [AbsensiController::class, 'store'])->name('absensi.store');

    });


    // Vendor Routes
    Route::middleware(['auth','role:vendor'])->group(function(){

        Route::get('/vendor/dashboard',[VendorDashboardController::class,'index'])->name('vendor.dashboard');
        Route::resource('/menu', MenuController::class);
        Route::get('/vendor/transaksi',[VendorTransaksiController::class,'index'])->name('vendor.transaksi');
        Route::get('/vendor/transaksi/{id}',[VendorTransaksiController::class,'detail'])->name('vendor.transaksi.detail');

        // Scanner QR Customer (Praktikum 2)
        Route::get('/vendor/scanner-qr', [VendorScannerController::class,'index'])->name('vendor.scanner.qr');
        Route::post('/vendor/scanner-qr/get', [VendorScannerController::class,'getPesanan'])->name('vendor.scanner.qr.get');

        // Kunjungan Geolocation
        Route::get('/vendor/kunjungan', [KunjunganController::class, 'index'])->name('vendor.kunjungan.index');
        Route::post('/vendor/kunjungan/store', [KunjunganController::class, 'store'])->name('vendor.kunjungan.store');

    });

});
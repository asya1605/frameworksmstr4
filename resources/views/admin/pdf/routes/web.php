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





/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// halaman awal website
Route::get('/', function () {
    return redirect('/home');
});

// halaman home bisa diakses tanpa login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// auth bawaan laravel (login, register, logout, dll)
Auth::routes();


/*
|--------------------------------------------------------------------------
| ORDER SYSTEM (Guest & Customer)
|--------------------------------------------------------------------------
*/
Route::get('/order',[OrderController::class,'index']);
Route::get('/get-menu/{idvendor}',[OrderController::class,'getMenu']);
Route::post('/checkout',[OrderController::class,'checkout']);
Route::get('/payment/{id}', [OrderController::class,'payment']);


/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK (WAJIB DI LUAR AUTH)
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/callback',[OrderController::class,'callback']);


/*
|--------------------------------------------------------------------------
| GOOGLE LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| RESET TEST
|--------------------------------------------------------------------------
*/

Route::get('/reset-test', function () {
    $user = User::first();

    return view('auth.passwords.reset', [
        'token' => Str::random(60),
        'email' => $user->email
    ]);
})->name('reset.test');


/*
|--------------------------------------------------------------------------
| ROUTES YANG PERLU LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | OTP
    |--------------------------------------------------------------------------
    */

    Route::get('/otp', function () {
        return view('auth.otp');
    })->name('otp.form');

    Route::post('/otp-verifikasi', [OtpController::class, 'verify'])->name('otp.verify');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::get('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');


        /*
        |--------------------------------------------------------------------------
        | BUKU
        |--------------------------------------------------------------------------
        */

        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
        Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::get('/buku/delete/{id}', [BukuController::class, 'delete'])->name('buku.delete');


        /*
        |--------------------------------------------------------------------------
        | BARANG
        |--------------------------------------------------------------------------
        */

        Route::resource('barang', BarangController::class);
        Route::post('/barang/cetak', [BarangController::class,'cetak'])->name('barang.cetak');

        /*
        |--------------------------------------------------------------------------
        | STUDI KASUS
        |--------------------------------------------------------------------------
        */

        Route::get('/studi-kasus2-table', function () {
            return view('barang.studi-kasus2-table');
        });

        Route::get('/studi-kasus4', function () {
            return view('barang.studi-kasus4');
        })->name('studi.kasus4');


        /*
        |--------------------------------------------------------------------------
        | AJAX WEEK 4
        |--------------------------------------------------------------------------
        */

        Route::get('/week4', [WeekEmpat::class, 'index'])->name('week4.index');
        Route::post('/week4/ajax_submit', [WeekEmpat::class, 'submit'])->name('week4.ajax_submit');

        Route::get('/wilayah', [WeekEmpat::class, 'wilayah'])->name('wilayah');

        Route::post('/get-cities', [WeekEmpat::class, 'getCities'])->name('get.cities');
        Route::post('/get-districts', [WeekEmpat::class, 'getDistricts'])->name('get.districts');
        Route::post('/get-villages', [WeekEmpat::class, 'getVillages'])->name('get.villages');

        Route::get('/pos', [WeekEmpat::class, 'pos'])->name('pos');

        Route::post('/find-barang', [WeekEmpat::class, 'findBarang'])->name('find.barang');
        Route::post('/search-barang', [WeekEmpat::class,'searchBarang'])->name('search.barang');
        Route::post('/bayar', [WeekEmpat::class, 'bayar'])->name('bayar');


        /*
        |--------------------------------------------------------------------------
        | PDF DINAMIS
        |--------------------------------------------------------------------------
        */

        Route::get('/form-sertifikat', [PdfController::class, 'formSertifikat'])->name('form-sertifikat');
        Route::post('/generate-sertifikat', [PdfController::class, 'generateSertifikat'])->name('generate-sertifikat');

        Route::get('/form-undangan', [PdfController::class, 'formUndangan'])->name('form-undangan');
        Route::post('/generate-undangan', [PdfController::class, 'generateUndangan'])->name('generate-undangan');


        /*
        |--------------------------------------------------------------------------
        | PDF STATIS
        |--------------------------------------------------------------------------
        */

        Route::get('/sertifikat-statis', [PdfController::class, 'sertifikatStatis'])->name('sertifikat-statis');
        Route::get('/undangan-statis', [PdfController::class, 'undanganStatis'])->name('undangan-statis');

    });


    /*
    |--------------------------------------------------------------------------
    | POS SYSTEM
    |--------------------------------------------------------------------------
    */

Route::middleware(['auth','role:vendor'])->group(function(){

    Route::get('/vendor/dashboard',[VendorDashboardController::class,'index'])->name('vendor.dashboard');
    Route::resource('/menu', MenuController::class);
    Route::get('/vendor/transaksi',[VendorTransaksiController::class,'index'])->name('vendor.transaksi');
    Route::get('/vendor/transaksi/{id}',[VendorTransaksiController::class,'detail'])->name('vendor.transaksi.detail');

});

});
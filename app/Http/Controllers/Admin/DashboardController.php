<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Controllers\Controller;
class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();

        return view('admin.dashboard', compact('totalBuku','totalKategori'));
    }
}

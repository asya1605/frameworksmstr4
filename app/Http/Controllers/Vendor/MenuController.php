<?php

namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        //Ambil data vendor berdasarkan user login
        $vendor = DB::table('vendor')
            ->where('iduser', Auth::id())
            ->first();

        //Ambil data menu berdasarkan vendor yang login
        $menu = DB::table('menu')
            ->join('vendor','menu.idvendor','=','vendor.idvendor')
            ->where('menu.idvendor', $vendor->idvendor)
            ->select('menu.*','vendor.nama_vendor')
            ->get();

        return view('vendor.menu.index', compact('menu'));
    }

    public function create()
    {
        return view('vendor.menu.create');
    }

    public function destroy($id)
    {
        DB::table('menu')->where('idmenu',$id)->delete();

        return redirect()->route('menu.index');
        //Vendor hanya bisa menghapus menu miliknya sendiri.
    }


        public function store(Request $request)
    {
        $vendor = DB::table('vendor')
            ->where('iduser', Auth::id())
            ->first();

        DB::table('menu')->insert([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'idvendor' => $vendor->idvendor
        ]);

        return redirect()->route('menu.index')
            ->with('success','Menu berhasil ditambahkan');
        }
        //id vendor diambil dari user login agar data terhubung dengan vendor yang benar.
}
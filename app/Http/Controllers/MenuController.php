<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menu = DB::table('menu')
            ->join('vendor','menu.idvendor','=','vendor.idvendor')
            ->select('menu.*','vendor.nama_vendor')
            ->get();

        return view('menu.index', compact('menu'));
    }

    public function create()
    {
        $vendor = DB::table('vendor')->get();
        return view('menu.create', compact('vendor'));
    }

    public function store(Request $request)
    {
        DB::table('menu')->insert([
            'nama_menu'=>$request->nama_menu,
            'harga'=>$request->harga,
            'idvendor'=>$request->idvendor
        ]);

        return redirect()->route('menu.index');
    }

    public function destroy($id)
    {
        DB::table('menu')->where('idmenu',$id)->delete();

        return redirect()->route('menu.index');
    }
}
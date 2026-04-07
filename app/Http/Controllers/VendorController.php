<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index()
    {
        $vendor = DB::table('vendor')->get();
        return view('vendor.index', compact('vendor'));
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function store(Request $request)
    {
        DB::table('vendor')->insert([
            'nama_vendor' => $request->nama_vendor
        ]);

        return redirect()->route('vendor.index');
    }

    public function edit($id)
    {
        $vendor = DB::table('vendor')->where('idvendor',$id)->first();
        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        DB::table('vendor')
            ->where('idvendor',$id)
            ->update([
                'nama_vendor'=>$request->nama_vendor
            ]);

        return redirect()->route('vendor.index');
    }

    public function destroy($id)
    {
        DB::table('vendor')->where('idvendor',$id)->delete();
        return redirect()->route('vendor.index');
    }
}
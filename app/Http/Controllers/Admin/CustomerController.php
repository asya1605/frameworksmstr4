<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function index()
    {
        $customer = DB::table('customer')->get();

        return view('admin.customer.index', compact('customer'));
    }


    public function createBlob()
    {
        // Ambil data provinsi untuk dropdown
        $provinces = DB::table('provinces')->get();

        return view('admin.customer.create_blob', compact('provinces'));
    }


    public function storeBlob(Request $request)
    {
        //Ambil data gambar dari request (base64 string) lalu diolah menjadi binary untuk disimpan di database
        $image = $request->foto;

        //Hapus header base64 jika ada, lalu decode menjadi binary
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = base64_decode($image);

        DB::table('customer')->insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto_blob' => $image
        ]);

        return redirect()->route('customer.index');
    }



    public function createFile()
    {
        $provinces = DB::table('provinces')->get();

        return view('admin.customer.create_file', compact('provinces'));
    }


    public function storeFile(Request $request)
    {

        $image = $request->foto;

        $image = str_replace('data:image/png;base64,', '', $image);
        $image = base64_decode($image);

        $filename = time().'.png';

        Storage::disk('public')->put('customer/'.$filename,$image);

        DB::table('customer')->insert([
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'provinsi'=>$request->provinsi,
            'kota'=>$request->kota,
            'kecamatan'=>$request->kecamatan,
            'kodepos'=>$request->kodepos,
            'foto_path'=>'storage/customer/'.$filename
        ]);

        return redirect()->route('customer.index');
        // Gambar disimpan di storage server dan hanya path-nya yang disimpan di database
    }

}
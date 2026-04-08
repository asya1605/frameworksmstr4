<?php

namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $vendor = DB::table('vendor')->get();
        return view('guest.order.index', compact('vendor'));
    }

    public function getMenu($idvendor)
    {
        $menu = DB::table('menu')
            ->where('idvendor',$idvendor)
            ->get();

        return response()->json($menu);
    }

    public function checkout(Request $request)
    {
        // jika login pakai nama user, jika tidak guest
        $nama = Auth::check()
                ? Auth::user()->name
                : "Guest_" . rand(100000,999999);

        $pesanan = DB::table('pesanan')->insertGetId([
            'nama_customer'=>$nama,
            'total'=>$request->total,
            'metode_bayar'=>'midtrans',
            'status_bayar'=>0
        ]);

        foreach($request->items as $item){

            DB::table('detail_pesanan')->insert([
                'idmenu'=>$item['id'],
                'idpesanan'=>$pesanan,
                'jumlah'=>$item['qty'],
                'harga'=>$item['harga'],
                'subtotal'=>$item['harga']*$item['qty']
            ]);

        }

        return response()->json([
            'status'=>'success',
            'order_id'=>$pesanan
        ]);
    }

    public function payment($id)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ];

        $order = DB::table('pesanan')->where('idpesanan',$id)->first();

        if(!$order){
            return response()->json([
                'error' => 'Order tidak ditemukan'
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-'.$order->idpesanan.'-'.time(),
                'gross_amount' => max((int)$order->total,1000)
            ]
        ];

        try {

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token'=>$snapToken
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error'=>$e->getMessage()
            ]);

        }

    }

    public function callback(Request $request)
    {
        $data = $request->all();

        \Log::info('MIDTRANS CALLBACK', $data);

        $order_id = $data['order_id'];
        $transaction_status = $data['transaction_status'];

        $parts = explode('-', $order_id);
        $idpesanan = $parts[1];

        if($transaction_status == 'capture' || $transaction_status == 'settlement'){

            DB::table('pesanan')
                ->where('idpesanan',$idpesanan)
                ->update([
                    'status_bayar'=>1
                ]);

        }

        return response()->json([
            'status'=>'ok'
        ],200);
    }
}
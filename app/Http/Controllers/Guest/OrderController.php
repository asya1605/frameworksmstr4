<?php

namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


class OrderController extends Controller
{
    public function index()
    {
        //Query Builder untuk mengambil data vendor
        $vendor = DB::table('vendor')->get();
        return view('guest.order.index', compact('vendor'));
    }

    public function getMenu($idvendor)
    {
        //ambil menu berdasarkan vendor 
        $menu = DB::table('menu')
            ->where('idvendor',$idvendor)
            ->get();
        
            //dikirim ke JS dalam bentuk JSON
        return response()->json($menu); 
    }

    public function checkout(Request $request)
    {
        // jika login pakai nama user, jika tidak guest
        $nama = Auth::check()
                ? Auth::user()->name
                : "Guest_" . rand(100000,999999);

            // simpan data pesanan ke tabel pesanan, ambil id
        $pesanan = DB::table('pesanan')->insertGetId([
            'nama_customer'=>$nama,
            'total'=>$request->total,
            'metode_bayar'=>'midtrans',
            'status_bayar'=>0
        ]);

        foreach($request->items as $item){

            //simpan detail item
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
        //ambil config dari file .env
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ];
        //ambil data pesanan berdasarkan id
        $order = DB::table('pesanan')->where('idpesanan',$id)->first();

        if(!$order){
            return response()->json([
                'error' => 'Order tidak ditemukan'
            ]);
        }
        //data dikirim ke Midtrans untuk mendapatkan snap token
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-'.$order->idpesanan.'-'.time(),
                'gross_amount' => max((int)$order->total,1000)
            ]
        ];

        try {
            // generate token pembayaran
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

        //ambil ID asli dari format ORDER
        $parts = explode('-', $order_id);
        $idpesanan = $parts[1];

        //kalau pembayaran berhasil
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

    public function success($id)
    {
        $pesanan = DB::table('pesanan')
            ->where('idpesanan',$id)
            ->first();

        if(!$pesanan){
            abort(404);
        }

        //isi QR = ID pesanan
        $qr = new QrCode($pesanan->idpesanan);

        $writer = new PngWriter();

        //generate QR
        $result = $writer->write($qr);

        $qrCode = base64_encode($result->getString());

        return view('guest.order.success',[
            'pesanan'=>$pesanan,
            'qrCode'=>$qrCode
        ]);
}

    public function history()
    {
        //hanya data user login yang ditampilkan
        $pesanan = DB::table('pesanan')
            ->where('nama_customer', Auth::user()->name)
            ->orderBy('idpesanan','desc')
            ->get();

        foreach($pesanan as $p){

            $qr = new \Endroid\QrCode\QrCode($p->idpesanan);
            $writer = new \Endroid\QrCode\Writer\PngWriter();

            $result = $writer->write($qr);

            //tambahkan QR ke setiap data
            $p->qrCode = base64_encode($result->getString());
        }

        return view('guest.order.history', compact('pesanan'));
    }
}

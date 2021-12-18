<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(Request $request) {

    }

    public function home(Request $request) {

        // TOD DO MESSAGE BROKER TO SERVICE USER
        $notifications = null;

        $banner = new BannerController();
        $banners = $banner->show($request);

        // TO DO MESSAGE BROKER TO SERVICE WALLET AND PAYMENT
        $wallets = [
            'dompet' => null,
            'point' => null
        ];

        $kategori_jasa = new KategoriJasaController();
        $jasa = $kategori_jasa->show($request);

        $kategori_ppob = new KategoriPPOBController();
        $ppob = $kategori_ppob->show($request);

        $info = new InfoController();
        $infos = $info->show($request);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => [
                'notificaitons' => $notifications,
                'banners' => $banners->original['data'] ?? null,
                'wallets' => $wallets,
                'kategori_jasa' => $jasa->original['data'] ?? null,
                'kategori_ppob' => $ppob->original['data'] ?? null,
                'info' => $infos->original['data'] ?? null,
                'notifications' => $notifications ?? null
            ]
        ]);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Meja;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $data = [
            'user' => $user,
            'total_menu' => Menu::count(),
            'total_pesanan' => Pesanan::count(),
            'total_transaksi' => Transaksi::count(),
            'total_pelanggan' => Pelanggan::count(),
            'meja_kosong' => Meja::where('status', 'kosong')->count(),
            'meja_terisi' => Meja::where('status', 'terisi')->count(),
        ];

        // Role-specific data
        switch ($user->role) {
            case 'waiter':
                $data['pesanan_hari_ini'] = Pesanan::whereDate('created_at', today())
                    ->where('iduser', $user->id)
                    ->count();
                break;
            case 'kasir':
                $data['transaksi_hari_ini'] = Transaksi::whereDate('created_at', today())->count();
                $data['total_pendapatan_hari'] = Transaksi::whereDate('created_at', today())
                    ->sum('total');
                break;
            case 'owner':
                $data['pendapatan_bulan_ini'] = Transaksi::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('total');
                break;
        }

        return view('dashboard', compact('data'));
    }
}

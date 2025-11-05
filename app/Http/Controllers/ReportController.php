<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function __construct()
    {
        //
    }

    private function checkAccess()
    {
        if (!Auth::user()->isWaiter() && !Auth::user()->isCashier() && !Auth::user()->isOwner()) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function index()
    {
        $this->checkAccess();
        $user = Auth::user();
        
        // Default date range (this month)
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        
        $data = [
            'user' => $user,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];

        // Role-specific reports
        switch ($user->role) {
            case 'waiter':
                $data['pesanan_report'] = $this->getPesananReport($startDate, $endDate, $user->id);
                break;
            case 'kasir':
                $data['transaksi_report'] = $this->getTransaksiReport($startDate, $endDate);
                break;
            case 'owner':
                $data['pendapatan_report'] = $this->getPendapatanReport($startDate, $endDate);
                $data['menu_populer'] = $this->getMenuPopuler($startDate, $endDate);
                $data['transaksi_report'] = $this->getTransaksiReport($startDate, $endDate);
                break;
        }

        return view('laporan.index', compact('data'));
    }

    public function generate(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $user = Auth::user();

        $data = [
            'user' => $user,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        // Role-specific reports
        switch ($user->role) {
            case 'waiter':
                $data['pesanan_report'] = $this->getPesananReport($startDate, $endDate, $user->id);
                break;
            case 'kasir':
                $data['transaksi_report'] = $this->getTransaksiReport($startDate, $endDate);
                break;
            case 'owner':
                $data['pendapatan_report'] = $this->getPendapatanReport($startDate, $endDate);
                $data['menu_populer'] = $this->getMenuPopuler($startDate, $endDate);
                $data['transaksi_report'] = $this->getTransaksiReport($startDate, $endDate);
                break;
        }

        return view('laporan.generate', compact('data'));
    }

    private function getPesananReport($startDate, $endDate, $userId = null)
    {
        $query = Pesanan::with(['menu', 'pelanggan', 'meja'])
            ->whereBetween('created_at', [$startDate, $endDate]);
            
        if ($userId) {
            $query->where('iduser', $userId);
        }

        return $query->get();
    }

    private function getTransaksiReport($startDate, $endDate)
    {
        return Transaksi::with(['pesanan.menu', 'pesanan.pelanggan', 'pesanan.meja'])
            ->whereHas('pesanan') // Hanya ambil transaksi yang punya pesanan
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    }

    private function getPendapatanReport($startDate, $endDate)
    {
        return [
            'total_pendapatan' => Transaksi::whereBetween('created_at', [$startDate, $endDate])
                ->sum('total'),
            'total_transaksi' => Transaksi::whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'rata_rata_transaksi' => Transaksi::whereBetween('created_at', [$startDate, $endDate])
                ->avg('total'),
        ];
    }

    private function getMenuPopuler($startDate, $endDate)
    {
        return Pesanan::with('menu')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('idmenu', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('idmenu')
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return (object) [
                    'menu' => $item->menu,
                    'total_terjual' => $item->total_terjual
                ];
            });
    }

    /**
     * Generate PDF report
     */
    public function generatePdf(Request $request)
    {
        $this->checkAccess();
        
        $request->validate([
            'report_type' => 'required|in:pesanan,transaksi,pendapatan',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $reportType = $request->report_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $data = [
            'report_type' => $reportType,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'generated_at' => now(),
            'generated_by' => Auth::user()->name,
        ];

        switch ($reportType) {
            case 'pesanan':
                $data['pesanans'] = $this->getPesananReport($startDate, $endDate);
                $data['total_pesanan'] = $data['pesanans']->count();
                $data['total_pendapatan'] = $data['pesanans']->sum(function($pesanan) {
                    return $pesanan->menu->harga * $pesanan->jumlah;
                });
                break;
                
            case 'transaksi':
                $data['transaksis'] = $this->getTransaksiReport($startDate, $endDate);
                $data['total_transaksi'] = $data['transaksis']->count();
                $data['total_pendapatan'] = $data['transaksis']->sum('total');
                break;
                
            case 'pendapatan':
                $data['pendapatan'] = $this->getPendapatanReport($startDate, $endDate);
                $data['menu_populer'] = $this->getMenuPopuler($startDate, $endDate);
                $data['transaksis'] = $this->getTransaksiReport($startDate, $endDate);
                break;
        }

        $pdf = Pdf::loadView('laporan.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Laporan_' . ucfirst($reportType) . '_' . $startDate . '_to_' . $endDate . '.pdf';
        
        return $pdf->download($filename);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function __construct()
    {
        //
    }

    private function checkAccess()
    {
        if (!Auth::user()->isCashier()) {
            abort(403, 'Unauthorized access.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAccess();
        $transaksis = Transaksi::with([
                'pesanan.menu', 'pesanan.pelanggan',
                'pesanans.menu', 'pesanans.pelanggan', 'pesanans.meja'
            ])
            ->whereHas('pesanan') // Hanya ambil transaksi yang punya pesanan
            ->orderBy('created_at', 'desc')
            ->get();
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAccess();
        $pesanans = Pesanan::with(['menu', 'pelanggan'])
            ->whereDoesntHave('transaksi')
            ->whereDoesntHave('transaksis')
            ->get();
        return view('transaksi.create', compact('pesanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'idpesanan' => 'required|array|min:1',
            'idpesanan.*' => 'required|exists:pesanans,idpesanan',
            'bayar' => 'required|integer|min:0',
        ]);

        $pesanans = Pesanan::with('menu')->whereIn('idpesanan', $request->idpesanan)->get();
        $total = $pesanans->sum(function($p){ return $p->menu->harga * $p->jumlah; });

        if ($request->bayar < $total) {
            return back()->withErrors([
                'bayar' => 'Jumlah pembayaran tidak mencukupi.'
            ]);
        }

        // Generate ID transaksi otomatis
        $lastTransaksi = Transaksi::orderBy('idtransaksi', 'desc')->first();
        $nextNumber = $lastTransaksi ? (int)substr($lastTransaksi->idtransaksi, 1) + 1 : 1;
        $idtransaksi = 'T' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $transaksi = Transaksi::create([
            'idtransaksi' => $idtransaksi,
            'idpesanan' => $request->idpesanan[0],
            'total' => $total,
            'bayar' => $request->bayar,
        ]);

        // Attach all selected pesanan to pivot
        $transaksi->pesanans()->attach($request->idpesanan);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diproses.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        $this->checkAccess();
        $transaksi->load(['pesanan.menu', 'pesanan.pelanggan']);
        
        // Pastikan pesanan masih ada
        if (!$transaksi->pesanan) {
            abort(404, 'Pesanan tidak ditemukan.');
        }
        
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $this->checkAccess();
        return view('transaksi.edit', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $this->checkAccess();
        $request->validate([
            'bayar' => 'required|integer|min:' . $transaksi->total,
        ]);

        $transaksi->update([
            'bayar' => $request->bayar,
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $this->checkAccess();
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Generate and stream a receipt PDF for the given transaksi
     */
    public function receipt(Transaksi $transaksi)
    {
        $this->checkAccess();
        $transaksi->load(['pesanan.menu', 'pesanan.pelanggan']);
        
        // Pastikan pesanan masih ada
        if (!$transaksi->pesanan) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $pdf = Pdf::loadView('transaksi.receipt', [
            'transaksi' => $transaksi,
        ])->setPaper('a5', 'portrait');

        $filename = 'Struk_' . $transaksi->idtransaksi . '.pdf';
        return $pdf->stream($filename);
    }
}

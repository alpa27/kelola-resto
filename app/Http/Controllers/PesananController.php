<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function __construct()
    {
        //
    }

    private function checkAccess()
    {
        if (!Auth::user()->isWaiter()) {
            abort(403, 'Unauthorized access.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAccess();
        $pesanans = Pesanan::with(['menu', 'pelanggan', 'user', 'meja'])
            ->where('iduser', Auth::id())
            ->get();

        // Group by pelanggan and order date (YYYY-MM-DD)
        $groupedPesanan = $pesanans->groupBy(function ($p) {
            $date = optional($p->created_at)->format('Y-m-d');
            return $p->idpelanggan . '|' . $date;
        })->map(function ($items, $key) {
            [$pelangganId, $tanggal] = explode('|', $key);
            $first = $items->first();
            // Aggregate same menu names into qty sum
            $aggregated = [];
            foreach ($items as $it) {
                $name = optional($it->menu)->namamenu ?? '-';
                if (!isset($aggregated[$name])) {
                    $aggregated[$name] = 0;
                }
                $aggregated[$name] += (int) $it->jumlah;
            }
            return [
                'pelanggan_id' => $pelangganId,
                'pelanggan_nama' => optional($first->pelanggan)->namapelanggan ?? '-',
                'tanggal' => $tanggal,
                'meja' => optional($first->meja),
                'items' => $items,
                'aggregated' => $aggregated,
            ];
        })->values();

        return view('pesanan.index', compact('pesanans', 'groupedPesanan'));
    }

    /**
     * Show grouped items by pelanggan for quick edit/delete per group.
     */
    public function group(string $idpelanggan, ?string $tanggal = null)
    {
        $this->checkAccess();
        $query = Pesanan::with(['menu', 'pelanggan', 'meja'])
            ->where('idpelanggan', $idpelanggan)
            ->where('iduser', Auth::id())
            ->orderBy('created_at', 'asc');

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $items = $query->get();

        if ($items->isEmpty()) {
            return redirect()->route('pesanan.index')
                ->with('info', 'Tidak ada pesanan aktif untuk pelanggan ini.');
        }

        $pelanggan = $items->first()->pelanggan;
        $tanggalView = optional($items->first()->created_at)->format('Y-m-d');
        return view('pesanan.group', [
            'items' => $items,
            'pelanggan' => $pelanggan,
            'tanggal' => $tanggalView,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAccess();
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        $mejas = Meja::where('status', 'kosong')->get();
        return view('pesanan.create', compact('menus', 'pelanggans', 'mejas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.idmenu' => 'required|exists:menus,idmenu',
            'items.*.jumlah' => 'required|integer|min:1',
            'idpelanggan' => 'required|exists:pelanggans,idpelanggan',
            'idmeja' => 'required|exists:mejas,id',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->items as $item) {
                // Generate ID pesanan otomatis untuk setiap item
                do {
                    $lastPesanan = Pesanan::orderBy('idpesanan', 'desc')->lockForUpdate()->first();
                    $nextNumber = $lastPesanan ? (int)substr($lastPesanan->idpesanan, 2) + 1 : 1;
                    $idpesanan = 'PS' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                    $existingPesanan = Pesanan::where('idpesanan', $idpesanan)->exists();
                } while ($existingPesanan);

                Pesanan::create([
                    'idpesanan' => $idpesanan,
                    'idmenu' => $item['idmenu'],
                    'idpelanggan' => $request->idpelanggan,
                    'idmeja' => $request->idmeja,
                    'jumlah' => $item['jumlah'],
                    'iduser' => Auth::id(),
                ]);
            }

            // Update status meja menjadi terisi
            Meja::where('id', $request->idmeja)->update(['status' => 'terisi']);
        });

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan)
    {
        $this->checkAccess();
        $pesanan->load(['menu', 'pelanggan', 'user', 'meja']);
        return view('pesanan.show', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        $this->checkAccess();
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        $mejas = Meja::all();
        return view('pesanan.edit', compact('pesanan', 'menus', 'pelanggans', 'mejas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $this->checkAccess();
        $request->validate([
            'idmenu' => 'required|exists:menus,idmenu',
            'idpelanggan' => 'required|exists:pelanggans,idpelanggan',
            'idmeja' => 'required|exists:mejas,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Jika meja berubah, update status meja lama dan baru
        if ($pesanan->idmeja != $request->idmeja) {
            // Meja lama kembali menjadi kosong
            Meja::where('id', $pesanan->idmeja)->update(['status' => 'kosong']);
            // Meja baru menjadi terisi
            Meja::where('id', $request->idmeja)->update(['status' => 'terisi']);
        }

        $pesanan->update($request->all());

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        $this->checkAccess();
        
        // Simpan idmeja sebelum menghapus
        $idmeja = $pesanan->idmeja;
        
        $pesanan->delete();

        // Kembalikan status meja menjadi kosong
        Meja::where('id', $idmeja)->update(['status' => 'kosong']);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}

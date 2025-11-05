<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function __construct()
    {
        //
    }

    private function checkAccess()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isWaiter()) {
            abort(403, 'Unauthorized access.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAccess();
        $pelanggans = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAccess();
        return view('pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'namapelanggan' => 'required|string|max:255',
            'jeniskelamin' => 'required|boolean',
            'nohp' => 'required|string|max:12',
            'alamat' => 'required|string|max:95',
        ]);

        // Generate ID pelanggan otomatis
        $lastPelanggan = Pelanggan::orderBy('idpelanggan', 'desc')->first();
        $nextNumber = $lastPelanggan ? (int)substr($lastPelanggan->idpelanggan, 1) + 1 : 1;
        $idpelanggan = 'P' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Pelanggan::create([
            'idpelanggan' => $idpelanggan,
            'namapelanggan' => $request->namapelanggan,
            'jeniskelamin' => $request->jeniskelamin,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        $this->checkAccess();
        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        $this->checkAccess();
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $this->checkAccess();
        $request->validate([
            'namapelanggan' => 'required|string|max:255',
            'jeniskelamin' => 'required|boolean',
            'nohp' => 'required|string|max:12',
            'alamat' => 'required|string|max:95',
        ]);

        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $this->checkAccess();
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}

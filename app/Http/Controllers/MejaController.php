<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth;

class MejaController extends Controller
{
    public function __construct()
    {
        //
    }

    private function checkAccess()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAccess();
        $mejas = Meja::all();
        return view('meja.index', compact('mejas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAccess();
        return view('meja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'nomor_meja' => 'required|string|max:255|unique:mejas,nomor_meja',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:kosong,terisi,reserved',
        ]);

        Meja::create($request->all());

        return redirect()->route('meja.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meja $meja)
    {
        $this->checkAccess();
        return view('meja.show', compact('meja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meja $meja)
    {
        $this->checkAccess();
        return view('meja.edit', compact('meja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meja $meja)
    {
        $this->checkAccess();
        $request->validate([
            'nomor_meja' => 'required|string|max:255|unique:mejas,nomor_meja,' . $meja->id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:kosong,terisi,reserved',
        ]);

        $meja->update($request->all());

        return redirect()->route('meja.index')
            ->with('success', 'Meja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meja $meja)
    {
        $this->checkAccess();
        $meja->delete();

        return redirect()->route('meja.index')
            ->with('success', 'Meja berhasil dihapus.');
    }
}

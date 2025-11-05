<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAccess();
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'namamenu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
        ]);

        // Generate ID menu otomatis
        $lastMenu = Menu::orderBy('idmenu', 'desc')->first();
        $nextNumber = $lastMenu ? (int)substr($lastMenu->idmenu, 1) + 1 : 1;
        $idmenu = 'M' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Menu::create([
            'idmenu' => $idmenu,
            'namamenu' => $request->namamenu,
            'harga' => $request->harga,
        ]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $this->checkAccess();
        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $this->checkAccess();
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $this->checkAccess();
        $request->validate([
            'namamenu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
        ]);

        $menu->update($request->all());

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $this->checkAccess();
        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}

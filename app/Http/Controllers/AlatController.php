<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat = Alat::all();
        return view('admin.alat.index', compact('alat'));
    }

    public function catalog()
    {
        $alat = Alat::with('kategori')->orderBy('nama_alat')->get();

        return view('peminjam.dashboard', compact('alat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.alat.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $alat = Alat::create([
            'id_kategori' => $request->id_kategori,
            'nama_alat' => $request->nama_alat,
            'stok' => $request->stok,
        ]);

        return redirect()->route('alat.index') ->with('success', 'Alat created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alat = Alat::findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $alat = Alat::findOrFail($id);
        $alat->update([
            'id_kategori' => $request->id_kategori,
            'nama_alat' => $request->nama_alat,
            'stok' => $request->stok,
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alat = Alat::find($id);
        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with(['alat.kategori', 'kategori'])
            ->latest()
            ->get();

        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function create()
    {
        $alat = Alat::with('kategori')->orderBy('nama_alat')->get();

        return view('admin.pengembalian.create', compact('alat'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_alat' => ['required', 'exists:alats,id'],
            'status' => ['required', 'in:belum_dikembalikan,sudah_dikembalikan,terlambat'],
        ]);

        $alat = Alat::findOrFail($data['id_alat']);
        $data['id_kategori'] = $alat->id_kategori;
        Pengembalian::create($data);

        return redirect()->route('pengembalian.index')
            ->with('success', 'Data pengembalian berhasil ditambahkan.');
    }

    public function edit(Pengembalian $pengembalian)
    {
        $alat = Alat::with('kategori')->orderBy('nama_alat')->get();

        return view('admin.pengembalian.edit', compact('pengembalian', 'alat'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $data = $request->validate([
            'id_alat' => ['required', 'exists:alats,id'],
            'status' => ['required', 'in:belum_dikembalikan,sudah_dikembalikan,terlambat'],
        ]);

        $alat = Alat::findOrFail($data['id_alat']);
        $data['id_kategori'] = $alat->id_kategori;
        $pengembalian->update($data);

        return redirect()->route('pengembalian.index')
            ->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();

        return redirect()->route('pengembalian.index')
            ->with('success', 'Data pengembalian berhasil dihapus.');
    }
}

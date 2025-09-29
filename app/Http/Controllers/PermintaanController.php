<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Permintaan;
use App\Models\PermintaanItem;
use App\Models\Departemen;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function index()
    {
        $permintaan = Permintaan::with('departemen', 'items.barang')->latest()->paginate(10);
        return view('permintaan.index', compact('permintaan'));
    }

    public function create()
    {
        $barang = Barang::all();
        $departemen = Departemen::all();
        return view('permintaan.create', compact('barang', 'departemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'departemen_id' => 'required|exists:departemen,id',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|numeric|min:1'
        ]);

        $permintaan = Permintaan::create([
            'departemen_id' => $request->departemen_id,
            'status' => 'pending'
        ]);

        foreach ($request->items as $item) {
            PermintaanItem::create([
                'permintaan_id' => $permintaan->id,
                'barang_id' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->route('permintaan.index')->with('success', 'Permintaan berhasil diajukan');
    }
}

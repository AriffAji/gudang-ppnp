<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Helpers\TransactionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        return view('barang_masuk.index', compact('barangMasuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|numeric|min:1',
            'sumber' => 'required|string',
            'tanggal_masuk' => 'required|date'
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $stokSebelum = $barang->stok;
        $stokSesudah = $stokSebelum + $request->jumlah;

        $kode = TransactionCode::generate('BRGMSK', 'barang_masuk', 'kode_transaksi');

        BarangMasuk::create([
            'barang_id' => $barang->id,
            'jumlah' => $request->jumlah,
            'sumber' => $request->sumber,
            'tanggal_masuk' => $request->tanggal_masuk,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokSesudah,
            'kode_transaksi' => $kode,
            'created_by' => Auth::id(),
        ]);

        $barang->update(['stok' => $stokSesudah]);

        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil dicatat');
    }

    public function show($id)
    {
        $barangMasuk = BarangMasuk::with('barang')->findOrFail($id);
        return view('barang_masuk.show', compact('barangMasuk'));
    }
}

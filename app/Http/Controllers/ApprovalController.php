<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Helpers\TransactionCode;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $permintaan = Permintaan::with('departemen','items.barang')->where('status','pending')->paginate(10);
        return view('approval.index', compact('permintaan'));
    }

    public function approve($id)
    {
        $permintaan = Permintaan::with('items')->findOrFail($id);

        foreach ($permintaan->items as $item) {
            $barang = Barang::find($item->barang_id);
            $stokSebelum = $barang->stok;

            if ($stokSebelum < $item->jumlah) {
                return back()->with('error', 'Stok barang ' . $barang->nama_barang . ' tidak cukup');
            }

            $stokSesudah = $stokSebelum - $item->jumlah;
            $kode = TransactionCode::generate('BRGKLR', 'barang_keluar', 'kode_transaksi');

            BarangKeluar::create([
                'barang_id' => $barang->id,
                'jumlah' => $item->jumlah,
                'penerima' => $permintaan->departemen->nama_departemen,
                'departemen_id' => $permintaan->departemen_id,
                'tanggal_keluar' => now(),
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'kode_transaksi' => $kode,
                'created_by' => Auth::id(),
            ]);

            $barang->update(['stok' => $stokSesudah]);
        }

        $permintaan->update(['status' => 'approved']);

        return redirect()->route('approval.index')->with('success', 'Permintaan disetujui dan barang keluar dicatat');
    }

    public function reject($id)
    {
        $permintaan = Permintaan::findOrFail($id);
        $permintaan->update(['status' => 'rejected']);
        return redirect()->route('approval.index')->with('success', 'Permintaan ditolak');
    }
}

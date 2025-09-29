<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';
    protected $fillable = [
        'barang_id','jumlah','sumber','tanggal_masuk',
        'stok_sebelum','stok_sesudah','kode_transaksi','created_by'
    ];

    public function barang() { return $this->belongsTo(Barang::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';
    protected $fillable = [
        'barang_id','jumlah','penerima','departemen_id','tanggal_keluar',
        'stok_sebelum','stok_sesudah','kode_transaksi','created_by'
    ];
    public function barang() { return $this->belongsTo(Barang::class); }
    public function departemen() { return $this->belongsTo(Departemen::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}

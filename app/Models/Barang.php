<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['nama_barang','kategori_id','satuan','stok','minimum_stok'];

    public function kategori(): BelongsTo {
        return $this->belongsTo(Kategori::class);
    }

    public function masuk() {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function keluar() {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }
}

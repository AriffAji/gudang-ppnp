<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanItem extends Model
{
    protected $table='permintaan_items';
    protected $fillable=['permintaan_id','barang_id','jumlah_permintaan','jumlah_disetujui','catatan'];
    public function barang() { return $this->belongsTo(Barang::class); }
    public function permintaan() { return $this->belongsTo(Permintaan::class); }
}

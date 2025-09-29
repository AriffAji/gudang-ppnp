<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    protected $table='permintaan';
    protected $fillable=['nama_peminta','departemen_id','keterangan','status','approved_by','approved_at'];

    public function items() { return $this->hasMany(PermintaanItem::class); }
    public function departemen() { return $this->belongsTo(Departemen::class); }
    public function approvedBy() { return $this->belongsTo(User::class,'approved_by'); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;
    protected $fillable = [
        'tanggal_masuk',
        'nama_barang',
        'tipe',
        'status_barang',
        'jumlah_unit',
        'kategori_barang',
        'ex_user',
        'departemen',
        'nomor_asset',
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_barang', 'id_kategori');
    }
}
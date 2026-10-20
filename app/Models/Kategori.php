<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'jenis_kategori'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_barang', 'id_kategori');
    }
}
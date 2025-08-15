<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'deskripsi',
        'harga',
        'stok',
        'foto',
        'halaman',
        // 'bahasa',
        'panjang',
        'lebar',
        'berat'
    ];

    protected $attributes = [
        'judul' => 'Tanpa Judul',
        'penulis' => '-',
        'deskripsi' => '-',
        'harga' => 0,
        'stok' => 0,
        // 'bahasa' => 'Indonesia',
        'halaman' => null,
        'panjang' => null,
        'lebar' => null,
        'berat' => null,
        'foto' => null
    ];

    // Accessor untuk foto
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/default-book.png');
    }
}

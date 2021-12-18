<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJasa extends Model
{
    use HasFactory;

    protected $table = 'kategori_jasa';

    protected $fillable = [
        'kode_jasa', 'nama_jasa', 'action', 'icon_jasa', 'is_published', 'set_priority'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

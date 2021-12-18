<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPPOB extends Model
{
    use HasFactory;

    protected $table = 'kategori_ppob';

    protected $fillable = [
        'kode_ppob', 'nama_ppob', 'action', 'icon_ppob', 'is_published', 'set_priority'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

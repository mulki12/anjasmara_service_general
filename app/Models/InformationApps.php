<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationApps extends Model
{
    use HasFactory;

    protected $table = 'information_apps';

    protected $fillable = [
        'platform', 'scope', 'section_information', 'content_information'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

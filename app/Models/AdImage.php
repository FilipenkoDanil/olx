<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'ad_id',
    ];

    public function ad(){
        return $this->belongsTo(Ad::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function deleteImg()
    {
        if(count($this->ad->images) > 1){
            Storage::delete($this->image);
            $this->delete();

            return true;
        }

        return false;
    }
}

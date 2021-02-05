<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'city_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function images(){
        return $this->hasMany(AdImage::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function addImages($request){
        foreach ($request->file('image') as $item) {
            $path = $item->store('user-images');
            AdImage::create([
                'image' => $path,
                'ad_id' => $this->id,
            ]);
        }
    }

    public function deleteImages(){
        foreach ($this->images as $image) {
            Storage::delete($image->image);
        }
    }
}

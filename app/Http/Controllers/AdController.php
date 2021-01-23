<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\AdImage;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::all();
        return view('home', compact('ads'));
    }

    public function create()
    {
        return view('ad.create');
    }

    public function store(AdRequest $request)
    {
        $ad = Ad::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        foreach ($request->file('image') as $item) {
            $path = $item->store('ad-images');
            AdImage::create([
                'image' => $path,
                'ad_id' => $ad->id
            ]);
        }

        return redirect()->route('home')->with('success', 'Объявление добавлено.');
    }
}

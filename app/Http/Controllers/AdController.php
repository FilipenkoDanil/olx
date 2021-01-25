<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\AdImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::all()->sortByDesc('created_at');
        return view('home', compact('ads'));
    }

    public function show($adId)
    {
        $ad = Ad::where('id', $adId)->with('user')->first();
        if ($ad) {
            return view('ad.show', compact('ad'));
        }
        abort(404);
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
            $path = $item->store('user-images');
            AdImage::create([
                'image' => $path,
                'ad_id' => $ad->id
            ]);
        }

        return redirect()->route('home')->with('success', 'Объявление добавлено.');
    }

    public function destroy($ad)
    {
        $ad = Ad::find($ad);
        foreach ($ad->images as $image) {
            Storage::delete($image->image);
        }
        $ad->delete();

        return redirect()->route('home');
    }
}

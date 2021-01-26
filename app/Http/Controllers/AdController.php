<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\AdImage;
use App\Models\City;
use Illuminate\Http\Request;
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
        $cities = City::all()->sortBy('city');
        return view('ad.create', compact('cities'));
    }

    public function store(AdRequest $request)
    {
        $ad = Ad::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'city_id' => $request->city,
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

    public function edit($ad)
    {
        $ad = Ad::where('id',$ad)->with('images')->first();
        if (!is_null($ad) && Auth::id() == $ad->user_id) {
            $cities = City::all()->sortBy('city');
            return view('ad.edit', compact(['ad', 'cities']));
        }
        return redirect()->back();
    }

    public function update(Request $request, Ad $ad)
    {
        $ad->update($request->all());

        if(!is_null($request->file('image'))){
            foreach ($request->file('image') as $item) {
                $path = $item->store('user-images');
                AdImage::create([
                    'image' => $path,
                    'ad_id' => $ad->id
                ]);
            }
        }


        return redirect()->route('show', $ad->id);
    }

    public function deleteImage(AdImage $image){
        Storage::delete($image->image);
        $image->delete();

        return redirect()->back();
    }
}

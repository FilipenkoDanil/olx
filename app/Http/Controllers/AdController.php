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
        $ads = Ad::with('images')->orderBy('created_at', 'desc')->paginate(8);
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
            'city_id' => $request->city_id,
        ]);

        $ad->addImages($request);

        return redirect()->route('home')->with('success', 'Объявление добавлено.');
    }

    public function destroy($ad)
    {
        $ad = Ad::find($ad);
        $ad->deleteImages();
        $ad->delete();

        return redirect()->route('home');
    }

    public function edit($ad)
    {
        $ad = Ad::where('id', $ad)->with('images')->first();
        if (!is_null($ad) && Auth::id() == $ad->user_id) {
            return view('ad.edit', compact('ad'));
        }
        return redirect()->back();
    }

    public function update(AdRequest $request, Ad $ad)
    {
        $ad->update($request->all());
        if (!is_null($request->file('image'))) {
            $ad->addImages($request);
        }

        return redirect()->route('show', $ad->id);
    }

    public function deleteImage(AdImage $image)
    {
        if ($image->deleteImg()) {
            return redirect()->back();
        }

        return redirect()->back()->with('warning', 'У объявления должна быть хотя-бы одна фотография.');
    }
}

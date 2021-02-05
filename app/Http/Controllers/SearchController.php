<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        if (!is_null($query)) {
            if ($request->city > 0) {
                $ads = Ad::where('title', 'LIKE', '%' . $query . '%')->where('city_id', $request->city)->orderBy('created_at', 'desc')->paginate(8);
                return view('home', compact(['ads', 'query']));
            }
            $ads = Ad::where('title', 'LIKE', '%' . $query . '%')->orderBy('created_at', 'desc')->paginate(8);
            return view('home', compact(['ads', 'query']));

        } elseif ($request->city > 0) {
            $ads = Ad::where('city_id', $request->city)->orderBy('created_at', 'desc')->paginate(8);
            return view('home', compact(['ads']));
        }

        return redirect()->route('home');
    }

    public function userAds($user)
    {
        $user = User::find($user);
        return view('user.ads', compact('user'));
    }
}

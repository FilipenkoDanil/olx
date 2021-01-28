<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        $cities = City::all()->sortBy('city');

        if(!is_null($query) && $request->сity > 0){
            $ads = Ad::where('title', 'LIKE', '%' . $query . '%')->where('city_id', $request->сity)->orderBy('created_at', 'desc')->paginate(8);
            return view('home', compact(['ads', 'query', 'cities']));
        } elseif(!is_null($query)){
            $ads = Ad::where('title', 'LIKE', '%' . $query . '%')->orderBy('created_at', 'desc')->paginate(8);
            return view('home', compact(['ads', 'query', 'cities']));
        }

        return redirect()->route('home');
    }

    public function userAds($user){
        $user = User::find($user);
        return view('user.ads', compact('user'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        if(!is_null($query)){
            $ads = Ad::where('title', 'LIKE', '%' . $query . '%')->orderBy('created_at', 'desc')->paginate(8);
            return view('home', compact(['ads', 'query']));
        }

        $ads = Ad::orderBy('created_at', 'desc')->paginate(8);
        return view('home', compact('ads'));
    }
}

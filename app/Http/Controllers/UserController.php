<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return 0;
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(ProfileRequest $request, User $user)
    {
        if ($request->has('avatar')) {
            if ($user->avatar !== 'avatars/default.png') {
                Storage::delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars');
            $params = $request->all();
            $params['avatar'] = $path;
            $user->update($params);

            return redirect()->back();
        }

        $params = $request->all();
        $params['avatar'] = $user->avatar;
        $user->update($params);

        return redirect()->back();
    }
}

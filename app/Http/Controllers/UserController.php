<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('user.index', compact('user'));
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

    public function addReview(ReviewRequest $request, User $user)
    {
        if ($request->get('rating')) {
            Review::create([
                'user_id' => $user->id,
                'writer_id' => Auth::id(),
                'comment' => $request->comment,
                'rating' => $request->rating,
            ]);

            $user->updateRating();
            return redirect()->back();
        }

        Review::create([
            'user_id' => $user->id,
            'writer_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => 0.0,
        ]);

        return redirect()->back();
    }

    public function deleteReview(Review $review)
    {
        $review->deleteReview();
        return redirect()->back();
    }
}

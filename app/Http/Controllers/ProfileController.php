<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Rating;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function activity()
    {
        $ratings = Rating::all();
//        $ratings = Rating::whereHas('post', function ($query) {
//            $query->where('author_id', auth()->id());
//        })
//            ->where('user_id', '!=', auth()->id())
//            ->where('is_read', 0)
//            ->with(['post.author', 'user'])
//            ->get();
        return view('profile.partials.activity', ['ratings' => $ratings]);
    }


    public function markRead(Request $request)
    {
        if ($request->has('mark_all')) {
            Rating::whereHas('post', function ($query) {
                $query->where('user_id', auth()->id());
            })
                ->where('user_id', '!=', auth()->id())
                ->update(['is_read' => true]);
        } else {
            foreach ($request->read_items ?? [] as $item) {
                if (str_starts_with($item, 'rating_')) {
                    $id = explode('_', $item)[1];

                    Rating::where('id', $id)
                        ->whereHas('post', function ($q) {
                            $q->where('user_id', auth()->id());
                        })
                        ->update(['is_read' => true]);
                }
            }
        }

        return redirect()->route('profile.activity')->with('status', 'Позначено як прочитане');
    }


}



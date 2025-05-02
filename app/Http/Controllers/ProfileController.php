<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile form for the current guard.
     */
    public function show(Request $request)
    {
        // 1) Determine guard from the URL (first segment)
        $guard = $request->segment(1);

        // 2) Only allow your three guards
        if (! in_array($guard, ['admin','author','reader'])) {
            abort(404);
        }

        // 3) Tell Laravel to use that guard
        Auth::shouldUse($guard);

        // 4) Fetch the authenticated user for that guard
        $user = Auth::guard($guard)->user();

        return view('profile', compact('user','guard'));
    }

    /**
     * Process the profile update for the current guard.
     */
    public function update(Request $request)
    {
        // Same guard-detection steps as in show()
        $guard = $request->segment(1);
        if (! in_array($guard, ['admin','author','reader'])) {
            abort(404);
        }
        Auth::shouldUse($guard);
        $user = Auth::guard($guard)->user();

        // Validation
        $data = $request->validate([
            'name'           => ['required','string','max:255'],
            'email'          => [
                'required','email',
                Rule::unique("{$guard}s",'email')->ignore($user->id),
            ],
            'password'       => ['nullable','confirmed','min:8'],
            'profile_image'  => ['nullable','image','max:2048'],
        ]);

        // Build updates array
        $updates = [
            'name'  => $data['name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $updates['password'] = Hash::make($data['password']);
        }

        if ($request->hasFile('profile_image')) {
            $updates['profile_image'] =
                $request->file('profile_image')
                        ->store('profiles','public');
        }

        // Persist in one call
        $user->update($updates);

        return back()->with('success','Profile updated successfully');
    }
}

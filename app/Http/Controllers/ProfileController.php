<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ImageCompressionService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.show', compact('user'));
    }

    public function update(Request $request, ImageCompressionService $imageService)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Handle image removal request
        if ($request->input('remove_image') == '1') {
            $oldImage = $user->profile_image ?? $user->image;
            if ($oldImage && file_exists(public_path('uploaded_img/' . $oldImage))) {
                @unlink(public_path('uploaded_img/' . $oldImage));
            }
            $user->profile_image = null;
            $user->image = null;
            $user->save();

            return back()->with('success', 'Foto profil berhasil dihapus.');
        }

        $validated = $request->validate([
            'fullname' => 'nullable|string|max:100',
            'username' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'country' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif',
        ]);

        // Handle image upload or replace with compression
        if ($request->hasFile('profile_image') || $request->hasFile('image')) {
            $file = $request->file('profile_image') ?? $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'jpeg') $ext = 'jpg';
            $customFilename = 'avatar_' . ($user->_id ?? $user->id) . '_' . time() . '.' . $ext;

            $result = $imageService->compressAndSave($file, public_path('uploaded_img'), $customFilename);

            if (!$result['success']) {
                return back()->withInput()->withErrors(['profile_image' => $result['error']]);
            }

            // Delete old custom image if exists and different
            $oldImage = $user->profile_image ?? $user->image;
            if ($oldImage && $oldImage !== $result['filename'] && file_exists(public_path('uploaded_img/' . $oldImage))) {
                @unlink(public_path('uploaded_img/' . $oldImage));
            }

            $user->profile_image = $result['filename'];
            $user->image = $result['filename'];
        }

        // Exclude file keys from direct attribute update
        $textFields = collect($validated)->except(['profile_image', 'image'])->all();
        foreach ($textFields as $key => $val) {
            if ($val !== null) {
                $user->{$key} = $val;
            }
        }

        $user->save();

        return back()->with('success', 'Profil dan foto Anda berhasil diperbarui!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ImageCompressionService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('level', 'consument')->latest()->get();
        $admins = User::whereIn('level', ['Super Admin', 'Admin', 'Customer Service', 'Marketing', 'Executive'])->latest()->get();

        return view('admin.users.index', compact('users', 'admins'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status === 'Active') ? 'Disabled' : 'Active';
        $user->save();

        return back()->with('success', 'Status akun user ' . $user->username . ' telah diubah menjadi ' . $user->status);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }

    /**
     * Display admin profile page
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile details & image with compression
     */
    public function updateProfile(Request $request, ImageCompressionService $imageService)
    {
        $user = Auth::user();

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
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'country' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:1000',
            'job' => 'nullable|string|max:100',
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

            $oldImage = $user->profile_image ?? $user->image;
            if ($oldImage && $oldImage !== $result['filename'] && file_exists(public_path('uploaded_img/' . $oldImage))) {
                @unlink(public_path('uploaded_img/' . $oldImage));
            }

            $user->profile_image = $result['filename'];
            $user->image = $result['filename'];
        }

        $textFields = collect($validated)->except(['profile_image', 'image'])->all();
        foreach ($textFields as $key => $val) {
            if ($val !== null) {
                $user->{$key} = $val;
            }
        }

        $user->save();

        return back()->with('success', 'Profil dan foto admin berhasil diperbarui!');
    }
}

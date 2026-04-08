<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Image;

trait HandlesUserProfileUpdates
{
    protected function profileUpdateRules(User $user): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'designation' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'insta' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'intro' => ['nullable', 'string', 'max:2000'],
            'profile_pic' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    protected function updateProfileFromRequest(Request $request, User $user): User
    {
        $validated = $request->validate($this->profileUpdateRules($user));

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->designation = $validated['designation'] ?? null;
        $user->linkedin = $validated['linkedin'] ?? null;
        $user->insta = $validated['insta'] ?? null;
        $user->twitter = $validated['twitter'] ?? null;
        $user->intro = $validated['intro'] ?? null;

        if ($request->hasFile('profile_pic')) {
            $newFilename = $this->storeProfileImage($request->file('profile_pic'), $user->name);

            if ($user->profile_pic && File::exists(public_path('img/site/' . $user->profile_pic))) {
                File::delete(public_path('img/site/' . $user->profile_pic));
            }

            $user->profile_pic = $newFilename;
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return $user;
    }

    protected function storeProfileImage(UploadedFile $image, string $name): string
    {
        $filename = Str::slug($name ?: 'user') . '-' . time() . '.webp';
        File::ensureDirectoryExists(public_path('img/site'));

        $resizedImage = Image::make($image);

        if ($resizedImage->height() > $resizedImage->width()) {
            $width = 600;
            $height = null;
        } else {
            $width = 600;
            $height = 600;
        }

        $resizedImage->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('img/site/' . $filename));

        return $filename;
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Resources\User as ResourcesUser;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile(Request $request)
    {
        $params = [
            'profile' => new ResourcesUser($request->user()),
        ];
        // return $request->user();
        // return new ResourcesUser($request->user());
        return Inertia::render('Profile/Profile', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:64'],
            'mobile' => ['nullable', 'string', 'max:13', 'min:11'],
            'address' => ['nullable', 'string', 'max:255'],
            'photo_removed' => ['required', 'boolean'],
            // 'image'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $relative_path = 'images';
        $relative_thumbnail = 'thumbnails/'.$relative_path;

        Storage::makeDirectory($relative_path);
        Storage::makeDirectory($relative_thumbnail);

        $original_path = Storage::path($relative_path);
        $original_thumbnail = Storage::path($relative_thumbnail);

        DB::beginTransaction();

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->update();

        // Helpers::imageUpload($request, '-profile-image.', $user);
        if ($request->photo_file) {
            if ($request->hasFile('photo_file')) {
                if ($request->file('photo_file')->isValid()) {
                    $extension = $request->photo_file->extension();
                    $file_name = $user->id.'-'.$user->name.'-profile-image.'.$extension;
                    $image_path = $request->photo_file->storeAs($relative_path, $file_name, 'public');

                    $thumbnail_file_path = $original_thumbnail.'/'.$file_name;

                    $manager = new ImageManager(config('image.driver'));
                    $image_mng = $manager->make(Storage::path($image_path));
                    $image_mng->scale(width: 134);
                    $image_mng->toPng()->save($thumbnail_file_path);

                    $image = new Image(['path' => $image_path]);

                    if (! ($user->images()->save($image))) {
                        return back()->with('success', 'Profile image updating failed!.');
                    }
                }
            }
        } else {
            if ($user->latest_image && $request->photo_removed) {
                foreach ($user->images as $image) {
                    if (Storage::exists($image->path)) {
                        unlink(Storage::path($image->path));
                    }
                    if (Storage::exists('thumbnails/'.$image->path)) {
                        unlink(Storage::path('thumbnails/'.$image->path));
                    }
                    $image->delete();
                }
            }
        }

        DB::commit();

        return back()->with('success', 'Profile updated.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = User::find(Auth::id());

        $relative_path = 'images';
        $relative_thumbnail = 'thumbnails/'.$relative_path;

        Storage::makeDirectory($relative_path);
        Storage::makeDirectory($relative_thumbnail);

        $original_path = Storage::path($relative_path);
        $original_thumbnail = Storage::path($relative_thumbnail);

        if ($request->image) {
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $extension = $request->image->extension();
                    $file_name = Str::random(10).'.'.$extension;
                    $image_path = $request->image->storeAs($relative_path, $file_name, 'public');

                    $thumbnail_file_path = $original_thumbnail.'/'.$file_name;

                    $manager = new ImageManager(config('image.driver'));
                    $image_mng = $manager->make(Storage::path($image_path));
                    $image_mng->scale(width: 134);
                    $image_mng->toPng()->save($thumbnail_file_path);

                    $image = new Image(['path' => $image_path]);

                    if (! ($user->images()->save($image))) {
                        return back()->with('fail', 'Profile image updating failed!.');
                    }

                    return back()->with('success', 'Profile image updated.');
                }

                return back()->with('fail', 'Image not valid!');
            }

            return back()->with('fail', 'Image not found!');
        } else {
            if ($user->latest_image && $request->photo_removed) {
                if (! (Image::where('imageable_id', $user->id)->delete())) {
                    return back()->with('fail', 'Image removing failed!.');
                }

                unlink(storage_path('app/public/thumbnails/'.$user->latest_image?->path));
                unlink(storage_path('app/public/'.$user->latest_image?->path));

                return back()->with('success', 'Image removed!');
            }

            return back()->with('fail', 'Image removing failed! Image not found!');
        }
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function password(Request $request)
    {
        $params = [
            'profile' => $request->user(),
        ];

        return Inertia::render('Profile/Password', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::beginTransaction();
        $user->password = Hash::make($request->new_password);
        $user->update();

        DB::commit();

        return back()->with('success', __('Password modified successfully'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Momment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    private User $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth.api', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->profile->startup_skip) {
            $this->user = Auth::user();
            $userMomments = $this->user->momments()->latest()->get();
            $firendsMomments = [];
            /* $allFriends = Auth::user()->firends;
            foreach ($allMomments as $frndMomment) {
                $momment = ["user" => $frndMomment->user, "momments" => $userMomments];
                array_push($firendsMomments, $momment);
            } */

            return view('home', ["userMomments" => $userMomments]);
        }
        return redirect("/startup");
    }

    public function startup()
    {
        if (Auth::user()->profile->startup_skip) {
            return redirect("/");
        }
        return view('startup');
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('profile');
        } else if ($request->isMethod('put')) {
            $user = $request->user();
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)]
            ]);
            $user->name = $request->input('name');
            if ($request->has('password') && $request->input('password')) {
                $request->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
                $user->password = Hash::make($request->input('password'));
            }
            if ($request->has('image') && $request->input('image')) {
                $user->deleteImage();
                try {
                    $image_parts = explode(";base64,", $request->input('image'));
                    $image_type = explode("image/", $image_parts[0])[1];
                    $image_base64 = base64_decode($image_parts[1]);

                    $fileName = str_replace(' ', '-', round(microtime(true) * 1000) . $user->name . '.' . $image_type);
                    $imageFullPath = public_path() . "/storage/images/users/" . $fileName;
                    file_put_contents($imageFullPath, $image_base64);

                    $user->image = "/storage/images/users/" . $fileName;
                } catch (Exception $e) {
                    return redirect('/profile')->with("error", "Image not able to upload");
                }
            }
            $user->save();
            return redirect('/profile')->with("message", "Profile update successfuly");
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Image;
use DB;
use Hash;
use RealRashid\SweetAlert\Facades\Alert;



class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            if (session('errorForm')) {
                $html = "<ul style='list-style: none;'>";
                foreach (session('errorForm') as $error) {
                    $html .= "<li>$error[0]</li>";
                }
                $html .= "</ul>";

                Alert::html('Error during the creation!', $html, 'error');
            }

            return $next($request);
        });
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function getProfile()
    {
        return view('admin.dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        #Validations
        $request->validate([
            'nama'    => 'required',
            'username'     => 'required',
            'email' => 'required|email',
        ]);

        try {
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Update Sukses');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Profile Update Gagal');
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $valid = validator($request->only('current_pw', 'new_pw', 'confirm_pw'), [
                'current_pw' => 'required|string|min:6',
                'new_pw' => 'required|string|min:6|different:current_pw',
                'confirm_pw' => 'required_with:new_pw|same:new_pw|string|min:6',
            ], [
                'confirm_pw.required_with' => 'Confirm password is required.'
            ]);

            if ($valid->fails()) {
                return back()->with('error', 'Update Password Gagal');
            }
            if (Hash::check($request->get('current_pw'), Auth::user()->password)) {
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($request->get('new_pw'));
                if ($user->save()) {
                    return back()->with('success', 'Update Password Sukses');
                }
            } else {
                return back()->with('error', 'Password Lama Tidak Ditemukan!!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Coba Lagi');
        }
    }

    public function changeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|max:2048',
        ]);

        $allowExtension = ['jpg', 'jpeg', 'png'];

        if ($request->hasfile('avatar')) {
            $avatar = $request->file('avatar');
            $ext = $avatar->getClientOriginalExtension();
            $check = in_array($ext, $allowExtension);
            if (!$check) {
                return redirect()->back()->with('error', 'Gambar Harus Extensi JPEG, JPG, PNG!!');
            }
        }
        $filename = now()->timestamp . ".{$request->avatar->getClientOriginalName()}";
        Image::make($avatar)->resize(300, 300)->save(public_path('/images/' . $filename));
        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();
        return back()->with('success', 'Gambar Sukses Diupload');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Driver;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Image;
use Illuminate\Support\Facades\File;

class SopirController extends Controller
{
    public function __construct()
    {
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

    public function index(Request $request)
    {
        $data = Driver::all();
        return view('backend.admin.manage-user.driver.index', compact(['data']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required',
            'agama' => 'required',
            'no_telpon' => 'required|min:10|max:15',
            'avatar' => 'required|max:2048',
        ]);

        $input = $request->all();

        $allowExtension = ['jpg', 'jpeg', 'png'];

        if ($request->hasfile('avatar')) {
            $avatar = $request->file('avatar');
            $ext = $avatar->getClientOriginalExtension();
            $filename = now()->timestamp . ".{$request->avatar->getClientOriginalName()}";
            Image::make($avatar)->resize(300, 300)->save(public_path('/images/' . $filename));
            $check = in_array($ext, $allowExtension);
            if (!$check) {
                return redirect()->back()->with('error', 'Gambar Harus Extensi JPEG, JPG, PNG!!');
            }
            $input['avatar'] = "$filename";
        }

        $driver = Driver::create($input);
        $driver->avatar = $filename;

        if ($driver) {
            return redirect()
                ->route('user.driver.index')
                ->with('success', 'Driver Berhasil ditambahkan');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Driver Gagal ditambahkan'
                ]);
        }
    }

    public function show($id)
    {
        $driver = Driver::find($id);
        $umur = (Carbon::parse($driver->tgl_lahir)->age);
        $format_tgl = Carbon::parse($driver->tgl_lahir)->translatedFormat('d F Y');

        return response()->json(['driver' => $driver, 'umur' => $umur, 'format_tgl' => $format_tgl]);
    }

    public function edit($id)
    {
        $driver = Driver::find($id);

        return response()->json(['driver' => $driver]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required',
            'agama' => 'required',
            'no_telpon' => 'required|min:10|max:15',
            'avatar' => 'max:2048',
        ]);

        try {
            $input = $request->all();
            $driver = Driver::find($id);

            $allowExtension = ['jpg', 'jpeg', 'png'];

            if ($request->hasfile('avatar')) {
                $avatar = $request->file('avatar');
                $ext = $avatar->getClientOriginalExtension();
                $filename = now()->timestamp . ".{$request->avatar->getClientOriginalName()}";
                Image::make($avatar)->resize(300, 300)->save(public_path('/images/' . $filename));
                $check = in_array($ext, $allowExtension);

                if (!$check) {
                    return redirect()->back()->with('error', 'Gambar Harus Extensi JPEG, JPG, PNG!!');
                }
                $input['avatar'] = "$filename";
                $data_img = $driver->avatar;

                if ($data_img !== 'default_profile.png') {
                    $file = public_path() . '/images/' . $data_img;

                    if (File::exists($file)) {
                        unlink($file);
                    }
                }
            }
            $driver->update($input);

            return redirect()
                ->route('user.driver.index')
                ->with('success', 'Driver Berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Driver Gagal diupdate'
                ]);
        }
    }

    public function delete($id)
    {
        $data = Driver::find($id);
        $data_img = $data->avatar;

        if ($data_img !== 'default_profile.png') {
            $file = public_path() . '/images/' . $data_img;

            if (File::exists($file)) {
                unlink($file);
            }
        }

        $data->delete();

        return redirect()->route('user.driver.index')
            ->with('success', 'Data Berhasil dihapus');
    }
}

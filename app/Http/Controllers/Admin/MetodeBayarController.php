<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Image;
use Illuminate\Support\Facades\File;
use App\Models\MetodeBayar as mp;

class MetodeBayarController extends Controller
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
        $data = mp::all();

        return view('admin.master-data.metode-pembayaran.index', compact(['data']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'metode_bayar' => 'required',
                'norek' => 'required|digits_between:5,25',
                'atas_nama' => 'required',
                'logo' => 'required|max:10240',
            ]);

            $input = $request->all();

            $allowExtension = ['jpg', 'jpeg', 'png'];

            if ($request->hasfile('logo')) {
                $logo_bayar = $request->file('logo');
                $ext = $logo_bayar->getClientOriginalExtension();
                $filename = now()->timestamp . ".{$request->logo->getClientOriginalName()}";
                Image::make($logo_bayar)->resize(500, 300)->save(public_path('/images/' . $filename));

                $check = in_array($ext, $allowExtension);

                if (!$check) {
                    return redirect()->back()->with('error', 'Gambar Harus Extensi JPEG, JPG, PNG!!');
                }
                $input['logo'] = "$filename";
            }

            $metode = mp::create($input);
            $metode->logo = $filename;

            return redirect()->route('metodepb.index')
                ->with('success', 'Metode Pembayaran Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Metode Pembayaran Gagal ditambahkan'
                ]);
        }
    }

    public function edit($id)
    {
        $metode = mp::find($id);

        return response()->json(['metode' => $metode]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'metode_bayar' => 'required',
            'norek' => 'required|digits_between:5,25',
            'atas_nama' => 'required',
            'logo' => 'required_without|max:10240',
        ]);

        try {
            $input = $request->all();
            $metode = mp::find($id);

            $allowExtension = ['jpg', 'jpeg', 'png'];

            if ($request->hasfile('logo')) {
                $logo_metode = $request->file('logo');
                $ext = $logo_metode->getClientOriginalExtension();
                $filename = now()->timestamp . ".{$request->logo->getClientOriginalName()}";
                Image::make($logo_metode)->resize(450, 300)->save(public_path('/images/' . $filename));

                $check = in_array($ext, $allowExtension);

                if (!$check) {
                    return redirect()->back()->with('error', 'Gambar Harus Extensi JPEG, JPG, PNG!!');
                }
                $input['logo'] = "$filename";
                $data_img = $metode->logo;

                if ($data_img !== 'default-pembayaran.png') {
                    $file = public_path() . '/images/' . $data_img;

                    if (File::exists($file)) {
                        unlink($file);
                    }
                }
            }

            $metode->update($input);

            return redirect()->route('metodepb.index')
                ->with('success', 'Metode Pembayaran Berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Metode Pembayaran Gagal diupdate'
                ]);
        }
    }

    public function delete($id)
    {
        $data = mp::find($id);
        $data_img = $data->logo;

        if ($data_img !== 'default-pembayaran.png') {
            $file = public_path() . '/images/' . $data_img;

            if (File::exists($file)) {
                unlink($file);
            }
        }

        $data->delete();

        return redirect()->route('metodepb.index')
            ->with('success', 'Metode Pembayaran Berhasil dihapus');
    }
}

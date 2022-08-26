<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use DB;
use App\Models\Truk as truk;
use App\Models\Driver;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Image;
use Illuminate\Support\Facades\File;

class TruckController extends Controller
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
        $data = DB::table('tb_truck')
            ->select('tb_truck.*', 'tb_driver.nama as nama_driver')
            ->leftJoin('tb_driver', 'tb_driver.id', '=', 'tb_truck.driver')
            ->get();

        $data_driver = Driver::all();

        return view('admin.master-data.truck.index', compact(['data', 'data_driver']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'no_plat' => 'required',
                'jenis_truck' => 'required',
                'merek_truck' => 'required',
                'tahun_buat' => 'required|min:0|max:4',
                'warna' => 'required',
                'dimensi' => 'required',
                'volume' => 'required',
                'beban_maks' => 'required',
                'img_truck' => 'required|max:10240',
            ]);

            $input = $request->all();

            $allowExtension = ['jpg', 'jpeg', 'png'];

            if ($request->hasfile('img_truck')) {
                $img_truck = $request->file('img_truck');
                $ext = $img_truck->getClientOriginalExtension();
                $filename = now()->timestamp . ".{$request->img_truck->getClientOriginalName()}";
                Image::make($img_truck)->resize(500, 500)->save(public_path('/images/' . $filename));

                $check = in_array($ext, $allowExtension);

                if (!$check) {
                    return redirect()->back()->with('error', 'Gambar Harus Extensi JPEG, JPG, PNG!!');
                }
                $input['img_truck'] = "$filename";
            }

            $truk = truk::create($input);
            $truk->img_truck = $filename;

            return redirect()->route('truk.index')
                ->with('success', 'Truk Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Truk Gagal ditambahkan'
                ]);
        }
    }

    public function edit($id)
    {
        $truk = truk::find($id);

        return response()->json(['truk' => $truk]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'no_plat' => 'required',
            'jenis_truck' => 'required',
            'merek_truck' => 'required',
            'tahun_buat' => 'required|min:0|max:4',
            'warna' => 'required',
            'dimensi' => 'required',
            'volume' => 'required',
            'beban_maks' => 'required',
            'img_truck' => 'required_without|max:10240',
        ]);

        try {
            $input = $request->all();
            $truck = truk::find($id);

            $allowExtension = ['jpg', 'jpeg', 'png'];

            if ($request->hasfile('img_truck')) {
                $img_truck = $request->file('img_truck');
                $ext = $img_truck->getClientOriginalExtension();
                $filename = now()->timestamp . ".{$request->img_truck->getClientOriginalName()}";
                Image::make($img_truck)->resize(450, 300)->save(public_path('/images/' . $filename));

                $check = in_array($ext, $allowExtension);

                if (!$check) {
                    return redirect()->back()->with('error', 'Gambar Harus Extensi JPEG, JPG, PNG!!');
                }
                $input['img_truck'] = "$filename";
                $data_img = $truck->img_truck;

                if ($data_img !== 'default_img.png') {
                    $file = public_path() . '/images/' . $data_img;

                    if (File::exists($file)) {
                        unlink($file);
                    }
                }
            }

            $truck->update($input);
            return redirect()->route('truk.index')
                ->with('success', 'Truk Berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Truk Gagal diupdate'
                ]);
        }
    }

    public function show($id)
    {
        $truk = DB::table('tb_truck')
            ->select('tb_truck.*', 'tb_driver.nama as nama_driver')
            ->leftJoin('tb_driver', 'tb_driver.id', '=', 'tb_truck.driver')
            ->where('tb_truck.id', $id)
            ->first();
        return response()->json(['truk' => $truk]);
    }

    public function updateDriver($id_truk, $id_driver)
    {
        try {
            DB::beginTransaction();

            DB::table('tb_truck')
                ->where('tb_truck.id', $id_truk)
                ->update(['driver' => $id_driver]);

            DB::commit();
            return redirect()->route('truk.index')
                ->with('success', 'Driver Truk Berhasil diupdate');
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
        $data = truk::find($id);
        $data_img = $data->img_truck;

        if ($data_img !== 'default_img.png') {
            $file = public_path() . '/images/' . $data_img;

            if (File::exists($file)) {
                unlink($file);
            }
        }

        $data->delete();

        return redirect()->route('truk.index')
            ->with('success', 'Data Berhasil dihapus');
    }
}

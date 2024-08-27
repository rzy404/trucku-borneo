<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use DB;
use App\Models\Truk as truk;
use App\Models\JenisTruk as jenis;
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
        $data = DB::table('tb_truk')
            ->select(
                'tb_truk.*',
                'tb_jenis_truk.jenis_truk',
                'tb_jenis_truk.dimensi',
                'tb_jenis_truk.volume',
                'tb_jenis_truk.beban_maks',
                'tb_jenis_truk.biaya',
                'tb_driver.nama as nama_driver'
            )
            ->leftJoin('tb_jenis_truk', 'tb_jenis_truk.id', '=', 'tb_truk.jenis_truk')
            ->leftJoin('tb_driver', 'tb_driver.id', '=', 'tb_truk.driver')
            ->get();
        $data_driver = Driver::all();
        $data_jenisTruk = jenis::all();

        return view('backend.admin.master-data.truck.index', compact(['data', 'data_driver', 'data_jenisTruk']))
            ->with('i', ($request->input('page', 1) - 1) * 5)
            ->with('s', ($request->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'no_plat' => 'required',
                'jenis_truk' => 'required',
                'merek_truck' => 'required',
                'tahun_buat' => 'required|min:0|max:4',
                'warna' => 'required',
                'img_truck' => 'required|max:10240',
            ]);

            $input = $request->all();

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
            }

            $truk = truk::create($input);
            $truk->img_truck = $filename;

            return redirect()->route('truk.index')
                ->with('success', 'Truk Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withError('Truk Gagal ditambahkan')
                ->withInput();
        }
    }

    public function storeJenis(Request $request)
    {
        try {
            $this->validate($request, [
                'jenis_truk' => 'required|regex:(JBORNEO)',
                'dimensi' => 'required',
                'volume' => 'required',
                'beban_maks' => 'required',
                'biaya' => 'required|min:0|max:20',
            ]);

            $input = $request->all();
            jenis::create($input);

            return redirect()->route('truk.index')
                ->with('success', 'Jenis Truk Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withError('Jenis Truk Gagal ditambahkan')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $truk = DB::table('tb_truk')
            ->select(
                'tb_truk.*',
                'tb_jenis_truk.jenis_truk as nama_jenis',
                'tb_driver.nama as nama_driver'
            )
            ->leftJoin('tb_jenis_truk', 'tb_jenis_truk.id', '=', 'tb_truk.jenis_truk')
            ->leftJoin('tb_driver', 'tb_driver.id', '=', 'tb_truk.driver')
            ->where('tb_truk.id', $id)
            ->first();

        return response()->json(['truk' => $truk]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'no_plat' => 'required',
            'jenis_truk' => 'required',
            'tahun_buat' => 'required|min:0|max:4',
            'warna' => 'required',
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
        $truk = DB::table('tb_truk')
            ->select(
                'tb_truk.*',
                'tb_jenis_truk.jenis_truk',
                'tb_jenis_truk.dimensi',
                'tb_jenis_truk.volume',
                'tb_jenis_truk.beban_maks',
                'tb_driver.nama as nama_driver'
            )
            ->leftJoin('tb_jenis_truk', 'tb_jenis_truk.id', '=', 'tb_truk.jenis_truk')
            ->leftJoin('tb_driver', 'tb_driver.id', '=', 'tb_truk.driver')
            ->where('tb_truk.id', $id)
            ->first();
        return response()->json(['truk' => $truk]);
    }

    public function showJenis($id)
    {
        $jenis = jenis::find($id);
        return response()->json([
            'jenis' => $jenis
        ]);
    }

    public function updateDriver(Request $request,  $id_truk)
    {
        try {
            $id_driver = $request->input('driver');

            truk::where('id', $id_truk)->update(['driver' => $id_driver]);

            return redirect()->route('truk.index')
                ->with('success', 'Driver Truk Berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withError('Driver Truk Gagal diupdate')
                ->withInput();
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

    public function deleteJenisTruk($id)
    {
        try {
            $data = jenis::find($id);
            $data->delete();

            return redirect()->route('truk.index')
                ->with('success', 'Data Berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withError('Jenis Truk Gagal dihapus')
                ->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator as genKode;
use App\Models\Electre as configElectre;
use App\Models\Perusahaan as alternatif;

class ConfigDataElectre extends Controller
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

    public function KriteriaIndex(Request $request)
    {
        $data = configElectre::all();
        return view('admin.master-data.kriteria.index', compact(['data']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function KriteriaStore(Request $request)
    {
        try {
            $this->validate($request, [
                'kriteria' => 'required',
                'weight' => 'required|numeric',
            ]);

            $input = [
                'id' => genKode::generate([
                    'table' => 'tb_kriteria',
                    'length' => 3,
                    'prefix' => 'K',
                ]),
                'kriteria' => $request->kriteria,
                'weight' => $request->weight,
            ];
            configElectre::create($input);

            return redirect()->route('kriteria.index')
                ->with('success', 'Kriteria Berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withError('Kriteria Gagal ditambahkan')
                ->withInput();
        }
    }

    public function KriteriaEdit($id)
    {
        $kriteria = configElectre::where('id', $id)->first();

        return response()->json(['kriteria' => $kriteria]);
    }

    public function KriteriaUpdate(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'kriteria' => 'required',
                'weight' => 'required|numeric',
            ]);

            $input = [
                'kriteria' => $request->kriteria,
                'weight' => $request->weight,
            ];
            configElectre::where('id', $id)->update($input);

            return redirect()->route('kriteria.index')
                ->with('success', 'Kriteria Berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withError('Kriteria Gagal diubah')
                ->withInput();
        }
    }

    public function KriteriaDelete($id)
    {
        try {
            $data = configElectre::find($id);
            $data->delete();

            return redirect()->route('kriteria.index')
                ->with('success', 'Kriteria Berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withError('Kriteria Gagal dihapus')
                ->withInput();
        }
    }

    public function AlternatifIndex(Request $request)
    {
        $dataAlternatif = alternatif::all();
        $dataKriteria = configElectre::all();

        return view('admin.master-data.alternatif.index', compact(['dataAlternatif', 'dataKriteria']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
}

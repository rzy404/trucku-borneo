<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Costumer as cost;
use DB;
use Hash;
use RealRashid\SweetAlert\Facades\Alert;



class CostumerController extends Controller
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
        $data = DB::table('tb_costumer')
            ->select('*')
            ->leftJoin('tb_perusahaan_cost', 'tb_perusahaan_cost.id_perusahaan', '=', 'tb_costumer.perusahaan')
            ->get();

        return view('admin.manage-user.costumer.index', compact(['data']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email|unique:tb_costumer,email',
            'password' => 'required|same:confirm-password',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $cost = cost::create($input);

        if ($cost) {
            return redirect()
                ->route('user.cost.index')
                ->with('success', 'Costumer Berhasil ditambahkan');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Costumer Gagal ditambahkan'
                ]);
        }
    }

    public function show($id)
    {
        $costu = DB::table('tb_costumer')
            ->select('*')
            ->leftJoin('tb_perusahaan_cost', 'tb_perusahaan_cost.id_perusahaan', '=', 'tb_costumer.perusahaan')
            ->where('tb_costumer.id', $id)
            ->first();

        return response()->json(['cost' => $costu]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $status = cost::findOrFail($id);

            if ($status->status_user == 1) {
                $status->status_user = 0;
            } else {
                $status->status_user = 1;
            }
            $status->save();

            return redirect()->route('user.cost.index')
                ->with('success', 'Status Costumer Berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Status Costumer Gagal diupdate'
                ]);
        }
    }

    public function delete($id)
    {
        cost::find($id)->delete();
        return redirect()->route('user.cost.index')
            ->with('success', 'Data Berhasil dihapus');
    }
}

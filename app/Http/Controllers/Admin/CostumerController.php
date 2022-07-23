<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Costumer as cost;
use DB;
use Hash;
use Carbon\Carbon;
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
        $data = cost::all();
        return view('admin.manage-user.costumer.index', compact(['data']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email|unique:tb_user,email',
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
        $costu = cost::find($id);

        return response()->json(['cost' => $costu]);
    }

    public function delete($id)
    {
        cost::find($id)->delete();
        return redirect()->route('user.cost.index')
            ->with('success', 'Data Berhasil dihapus');
    }
}

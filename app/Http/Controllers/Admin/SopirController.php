<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Driver;
use DB;
use Hash;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;



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
        return view('admin.manage-user.driver.index', compact(['data']))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
}

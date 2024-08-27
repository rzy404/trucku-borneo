<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function download()
    {
        $path = public_path('file/TrucKu Borneo.apk');
        return response()->download($path);
    }

    public function gantiBahasa(Request $request)
    {
        $bahasa = $request->bahasa;
        if (!is_null($bahasa) && is_string($bahasa)) {
            session()->put('bahasa', $bahasa);
            App::setLocale($bahasa);
        }

        return redirect()->back();
    }

    // public function gantiBahasa(Request $request)
    // {
    //     $bahasa = $request->bahasa;
    //     try {
    //         if (!is_null($bahasa) && is_string($bahasa)) {
    //             session()->put('bahasa', $bahasa);
    //             App::setLocale($bahasa);
    //         }
    //         return redirect()->back();
    //     } catch (\Throwable $th) {
    //         return redirect()->back();
    //     }
    // }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function rekapPenugasan()
    {
        $param['pageTitle'] = "Rekap Penugasan";
        return view('penugasan/rekap-penugasan',$param);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Penugasan;

use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function rekapPenugasan(Request $request)
    {
        $param['pageTitle'] = "Rekap Penugasan";
        if($request->get('dari')){
            $param['data'] = Penugasan::select('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan',\DB::raw("min(wp.tanggal) as tanggal_mulai,max(wp.tanggal) as tanggal_selesai,min(wp.waktu_mulai) as waktu_mulai,max(wp.waktu_selesai) as waktu_selesai"))
            ->from('penugasan as p')
            ->join('jenis_kegiatan as jp','p.id_jenis_kegiatan','jp.id')
            ->join('waktu_penugasan as wp','p.id','wp.id_penugasan')->whereBetween('wp.tanggal', [$request->get('dari'),$request->get('sampai')])
            ->groupBy('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan')
            ->orderBy('p.id')            
            ->paginate(10);
        }

        return view('penugasan/rekap-penugasan',$param);
    }
}

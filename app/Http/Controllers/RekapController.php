<?php

namespace App\Http\Controllers;
use App\Models\Penugasan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function penugasanAnggota(Request $request)
    {
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');
        $param['pageTitle'] = "Rekap Anggota Penugasan";
        $param['data'] = DB::table('detail_anggota as da')
                            ->join('anggota as a','a.id','da.id_anggota')                    
                            ->select('a.nama', 'a.nip', DB::raw('COUNT(da.id_anggota) as total'))
                            ->groupBy('a.nama')
                            ->groupBy('a.nip')
                            // ->whereBetween('created_at', [$dari, $sampai])
                            ->get();
        // ddd($param['data']);
        return view('penugasan/rekap-anggota',$param);
    }

    public function getTotalAnggota(Request $request)
    {
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');
        $data = DB::table('detail_anggota as da')
                            ->join('anggota as a','a.id','da.id_anggota')                    
                            ->select('a.nama', 'a.nip', DB::raw('COUNT(da.id_anggota) as total'))
                            ->groupBy('a.nama')
                            ->groupBy('a.nip')
                            ->whereBetween('da.created_at', [$dari." 00:00:00", $sampai." 23:59:59"])
                            ->orderBy('total', 'desc')     
                            ->get();
        echo json_encode($data);
    }
}

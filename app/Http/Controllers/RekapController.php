<?php

namespace App\Http\Controllers;
use App\Models\Penugasan;
use App\Models\WaktuPenugasan;

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
            ->join('waktu_penugasan as wp','p.id','wp.id_penugasan')
            ->whereBetween('wp.tanggal', [$request->get('dari'),$request->get('sampai')])
            ->groupBy('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan')
            ->orderBy('p.id')
            ->paginate(10);

        }

        return view('penugasan/rekap-penugasan',$param);
    }

    public function penugasanAnggota(Request $request)
    {
        $param['pageTitle'] = "Rekap Anggota Penugasan";
        if($request->get('dari')){
            $param['data'] = \DB::table('detail_anggota as da')
                                ->join('anggota as a','a.id','da.id_anggota')
                                ->select('a.nama', 'a.nip', \DB::raw('COUNT(da.id_anggota) as total'))
                                ->groupBy('a.nama','a.nip')
                                ->where('da.status','Anggota')
                                ->whereBetween('da.created_at', [$request->get('dari')." 00:00:00", $request->get('sampai')." 23:59:59"])
                                ->orderBy('total', 'desc')
                                ->get();
        }
        return view('penugasan/rekap-anggota',$param);
    }

    public function getTotalAnggota(Request $request)
    {
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');
        $data = \DB::table('detail_anggota as da')
                            ->join('anggota as a','a.id','da.id_anggota')
                            ->select('a.nama', 'a.nip', \DB::raw('COUNT(da.id_anggota) as total'))
                            ->groupBy('a.nama', 'a.nip')
                            ->whereBetween('da.created_at', [$dari." 00:00:00", $sampai." 23:59:59"])
                            ->orderBy('total', 'desc')
                            ->get();
        echo json_encode($data);
    }

    public function baganPenugasan(Request $request)
    {
        $param['pageTitle'] = "Bagan Penugasan";
        if($request->get('tanggal')){
            $tanggal = $request->tanggal;
            $param['data'] = Penugasan::from('penugasan as p')
            ->select('p.id','p.nama_kegiatan')
            ->with('waktu_penugasan')
            ->with('waktu_penugasan.detailAnggota')
            ->with('waktu_penugasan.detailAnggota.anggota')
            ->join('waktu_penugasan','p.id','waktu_penugasan.id_penugasan')
            ->where('waktu_penugasan.tanggal', $tanggal)
            ->groupBy('p.id')
            ->orderBy('p.id')->get()->toArray();
            $param['waktu_penugasan'] = WaktuPenugasan::with('detailAnggota')->with('detailAnggota.anggota')->with('penugasan')->with('penugasan.jenis_kegiatan')->where('tanggal',$tanggal)->get()->toArray();
            // echo "<pre>";
            // print_r($param['waktu_penugasan']);
            // echo "</pre>";
            $param['count'] = count($param['data']);
            $param['row'] = ceil($param['count']/6);
            $bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            $slice = explode('-',$tanggal);
            $param['text_tanggal'] = $slice[2]." ".$bulan[(int)$slice[1]]." ".$slice[0];

            return view('penugasan/bagan-penugasan',$param);
        }else{
            return view('penugasan/filter-bagan-penugasan',$param);
        }
    }
}

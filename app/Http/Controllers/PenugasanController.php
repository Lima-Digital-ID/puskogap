<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenugasanRequest;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Penugasan;
use App\Models\WaktuPenugasan;
use App\Models\DetailAnggota;
use App\Models\JenisKegiatan;
use \App\Models\Jabatan;
use \App\Models\KompetensiKhusus;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PenugasanController extends Controller
{
    private $param;
    private $whatsapp_api_url = 'http://127.0.0.1:8000/send-message';

    public function __construct()
    {
        $this->param['pageIcon'] = 'feather icon-briefcase';
        $this->param['parentMenu'] = '/penugasan';
        $this->param['current'] = 'Penugasan';
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Penugasan';
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('penugasan.create');

        try {
            $keyword = $request->get('keyword');
            $status = $request->get('status');
            // $getPenugasan = Penugasan::with('jenis_kegiatan')->orderBy('id');
            $getPenugasan = Penugasan::select('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan',\DB::raw("min(wp.tanggal) as tanggal_mulai,max(wp.tanggal) as tanggal_selesai,min(wp.waktu_mulai) as waktu_mulai,max(wp.waktu_selesai) as waktu_selesai"))->from('penugasan as p')->join('jenis_kegiatan as jp','p.id_jenis_kegiatan','jp.id')->join('waktu_penugasan as wp','p.id','wp.id_penugasan');
            if(auth()->user()->level=='Anggota'){
                $getPenugasan->leftJoin('detail_anggota as da','wp.id','da.id_waktu_penugasan')
                ->where('da.id_anggota', auth()->user()->id_anggota);
            }
            $getPenugasan->groupBy('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan')
            ->orderBy('p.id');

            if ($status) {
                $getPenugasan->where('p.status', $status);
            }
            if ($keyword) {
                $getPenugasan->where('nama_kegiatan', 'LIKE', "%{$keyword}%");
                $getPenugasan->orWhere('lokasi', 'LIKE', "%{$keyword}%");
            }

            $this->param['data'] = $getPenugasan->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('penugasan.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['jabatan'] = Jabatan::get();
        $this->param['kompetensi'] = KompetensiKhusus::get();
        $this->param['unitkerja'] = UnitKerja::get();

        $this->param['allJen'] = JenisKegiatan::get();
        $this->param['pageTitle'] = 'Tambah Penugasan';

        return \view('penugasan.create', $this->param);
    }
    function hari($hari){
        switch ($hari) {
            case '1':
                return 'Monday';
            break;
            case '2':
                return 'Tuesday';
            break;
            case '3':
                return 'Wednesday';
            break;
            case '4':
                return 'Thursday';
            break;
            case '5':
                return 'Friday';
            break;
            case '6':
                return 'Saturday';
            break;
            case '7':
                return 'Sunday';
            break;
        }
    }
    public function anggotaFree($tanggal,$dari,$sampai,$filter="")
    {
        if(isset($filter['id_kompetensi_khusus'])){
            $komptensi = $filter['id_kompetensi_khusus'];
            unset($filter['id_kompetensi_khusus']);
        }

        $anggotaFree = Anggota::from('anggota as a')
                            ->select(
                                'a.id',
                                'a.nama',
                            );
                            // ->where('level','Anggota');
                            if($filter!=""){
                                $anggotaFree = $anggotaFree->where($filter);
                            }
                            if(isset($komptensi) && $komptensi!=''){
                                $anggotaFree = $anggotaFree->whereIn('a.id',function($query) use($komptensi){
                                    $query->select('id_anggota')
                                            ->from('detail_kompetensi_anggotas')
                                            ->where('id_kompetensi',$komptensi)
                                            ->get();
                                });
                            }
                            $anggotaFree = $anggotaFree->whereNotIn('a.id',function($query) use ($tanggal,$dari,$sampai) {
                                $query->select('da.id_anggota')
                                        ->from('detail_anggota as da')
                                        ->join('waktu_penugasan as wp','da.id_waktu_penugasan','wp.id')
                                        ->join('penugasan as p', 'wp.id_penugasan', 'p.id')
                                        ->whereRaw("(p.status = 'Rencana' or p.status = 'Pelaksanaan') and ((wp.tanggal = '$tanggal' and (wp.waktu_mulai <= '$dari:59' or wp.waktu_mulai <= '$sampai:59')) and (wp.tanggal = '$tanggal' and (wp.waktu_selesai >= '$dari:59' or wp.waktu_selesai >= '$sampai:59')))")->get();
                            });
        $anggotaFree = $anggotaFree->get();
        return $anggotaFree;
    }

    public function anggotaNotFree($tanggal,$dari,$sampai)
    {
        $anggotaNotFree = \DB::table('detail_anggota as da')->select('a.id','a.nama','p.nama_kegiatan')
                                        ->join('anggota as a', 'da.id_anggota', 'a.id')
                                        ->join('waktu_penugasan as wp','da.id_waktu_penugasan','wp.id')
                                        ->join('penugasan as p', 'wp.id_penugasan', 'p.id')
                                        // ->where('a.level','Anggota')
                                        ->whereRaw("(p.status = 'Rencana' or p.status = 'Pelaksanaan') and ((wp.tanggal = '$tanggal' and (wp.waktu_mulai <= '$dari:59' or wp.waktu_mulai <= '$sampai:59')) and (wp.tanggal = '$tanggal' and (wp.waktu_selesai >= '$dari:59' or wp.waktu_selesai >= '$sampai:59')))")
                                        ->get();
        return $anggotaNotFree;
    }

    public function getAnggota()
    {
        if(isset($_GET['id_jabatan'])){
            $filter = [];
            if($_GET['id_jabatan']!=''){
                $filter['id_jabatan'] = $_GET['id_jabatan'];
            }
            if($_GET['id_unit_kerja']!=''){
                $filter['id_unit_kerja'] = $_GET['id_unit_kerja'];
            }
            if($_GET['id_kompetensi_khusus']!=''){
                $filter['id_kompetensi_khusus'] = $_GET['id_kompetensi_khusus'];
            }
        }
        else{
            $filter = "";
        }
        $data = array(
            'free' => $this->anggotaFree($_GET['tanggal'],$_GET['dari'],$_GET['sampai'],$filter),
            'tugas' => $this->anggotaNotFree($_GET['tanggal'],$_GET['dari'],$_GET['sampai'])
        );
        echo json_encode($data);
    }
    public function cekAnggota()
    {
        $this->param['pageTitle'] = 'Cek Anggota Bertugas dan Tidak';

        return \view('penugasan.cek-anggota', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenugasanRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $penugasan = new Penugasan;

            $uploadPath = 'upload/lampiran/';
            $scanLampiran = $validated['lampiran'];
            $newScanLampiran = time().'_'.$scanLampiran->getClientOriginalName();

            $penugasan->nama_kegiatan = $validated['nama_kegiatan'];
            $penugasan->id_jenis_kegiatan = $validated['id_jenis_kegiatan'];
            $penugasan->lokasi = $validated['lokasi'];
            $penugasan->tamu_vvip = $validated['tamu_vvip'];
            $penugasan->penyelenggara = $validated['penyelenggara'];
            $penugasan->penanggung_jawab = $validated['penanggung_jawab'];
            $penugasan->lampiran = $newScanLampiran;
            $penugasan->status = $validated['status'];
            $penugasan->keterangan = $validated['keterangan'];
            $penugasan->save();
            
            foreach ($request->tanggal as $key => $value) {
                $waktuPenugasan = new WaktuPenugasan;
                $waktuPenugasan->id_penugasan = $penugasan->id;
                $waktuPenugasan->tanggal = $request->get('tanggal')[$key];
                $waktuPenugasan->waktu_mulai = $request->get('waktu_mulai')[$key];
                $waktuPenugasan->waktu_selesai = $request->get('waktu_selesai')[$key];
                $waktuPenugasan->biaya = $request->get('biaya')[$key];
                $waktuPenugasan->jumlah_roda_4 = $request->get('jumlah_roda_4')[$key];
                $waktuPenugasan->jumlah_roda_2 = $request->get('jumlah_roda_2')[$key];
                $waktuPenugasan->poc = $request->get('poc')[$key];
                $waktuPenugasan->jumlah_ht = $request->get('jumlah_ht')[$key];
                $waktuPenugasan->jumlah_peserta = $request->get('jumlah_peserta')[$key];
                $waktuPenugasan->save();
                
                foreach ($request->get('id_user')[$key] as $i => $v) {
                    $anggota =  new DetailAnggota;
                    $anggota->id_anggota = $v;
                    $anggota->id_waktu_penugasan = $waktuPenugasan->id;
                    $anggota->status = 'Anggota';
                    $anggota->save();
                }
                
                $ketua =  new DetailAnggota;
                $ketua->id_anggota = $request->get('ketua')[$key];
                $ketua->id_waktu_penugasan = $waktuPenugasan->id;
                $ketua->status = 'Kepala';
                $ketua->save();
            }

            DB::commit();
            // $scanLampiran->move($uploadPath,$newScanLampiran);
            /* Send Whatsapp Message */
            // $message = "Jangan lupa saksikan acara ".$request->nama_kegiatan." pada ".$validated['waktu_mulai']." hingga ".$validated['waktu_selesai']." bertempatan di ".$validated['lokasi'].".";
            // for ($i=0; $i < count($arrUser); $i++) {
            //     $user = User::find($arrUser[$i]);
            //     if($user && isset($user->phone)) {
            //         $response = Http::post($this->whatsapp_api_url, [
            //             'number' => $user->phone,
            //             'message' => $message,
            //         ]);
            //         return $response;
            //     }
            // }
            /* End Send Whatsapp Message */

            return response()->json(['type' => 'success','msg' => 'Data Berhasil Disimpan']);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['type' => 'error','msg' => 'Terjadi kesalahan.'. $e]);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['type' => 'error','msg' => 'Terjadi kesalahan pada database.'.$e]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Penugasan::findOrFail($id);
            $detail = \DB::table('detail_anggota')
                            ->where('id_penugasan',$data->id);
            $waktu = \DB::table('waktu_penugasan')
                    ->where('id_penugasan',$data->id);
            $lampiran = 'upload/lampiran/'.$data->lampiran;
            if($data->lampiran != '' && $data->lampiran != null){
                unlink($lampiran);
                $data->delete();
                $detail->delete();
                $waktu->delete();
            }else{
                $data->delete();
                $detail->delete();
                $waktu->delete();
            }
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.'.$e);
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('penugasan.index')->withStatus('Data berhasil dihapus.');
    }
    public function jadwal()
    {
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = '';
        $this->param['pageTitle'] = 'Jadwal';
        $getPenugasan = \DB::table('waktu_penugasan as wp')
                        ->select('wp.id','wp.id_penugasan',"nama_kegiatan","tanggal","waktu_mulai","waktu_selesai")
                        ->join('penugasan as p',"wp.id_penugasan","p.id");
                        if(auth()->user()->level=='Anggota'){
                            $getPenugasan = $getPenugasan->leftJoin('detail_anggota as da','wp.id','da.id_waktu_penugasan')
                            ->where('da.id_anggota', auth()->user()->id_anggota);
                        }
                        $getPenugasan = $getPenugasan->groupBy('wp.id','wp.id_penugasan',"nama_kegiatan","tanggal","waktu_mulai","waktu_selesai")->get();
        $this->param['penugasan'] = $getPenugasan;
        return \view('penugasan.jadwal', $this->param);
    }
    public function detail()
    {
        $id = $_GET['id'];
        $data['general'] = Penugasan::from('penugasan as p')->select('p.id','p.nama_kegiatan','p.lokasi','j.jenis_kegiatan','p.tamu_vvip','penyelenggara','penanggung_jawab','p.status','p.keterangan',\DB::raw("min(wp.tanggal) as tanggal_mulai,max(wp.tanggal) as tanggal_selesai,min(wp.waktu_mulai) as waktu_mulai,max(wp.waktu_selesai) as waktu_selesai"))->join('jenis_kegiatan as j','p.id_jenis_kegiatan','j.id')->join('waktu_penugasan as wp','p.id','wp.id_penugasan')->where('p.id',$id)->groupBy('p.id','p.nama_kegiatan','p.lokasi','j.jenis_kegiatan','p.tamu_vvip','penyelenggara','penanggung_jawab','p.status','p.keterangan')->first();

        $waktuPenugasan = WaktuPenugasan::where('id_penugasan',$id);
        if(isset($_GET['id_waktu_penugasan'])){
            $waktuPenugasan = $waktuPenugasan->where('id',$_GET['id_waktu_penugasan']);
        }
        $waktuPenugasan = $waktuPenugasan->orderBy('tanggal','asc')->orderBy('waktu_mulai','asc')->get();

        $arr = [];
        foreach ($waktuPenugasan as $key => $value) {
            $anggota = \DB::table('detail_anggota as da')->select('a.nama','da.status')->join('anggota as a','da.id_anggota','a.id')->where('da.id_waktu_penugasan',$value->id)->get();
            $arr[$key]['waktu'] = $value;
            $arr[$key]['anggota'] = $anggota;
        }
        $data['detail'] = $arr;
        echo json_encode($data);
    }

    public function baganPenugasan()
    {
        return \view('penugasan.bagan');
    }
}

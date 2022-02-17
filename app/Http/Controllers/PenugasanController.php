<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenugasanRequest;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Penugasan;
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
                $getPenugasan->leftJoin('detail_anggota as da','da.id_penugasan','p.id')
                ->where('da.id_anggota', auth()->user()->id_anggota);
            }
            $getPenugasan->groupBy('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan')
            ->orderBy('p.id');

            if ($status) {
                $getPenugasan->where('p.status', $status);
            }
            if ($keyword) {
                $getPenugasan->where('penugasan', 'LIKE', "%{$keyword}%");
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
        $anggotaFree = Anggota::from('anggota as a')
                            ->select(
                                'a.id',
                                'a.nama',
                            );
                            // ->where('level','Anggota');
                            if($filter!=""){
                                $anggotaFree = $anggotaFree->where($filter);
                            }
                            $anggotaFree = $anggotaFree->whereNotIn('a.id',function($query) use ($tanggal,$dari,$sampai) {
                                $query->select('da.id_anggota')
                                        ->from('detail_anggota as da')
                                        ->join('penugasan as p', 'da.id_penugasan', 'p.id')
                                        ->join('waktu_penugasan as wp','p.id','wp.id_penugasan')
                                        ->whereRaw("(p.status = 'Rencana' or p.status = 'Pelaksanaan') and ((wp.tanggal = '$tanggal' and (wp.waktu_mulai <= '$dari:59' or wp.waktu_mulai <= '$sampai:59')) and (wp.tanggal = '$tanggal' and (wp.waktu_selesai >= '$dari:59' or wp.waktu_selesai >= '$sampai:59')))")->get();
                            });
        $anggotaFree = $anggotaFree->get();
        return $anggotaFree;
    }

    public function anggotaNotFree($tanggal,$dari,$sampai)
    {
        $anggotaNotFree = \DB::table('detail_anggota as da')->select('a.id','a.nama','p.nama_kegiatan')
                                        ->join('anggota as a', 'da.id_anggota', 'a.id')
                                        ->join('penugasan as p', 'da.id_penugasan', 'p.id')
                                        ->join('waktu_penugasan as wp','p.id','wp.id_penugasan')
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
    public function store(PenugasanRequest $request, Request $input)
    {
        $validated = $request->validated();
        DB::beginTransaction();        
        try {
            $arrUser = $request->input('id_user');

            $penugasan = new Penugasan();

            $uploadPath = 'upload/lampiran/';
            $scanLampiran = $validated['lampiran'];
            $newScanLampiran = time().'_'.$scanLampiran->getClientOriginalName();

            $penugasan->nama_kegiatan = $validated['nama_kegiatan'];
            $penugasan->id_jenis_kegiatan = $validated['id_jenis_kegiatan'];
            $penugasan->waktu_mulai = $validated['waktu_mulai'];
            $penugasan->waktu_selesai = $validated['waktu_selesai'];
            $penugasan->lokasi = $validated['lokasi'];
            $penugasan->tamu_vvip = $validated['tamu_vvip'];
            $penugasan->biaya = $validated['biaya'];
            $penugasan->jumlah_roda_4 = $validated['jumlah_roda_4'];
            $penugasan->jumlah_roda_2 = $validated['jumlah_roda_2'];
            $penugasan->poc = $validated['poc'];
            $penugasan->jumlah_ht = $validated['jumlah_ht'];
            $penugasan->penyelenggara = $validated['penyelenggara'];
            $penugasan->jumlah_peserta = $validated['jumlah_peserta'];
            $penugasan->penanggung_jawab = $validated['penanggung_jawab'];
            $penugasan->lampiran = $newScanLampiran;
            $penugasan->status = $validated['status'];
            $penugasan->keterangan = $validated['keterangan'];
            $penugasan->model_penugasan = $validated['model_kegiatan'];
            $penugasan->save();

            if($validated['model_kegiatan']=='1'){
                DB::table('waktu_penugasan')->insert([
                    'id_penugasan' => $penugasan->id,
                    'is_dari' => $validated['tanggal_mulai'],
                    'is_sampai' => $validated['tanggal_selesai'],
                    'is_tanggal' => 0,
                    'is_hari' => 0,
                    ]);
                }
            else if($validated['model_kegiatan']=='2'){
                foreach($validated['is_mingguan'] as $key => $value){
                    DB::table('waktu_penugasan')->insert([
                        'id_penugasan' => $penugasan->id,
                        'is_hari' => $value,
                        'is_dari' =>'0000-00-00 00:00',
                        'is_sampai' => '0000-00-00 00:00',
                        'is_tanggal' => 0,
                        ]);
                    }
            }
            else if($validated['model_kegiatan']=='3'){
                $ex = explode(',',$validated['is_tanggal']);
                foreach ($ex as $key => $value) {
                    DB::table('waktu_penugasan')->insert([
                        'id_penugasan' => $penugasan->id,
                        'is_tanggal' => $value,
                        'is_hari' => 0,
                        'is_dari' =>'0000-00-00 00:00',
                        'is_sampai' => '0000-00-00 00:00',
                    ]);
                }
            }

            for ($i=0; $i < count($arrUser); $i++) { 
                DB::table('detail_anggota')->insert(
                    array(
                        'id_penugasan' => $penugasan->id,
                        'id_user' => $arrUser[$i],
                        'status' => 'Anggota'
                    )
                );
            }
            DB::table('detail_anggota',[
                'id_penugasan' => $penugasan->id,
                'id_user' => $input->input('ketua'),
                'status' => "Kepala",
            ]);
            foreach($input->input('id_user') as $key => $value)
            {
                if($value!=$input->input('ketua')){
                    DB::table('detail_anggota')->insert(
                        array(
                            'id_penugasan' => $penugasan->id,
                            'id_user' => $value,
                            'status' => 'Anggota'
                            )
                    );   
                }
            }
            DB::commit();  
            $scanLampiran->move($uploadPath,$newScanLampiran);
            /* Send Whatsapp Message */
            $message = "Jangan lupa saksikan acara ".$request->nama_kegiatan." pada ".$validated['waktu_mulai']." hingga ".$validated['waktu_selesai']." bertempatan di ".$validated['lokasi'].".";
            for ($i=0; $i < count($arrUser); $i++) { 
                $user = User::find($arrUser[$i]);
                if($user && isset($user->phone)) {
                    $response = Http::post($this->whatsapp_api_url, [
                        'number' => $user->phone,
                        'message' => $message,
                    ]);        
                    return $response;
                }
            }
            /* End Send Whatsapp Message */

            return redirect()->route('penugasan.index')->withStatus('Data berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollback();            
            return back()->withError('Terjadi kesalahan.'. $e);
        } catch (QueryException $e) {
            DB::rollback();            
            return back()->withError('Terjadi kesalahan pada database.'.$e);
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
            $lampiran = 'upload/lampiran/'.$data->lampiran;
            if($data->lampiran != '' && $data->lampiran != null){
                unlink($lampiran);
                $data->delete();
            }else{
                $data->delete();
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
                        ->select('wp.id',"nama_kegiatan","tanggal","waktu_mulai","waktu_selesai")
                        ->join('penugasan as p',"wp.id_penugasan","p.id");
                        if(auth()->user()->level=='Anggota'){
                            $getPenugasan = $getPenugasan->leftJoin('detail_anggota as da','da.id_penugasan','p.id')
                            ->where('da.id_anggota', auth()->user()->id_anggota);
                        }
                        $getPenugasan = $getPenugasan->groupBy('wp.id',"nama_kegiatan","tanggal","waktu_mulai","waktu_selesai")->get();
        $this->param['penugasan'] = $getPenugasan;
        return \view('penugasan.jadwal', $this->param);
    }
}

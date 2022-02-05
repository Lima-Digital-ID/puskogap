<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenugasanRequest;
use App\Models\User;
use App\Models\Penugasan;
use App\Models\JenisKegiatan;
use \App\Models\Jabatan;
use \App\Models\KompetensiKhusus;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PenugasanController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Penugasan';
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
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('penugasan.create');

        try {
            $keyword = $request->get('keyword');
            // $getPenugasan = Penugasan::orderBy('id');
            $getPenugasan = Penugasan::with('jenis_kegiatan')->orderBy('id');

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
        $this->param['btnText'] = 'List Penugasan Kerja';
        $this->param['btnLink'] = route('penugasan.index');
        $this->param['allJen'] = JenisKegiatan::get();

        return \view('penugasan.create', $this->param);
    }

    public function anggotaFree($waktu_mulai,$waktu_selesai,$filter="")
    {
        $anggotaFree = User::from('users as u')
                            ->select(
                                'u.id',
                                'u.nama',
                            )
                            ->where('level','Anggota')
                            ->whereNotIn('u.id',function($query) use ($waktu_mulai, $waktu_selesai) {
                                $query->select('da.id_user')
                                        ->from('detail_anggota as da')
                                        ->join('penugasan as p', 'da.id_penugasan', 'p.id')
                                        ->whereRaw("(waktu_mulai <= '$waktu_mulai' or waktu_mulai <= '$waktu_selesai') and (waktu_selesai >= '$waktu_mulai' or waktu_selesai >= '$waktu_selesai')")
                                        ->get();
                            });
                        if($filter!="" && count($filter)!=0){
                            $anggotaFree = $anggotaFree->where($filter);
                        }
        $anggotaFree = $anggotaFree->get();
        return $anggotaFree;
    }

    public function anggotaNotFree($waktu_mulai,$waktu_selesai)
    {
        $anggotaNotFree = \DB::table('detail_anggota as da')->select('u.id','u.nama','p.nama_kegiatan')
                                        ->join('users as u', 'da.id_user', 'u.id')
                                        ->join('penugasan as p', 'da.id_penugasan', 'p.id')
                                        ->where('u.level','Anggota')
                                        ->whereRaw("(waktu_mulai <= '$waktu_mulai' or waktu_mulai <= '$waktu_selesai') and (waktu_selesai >= '$waktu_mulai' or waktu_selesai >= '$waktu_selesai')")
                                        ->get();
        return $anggotaNotFree;
    }
    public function filterAnggotaFree()
    {
        $waktu_mulai = $_GET['waktu_mulai'];
        $waktu_selesai = $_GET['waktu_selesai'];
        $id_jabatan = $_GET['id_jabatan'];
        $id_unit_kerja = $_GET['id_unit_kerja'];
        $id_kompetensi_khusus = $_GET['id_kompetensi_khusus'];
        $filter = [];
        if($id_jabatan!=''){
            $filter['id_jabatan'] = $id_jabatan;
        }
        else if($id_unit_kerja!=''){
            $filter['id_unit_kerja'] = $id_unit_kerja;
        }
        else if($id_kompetensi_khusus!=''){
            $filter['id_kompetensi_khusus'] = $id_kompetensi_khusus;
        }
        $anggota = $this->anggotaFree($waktu_mulai,$waktu_selesai,$filter);
        echo json_encode($anggota);
    }

    public function getAnggota()
    {
        $waktu_mulai = $_GET['waktu_mulai'];
        $waktu_selesai = $_GET['waktu_selesai'];
        
        $data = array(
            'free' => $this->anggotaFree($waktu_mulai,$waktu_selesai),
            'tugas' => $this->anggotaNotFree($waktu_mulai,$waktu_selesai)
        );
        echo json_encode($data);
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
            $penugasan->save();
            $scanLampiran->move($uploadPath,$newScanLampiran);
            foreach($request->input('id_user') as $key => $value)
            {
                DB::table('detail_anggota')->insert(
                    array(
                        'id_penugasan' => $penugasan->id,
                        'id_user' => $value,
                        'status' => 'Anggota'
                    )
                );   
            }
            DB::table('detail_anggota',[
                'id_penugasan' => $penugasan->id,
                'id_user' => $request->input('ketua'),
                'status' => "Ketua",
            ]);
            DB::commit();  
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
}

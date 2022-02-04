<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenugasanRequest;
use App\Models\User;
use App\Models\Penugasan;
use App\Models\JenisKegiatan;
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
        $this->param['btnText'] = 'List Penugasan Kerja';
        $this->param['btnLink'] = route('penugasan.index');
        $this->param['allJen'] = JenisKegiatan::get();

        return \view('penugasan.create', $this->param);
    }

    public function getAnggota($waktu_mulai, $waktu_selesai)
    {
        $waktu_mulai = $waktu_mulai.' 15:51:00';
        $waktu_selesai = $waktu_selesai.' 15:51:59';
        // $anggotaFree = DB::table('detail_anggota AS da')
        //                 ->select('u.nama')
        //                 ->join('users as u','u.id','da.id_user')
        //                 ->whereNotIn('u.id', function($query) use ($waktu_mulai, $waktu_selesai){
        //                     $query->select('p.id')->from('penugasan as p')
        //                     ->where('p.waktu_mulai', '>=', $waktu_mulai)
        //                     ->where('p.waktu_selesai', '<=', $waktu_selesai);
        //                 })
        //                 ->orderBy('u.id', 'asc')
        //                 ->get();
    //    $detailAnggota = DB::table('detail_anggota')->pluck('id_penugasan','id_user')->all();
        // $anggotaNotFree = DB::table('penugasan as p')
        //                     ->select(
        //                         'p.id',
        //                         'p.waktu_mulai',
        //                         'p.waktu_selesai',
        //                         // 'u.nama',
        //                     )
        //                     // ->whereNotIn('id', $detailAnggota)
        //                     ->whereIn('p.id',function($query) {
        //                         $query->select('id_penugasan')
        //                                 ->from('detail_anggota')
        //                                 ->get();
        //                     })
        //                     // ->join('detail_anggota as da','da.id_penugasan', 'p.id')
        //                     // ->join('users as u','u.id', 'da.id_user')
        //                     // ->where('waktu_mulai', '>=', $waktu_mulai)
        //                     // ->where('waktu_selesai', '<=', $waktu_selesai)
        //                     ->orderBy('id')
        //                     ->get();
        // $anggotaNotFree = DB::table('penugasan as p')
        //                     ->select(
        //                         'p.id',
        //                         'p.waktu_mulai',
        //                         'p.waktu_selesai',
        //                         // 'u.nama',
        //                     )
        //                     // ->whereNotIn('id', $detailAnggota)
        //                     ->whereIn('p.id',function($query) {
        //                         $query->select('id_penugasan')
        //                                 ->from('detail_anggota')
        //                                 ->get();
        //                     })
        //                     // ->join('detail_anggota as da','da.id_penugasan', 'p.id')
        //                     // ->join('users as u','u.id', 'da.id_user')
        //                     // ->where('waktu_mulai', '>=', $waktu_mulai)
        //                     // ->where('waktu_selesai', '<=', $waktu_selesai)
        //                     ->orderBy('id')
        //                     ->get();
        $anggotaNotFree = DB::table('detail_anggota as da')
                            ->select(
                                'u.id',
                                'u.nama',
                                'da.id_penugasan',
                            )
                            ->whereIn('da.id_penugasan',function($query) use ($waktu_mulai, $waktu_selesai) {
                                $query->select('id')
                                        ->from('penugasan')
                                        ->where('waktu_mulai', '>=', $waktu_mulai)
                                        ->where('waktu_selesai', '<=', $waktu_selesai)
                                        ->get();
                            })
                            ->join('users as u','u.id', 'da.id_user')
                            ->orderBy('da.id')
                            ->get();

        $anggotaFree = User::from('users as u')
                            ->select(
                                'u.id',
                                'u.nama',
                                'da.id_penugasan',
                            )
                            ->leftJoin('detail_anggota as da', 'da.id_user', 'u.id')
                            ->leftJoin('penugasan as p', 'p.id', '!=', 'da.id_penugasan')
                            ->whereNotIn('da.id_penugasan',function($query) use ($waktu_mulai, $waktu_selesai) {
                                $query->select('id')
                                        ->from('penugasan')
                                        ->where('waktu_mulai', '>=', $waktu_mulai)
                                        ->where('waktu_selesai', '<=', $waktu_selesai)
                                        ->get();
                            })
                            ->orWhereNull('da.id_penugasan')
                            ->get();
        // ddd($anggotaNotFree);
        $data = array(
            // 'waktu_mulai' => $waktu_mulai,
            // 'waktu_selesai' => $waktu_selesai,
            'free' => $anggotaFree,
            'tugas' => $anggotaNotFree
        );
        // return $data;
        // return json_encode($data);
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
            if($penugasan->save()){
                $scanLampiran->move($uploadPath,$newScanLampiran);
                // foreach($request->input('ketua') as $key => $value)
                // {
                //     $lastId = Penugasan::max('id');
                //     DB::table('detail_anggota')->insert(
                //         array('id_penugasan' => '2',
                //                 'id_user' => $request->input('anggota_not_free')[$key],
                //                 'status' => 'Anggota')
                //     );   
                // }
                foreach ($request->get('ketua') as $key) {
                    $detail[] = [
                        'id_penugasan' => '1',
                        'id_user' => $key,
                        'status' => "Anggota",
                    ];
                }
                dd($detail);
                return redirect()->route('penugasan.index')->withStatus('Data berhasil disimpan.');
            }
            
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.'. $e);
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.'.$e);
        }

        return redirect()->route('penugasan.index')->withStatus('Data berhasil disimpan.');
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

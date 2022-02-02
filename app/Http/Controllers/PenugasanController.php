<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenugasanRequest;
use App\Models\Penugasan;
use App\Models\JenisKegiatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

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
            $getPenugasan = Penugasan::orderBy('id');

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
            $penugasan->lampiran = $validated['lampiran'];
            $penugasan->status = $validated['status'];
            $penugasan->keterangan = $validated['keterangan'];
            ddd($penugasan);
            $penugasan->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.'. $e);
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.'.$e);
        }

        return redirect()->route('unit-kerja.index')->withStatus('Data berhasil disimpan.');
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
        //
    }
}

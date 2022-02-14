<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnggotaRequest;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use \App\Models\User;
use \App\Models\Golongan;
use \App\Models\Jabatan;
use \App\Models\KompetensiKhusus;
use App\Models\UnitKerja;

class AnggotaController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Anggota';
        $this->param['pageIcon'] = 'feather icon-users';
        $this->param['parentMenu'] = 'anggota';
        $this->param['current'] = 'Anggota';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('anggota.create');

        try {
            $keyword = $request->get('keyword');
            $getAnggota = Anggota::orderBy('id');
            // ddd($getAnggota);

            if ($keyword) {
                $getAnggota->where('anggota', 'LIKE', "%{$keyword}%");
            }

            $this->param['anggota'] = $getAnggota->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('anggota.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['btnText'] = 'List Anggota';
        $this->param['btnLink'] = route('anggota.index');
        $this->param['allGol'] = Golongan::get();
        $this->param['allJab'] = Jabatan::get();
        $this->param['allKhs'] = KompetensiKhusus::get();
        $this->param['allUnt'] = UnitKerja::get();

        return \view('anggota.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnggotaRequest $request)
    {
        
        $validated = $request->validated();
        try {
            $anggota = new Anggota;
            $anggota->nama = $validated['name'];
            $anggota->id_golongan = $request->get('id_golongan');
            $anggota->id_jabatan = $request->get('id_jabatan');
            $anggota->id_kompetensi_khusus = $request->get('id_kompetensi_khusus');
            $anggota->id_unit_kerja = $request->get('id_unit_kerja');
            $anggota->jenis_pegawai = $request->get('jenis_pegawai');
            $anggota->jenis_kelamin = $request->get('jenis_kelamin');
            $anggota->nip = $request->get('nip');
            ddd($anggota);
            // $anggota->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.' . $e->getMessage());
        }

        return redirect()->route('anggota.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['data'] = Anggota::findOrFail($id);
        $this->param['allGol'] = Golongan::get();
        $this->param['allJab'] = Jabatan::get();
        $this->param['allKhs'] = KompetensiKhusus::get();
        $this->param['allUnt'] = UnitKerja::get();
        $this->param['btnText'] = 'List Anggota';
        $this->param['btnLink'] = route('anggota.index');

        return view('anggota.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnggotaRequest $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $namaUnique = $request['name'] != null && $request['name'] != $anggota->nama ? '|unique:anggota,nama' : '';

        $valid = $request->validate(
            [
                'name' => 'required|max:191'.$namaUnique,
            ],
            [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Maksimal jumlah karakter 191.',
            ]
        );

        $validated = $valid;
        // $validated = $request->validated();
        
        try{
            $anggota->nama = $validated['name'];
            $anggota->id_golongan = $request->get('id_golongan');
            $anggota->id_jabatan = $request->get('id_jabatan');
            $anggota->id_kompetensi_khusus = $request->get('id_kompetensi_khusus');
            $anggota->id_unit_kerja = $request->get('id_unit_kerja');
            $anggota->jenis_pegawai = $request->get('jenis_pegawai');
            $anggota->jenis_kelamin = $request->get('jenis_kelamin');
            $anggota->nip = $request->get('nip');
            // ddd($anggota);
            $anggota->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.' . $e->getMessage());
        }

        return redirect()->route('anggota.index')->withStatus('Data berhasil disimpan.');
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
            $anggota = Anggota::findOrFail($id);
            $anggota->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('anggota.index')->withStatus('Data berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\JenisKegiatanRequest;
use App\Models\JenisKegiatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class JenisKegiatanController extends Controller
{
    public function __construct()
    {
        $this->param['pageTitle'] = 'Jenis Kegiatan';
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/jenis-kegiatan';
        $this->param['current'] = 'Jenis Kegiatan';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('jenis-kegiatan.create');

        try {
            $keyword = $request->get('keyword');
            $getData = JenisKegiatan::orderBy('id');

            if ($keyword) {
                $getData->where('jenis_kegiatan', 'LIKE', "%{$keyword}%");
            }

            $this->param['data'] = $getData->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan pada database: ' . $e->getMessage());
        }

        return \view('jenis-kegiatan.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['btnText'] = 'List Jenis Kegiatan';
        $this->param['btnLink'] = route('jenis-kegiatan.index');

        return \view('jenis-kegiatan.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JenisKegiatanRequest $request)
    {
        $validated = $request->validated();
        try {
            $jenisKegiatan = new JenisKegiatan;
            $jenisKegiatan->kode = $validated['kode'];
            $jenisKegiatan->jenis_kegiatan = $validated['jenis_kegiatan'];
            $jenisKegiatan->jenis = $validated['jenis'];
            $jenisKegiatan->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('jenis-kegiatan.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['data'] = JenisKegiatan::find($id);
        $this->param['btnText'] = 'List Jenis Kegiatan';
        $this->param['btnLink'] = route('jenis-kegiatan.index');

        return view('jenis-kegiatan.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JenisKegiatanRequest $request, $id)
    {
        $data = JenisKegiatan::findOrFail($id);

        $unitUnique = $request['jenis_kegiatan'] != null && $request['jenis_kegiatan'] != $data->jenis_kegiatan ? '|unique:jenis_kegiatan,jenis_kegiatan' : '';

        $request = $request->validate(
            [
                'kode' => 'required|max:30',
                'jenis_kegiatan' => 'required|max:191'.$unitUnique,
                'jenis' => 'required',
            ],
            [
            'kode.required' => 'Kode harus diisi.',
            'kode.max' => 'Maksimal jumlah karakter 30.',
            'kode.unique' => 'Nama telah digunakan.',
            'jenis_kegiatan.required' => 'Jenis Kegiatan harus diisi.',
            'jenis_kegiatan.max' => 'Maksimal jumlah karakter 191.',
            'jenis.required' => 'Jenis harus diisi.',
            ]
        );

        $validated = $request;

        try {
            $data->kode = $validated['kode'];
            $data->jenis_kegiatan = $validated['jenis_kegiatan'];
            $data->jenis = $validated['jenis'];

            $data->save();
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('jenis-kegiatan.index')->withStatus('Data berhasil diperbarui.');
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
            $data = JenisKegiatan::findOrFail($id);
            $data->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('jenis-kegiatan.index')->withStatus('Data berhasil dihapus.');
    }
}

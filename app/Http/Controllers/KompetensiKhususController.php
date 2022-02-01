<?php

namespace App\Http\Controllers;

use App\Http\Requests\KompetensiKhususRequest;
use App\Models\KompetensiKhusus;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class KompetensiKhususController extends Controller
{
    public function __construct()
    {
        $this->param['pageTitle'] = 'Kompetensi Khusus';
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/kompetensi-khusus';
        $this->param['current'] = 'Kompetensi Khusus';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('kompetensi-khusus.create');

        try {
            $keyword = $request->get('keyword');
            $getData = KompetensiKhusus::orderBy('id');

            if ($keyword) {
                $getData->where('kompetensi_khusus', 'LIKE', "%{$keyword}%");
            }

            $this->param['data'] = $getData->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan pada database: ' . $e->getMessage());
        }

        return \view('kompetensi-khusus.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['btnText'] = 'List Kompetensi Khusus';
        $this->param['btnLink'] = route('kompetensi-khusus.index');

        return \view('kompetensi-khusus.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KompetensiKhususRequest $request)
    {
        $validated = $request->validated();
        try {
            $kompetensiKhusus = new KompetensiKhusus;
            $kompetensiKhusus->kode = $validated['kode'];
            $kompetensiKhusus->kompetensi_khusus = $validated['kompetensi_khusus'];
            $kompetensiKhusus->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('kompetensi-khusus.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['data'] = KompetensiKhusus::find($id);
        $this->param['btnText'] = 'List Kompetensi Khusus';
        $this->param['btnLink'] = route('kompetensi-khusus.index');

        return view('kompetensi-khusus.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KompetensiKhususRequest $request, $id)
    {
        $data = KompetensiKhusus::findOrFail($id);

        $unitUnique = $request['kompetensi_khusus'] != null && $request['kompetensi_khusus'] != $data->kompetensi_khusus ? '|unique:kompetensi_khusus,kompetensi_khusus' : '';

        $request = $request->validate(
            [
                'kode' => 'required|max:30',
                'kompetensi_khusus' => 'required|max:191'.$unitUnique,
            ],
            [
            'kode.required' => 'Kode harus diisi.',
            'kode.max' => 'Maksimal jumlah karakter 30.',
            'kode.unique' => 'Nama telah digunakan.',
            'kompetensi_khusus.required' => 'Unit kerja harus diisi.',
            'kompetensi_khusus.max' => 'Maksimal jumlah karakter 191.'
            ]
        );

        $validated = $request;

        try {
            $data->kode = $validated['kode'];
            $data->kompetensi_khusus = $validated['kompetensi_khusus'];

            $data->save();
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('kompetensi-khusus.index')->withStatus('Data berhasil diperbarui.');
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
            $data = KompetensiKhusus::findOrFail($id);
            $data->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('kompetensi-khusus.index')->withStatus('Data berhasil dihapus.');
    }
}

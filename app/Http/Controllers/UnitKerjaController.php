<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitKerjaRequest;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class UnitKerjaController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/unit-kerja';
        $this->param['current'] = 'Unit Kerja';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Unit Kerja';
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('unit-kerja.create');

        try {
            $keyword = $request->get('keyword');
            $getData = UnitKerja::orderBy('id');

            if ($keyword) {
                $getData->where('unit_kerja', 'LIKE', "%{$keyword}%");
            }

            $this->param['data'] = $getData->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan pada database: ' . $e->getMessage());
        }

        return \view('unit-kerja.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Unit Kerja';
        $this->param['btnText'] = 'List Unit Kerja';
        $this->param['btnLink'] = route('unit-kerja.index');

        return \view('unit-kerja.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitKerjaRequest $request)
    {
        $validated = $request->validated();
        try {
            $unitKerja = new UnitKerja;
            $unitKerja->kode = $validated['kode'];
            $unitKerja->unit_kerja = $validated['unit_kerja'];
            $unitKerja->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
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
        $this->param['pageTitle'] = 'Edit Unit Kerja';
        $this->param['data'] = UnitKerja::find($id);
        $this->param['btnText'] = 'List Unit Kerja';
        $this->param['btnLink'] = route('unit-kerja.index');

        return view('unit-kerja.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitKerjaRequest $request, $id)
    {
        $data = UnitKerja::findOrFail($id);

        $kodeUnique = $request['kode'] != null && $request['kode'] != $data->kode ? '|unique:unit_kerja,kode' : '';
        $unitUnique = $request['unit_kerja'] != null && $request['unit_kerja'] != $data->unit_kerja ? '|unique:unit_kerja,unit_kerja' : '';

        $request = $request->validate(
            [
                'kode' => 'required|max:30'.$kodeUnique,
                'unit_kerja' => 'required|max:191'.$unitUnique,
            ],
            [
            'kode.required' => 'Kode harus diisi.',
            'kode.max' => 'Maksimal jumlah karakter 30.',
            'kode.unique' => 'Kode telah digunakan.',
            'unit_kerja.required' => 'Unit kerja harus diisi.',
            'unit_kerja.max' => 'Maksimal jumlah karakter 191.'
            ]
        );

        $validated = $request;

        try {
            $data->kode = $validated['kode'];
            $data->unit_kerja = $validated['unit_kerja'];

            $data->save();
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('unit-kerja.index')->withStatus('Data berhasil diperbarui.');
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
            $data = UnitKerja::findOrFail($id);
            $data->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('unit-kerja.index')->withStatus('Data berhasil dihapus.');
    }
}

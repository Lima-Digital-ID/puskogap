<?php

namespace App\Http\Controllers;

use App\Http\Requests\JabatanRequest;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class JabatanController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/jabatan';
        $this->param['current'] = 'Jabatan';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Jabatan';
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('jabatan.create');

        try {
            $keyword = $request->get('keyword');
            $getGolongan = Jabatan::orderBy('id');

            if ($keyword) {
                $getGolongan->where('jabatan', 'LIKE', "%{$keyword}%");
            }

            $this->param['data'] = $getGolongan->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('jabatan.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Jabatan';
        $this->param['btnText'] = 'List Jabatan';
        $this->param['btnLink'] = route('jabatan.index');

        return \view('jabatan.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JabatanRequest $request)
    {
        $request = $request->validate(
            [
                'jabatan' => 'required|max:191|unique:jabatan,jabatan',
            ],
            [
                'jabatan.required' => 'Jabatan harus diisi.', 
                'jabatan.max' => 'Maksimal jumlah karakter 191.', 
                'jabatan.unique' => 'Nama telah digunakan.', 
            ]
        );
        $validated = $request;
        try {
            $jabatan = new Jabatan;
            $jabatan->jabatan = $validated['jabatan'];
            $jabatan->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('jabatan.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['pageTitle'] = 'Edit Jabatan';
        $this->param['data'] = Jabatan::find($id);
        $this->param['btnText'] = 'List Jabatan';
        $this->param['btnLink'] = route('jabatan.index');

        return view('jabatan.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JabatanRequest $request, $id)
    {
        $data = Jabatan::findOrFail($id);

        $jabatanUnique = $request['jabatan'] != null && $request['jabatan'] != $data->jabatan ? '|unique:jabatan,jabatan' : '';

        $request = $request->validate(
            [
                'jabatan' => 'required|max:191'.$jabatanUnique,
            ],
            [
                'jabatan.required' => 'Jabatan harus diisi.', 
                'jabatan.max' => 'Maksimal jumlah karakter 191.', 
                'jabatan.unique' => 'Nama telah digunakan.', 
            ]
        );

        $validated = $request;

        try {
            $data->jabatan = $validated['jabatan'];

            $data->save();
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('jabatan.index')->withStatus('Data berhasil diperbarui.');
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
            $golongan = Jabatan::findOrFail($id);
            $golongan->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('jabatan.index')->withStatus('Data berhasil dihapus.');
    }
}

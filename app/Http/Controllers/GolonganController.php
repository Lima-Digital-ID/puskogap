<?php

namespace App\Http\Controllers;

use App\Http\Requests\GolonganRequest;
use App\Models\Golongan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class GolonganController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/golongan';
        $this->param['current'] = 'Golongan';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List Golongan';
        $this->param['btnText'] = 'Tambah';
        $this->param['btnLink'] = route('golongan.create');

        try {
            $keyword = $request->get('keyword');
            $getGolongan = Golongan::orderBy('id');
            // ddd($getGolongan);

            if ($keyword) {
                $getGolongan->where('golongan', 'LIKE', "%{$keyword}%");
            }

            $this->param['data'] = $getGolongan->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('golongan.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah Golongan';
        $this->param['btnText'] = 'List golongan';
        $this->param['btnLink'] = route('golongan.index');

        return \view('golongan.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GolonganRequest $request)
    {
        $request = $request->validate(
            [
                'pangkat' => 'required|max:100|unique:golongan,pangkat',
            ],
            [
                'pangkat.required' => 'Pangkat harus diisi.', 
                'pangkat.max' => 'Maksimal jumlah karakter 100.', 
                'pangkat.unique' => 'Nama telah digunakan.', 
            ]
        );

        $validated = $request;
        try {
            $golongan = new Golongan;
            $golongan->pangkat = $validated['pangkat'];
            $golongan->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('golongan.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['pageTitle'] = 'Edit Golongan';
        $this->param['data'] = Golongan::find($id);
        $this->param['btnText'] = 'List Golongan';
        $this->param['btnLink'] = route('golongan.index');

        return view('golongan.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GolonganRequest $request, $id)
    {
        $golongan = Golongan::findOrFail($id);
        
        $pangkatUnique = $request['pangkat'] != null && $request['pangkat'] != $golongan->pangkat ? '|unique:golongan,pangkat' : '';

        $request = $request->validate(
            [
                'pangkat' => 'required|max:100'.$pangkatUnique,
            ],
            [
                'pangkat.required' => 'Pangkat harus diisi.', 
                'pangkat.max' => 'Maksimal jumlah karakter 100.', 
                'pangkat.unique' => 'Nama telah digunakan.', 
            ]
        );

        $validated = $request;

        try {
            $golongan->pangkat = $validated['pangkat'];

            $golongan->save();
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('golongan.index')->withStatus('Data berhasil diperbarui.');
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
            $golongan = Golongan::findOrFail($id);
            $golongan->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('golongan.index')->withStatus('Data berhasil dihapus.');
    }
}

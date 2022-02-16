<?php

namespace App\Http\Controllers;

use \App\Http\Requests\StoreRequest;
use App\Models\Anggota;
use \App\Models\User;
use \App\Models\Golongan;
use \App\Models\Jabatan;
use \App\Models\KompetensiKhusus;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageIcon'] = 'feather icon-users';
        $this->param['parentMenu'] = 'user';
        $this->param['current'] = 'User';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List User';
        $this->param['btnText'] = 'Tambah User';
        $this->param['btnLink'] = route('user.create');

        try {
            $keyword = $request->get('keyword');
            $getUsers = User::with('anggota')->orderBy('id', 'ASC');

            if ($keyword) {
                $getUsers->where('name', 'LIKE', "%{$keyword}%")->orWhere('email', 'LIKE', "%{$keyword}%");
            }

            $this->param['user'] = $getUsers->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        return \view('user.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah User';
        $this->param['btnText'] = 'List User';
        $this->param['btnLink'] = route('user.index');
        $this->param['allAng'] = Anggota::get();
        // $this->param['allAng'] = \DB::table('anggota as a')
        //                             ->select(
        //                                 'a.*',
        //                             )
        //                             ->whereNotIn('a.id',function($query){
        //                                 $query->select('id')
        //                                     ->from('users')
        //                                     ->get();
        //                         })->get();
        return \view('user.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = new User;
            $user->id_anggota = $validated['id_anggota'];
            $user->email = $validated['email'];
            $user->username = $validated['username'];
            $user->password = Hash::make('password');
            $user->level = $validated['level'];
            $user->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.' . $e->getMessage());
        }

        return redirect()->route('user.index')->withStatus('Data berhasil disimpan.');
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
        $this->param['pageTitle'] = 'Edit User';
        $this->param['data'] = User::find($id);
        $this->param['allAng'] = Anggota::get();
        $this->param['btnText'] = 'List User';
        $this->param['btnLink'] = route('user.index');

        return view('user.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        try {
            $user = User::find($id);
            $isEmailUnique = $request->get('email') != null && $request->get('email') != $user->email ? '|unique:users,email' : '';
            $isUsernameUnique = $request->get('username') != null && $request->get('username') != $user->username ? '|unique:users,username' : '';

            $requestValid = $request->validate(
                [
                    'id_anggota' => 'required',
                    'email' => 'required|email'.$isEmailUnique,
                    'username' => 'required'.$isUsernameUnique,
                ],
                [
                    'id_anggota.required' => 'Nama harus diisi.',
                    'email.required' => 'Email harus diisi.',
                    'username.required' => 'Username harus diisi.',
                    'email.unique' => 'Email telah digunakan.',
                    'username.unique' => 'Username telah digunakan.',
                ]
            );
            $validated = $requestValid;

            $user->id_anggota = $validated['id_anggota'];
            $user->email = $validated['email'];
            $user->username = $validated['username'];
            $user->level = $request->get('level');
            $user->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan Database.' . $e->getMessage());
        }

        return redirect()->route('user.index')->withStatus('Data berhasil disimpan.');
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
            $user = User::findOrFail($id);
            $user->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('user.index')->withStatus('Data berhasil dihapus.');
    }
}

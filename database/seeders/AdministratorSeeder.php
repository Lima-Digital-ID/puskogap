<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\Models\User;
        $administrator->nama = 'Administrator';
        $administrator->email = 'administrator@gmail.com';
        $administrator->username = 'administrator';
        $administrator->password = \Hash::make('password');
        $administrator->jenis_pegawai = 'ASN';
        $administrator->jenis_kelamin = 'L';
        $administrator->nip = '666';
        $administrator->level = 'Administrator';
        $administrator->save();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Logistyx',
            'alamat' => 'Jl. Dramaga 1234 Bogor',
            'telepon' => '081234779987',
            'tipe_nota' => 1, // kecil
            'diskon' => 0,
            'path_logo' => '/img/logistyx.png',

        ]);
    }
}

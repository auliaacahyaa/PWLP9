<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Mahasiswa_MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai = [
            [
                'mahasiswa_id' => 2141720002,
                'matakuliah_id' => 1,
                'nilai' => 75,
            ],
            [
                'mahasiswa_id' => 2141720002,
                'matakuliah_id' => 2,
                'nilai' => 76,
            ],
            [
                'mahasiswa_id' => 2141720002,
                'matakuliah_id' => 3,
                'nilai' => 84,
            ],
            [
                'mahasiswa_id' => 2141720002,
                'matakuliah_id' => 4,
                'nilai' => 82,
            ],
        ];

        DB::table('mahasiswa_matakuliah')->insert($nilai);
    }
}
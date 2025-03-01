<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'  => 'Aldo',
                'email'  => 'aldotaniel@gmail.com',
                'role_id'  => 1,
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'  => 'Firman',
                'email'  => 'aldo_t_sembiring_x@telkomsel.co.id',
                'role_id'  => 3,
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'  => 'Syahrir',
                'email'  => 'aldo_taniel_sembiring@gmail.com',
                'role_id'  => 2,
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s')
            ],
            [
                'nama'  => 'Rahman',
                'email'  => 'farhansyahputra9901@gmail.com',
                'role_id'  => 3,
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s')
            ],
            [
                'nama'  => 'Fajar',
                'email'  => 'dimasafrizal099@gmail.com',
                'role_id'  => 1,
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('pegawai')->insertBatch($data);
    }
}

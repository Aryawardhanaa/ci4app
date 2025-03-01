<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'kode'    => '20',
                'nama_regional' => 'Sumatera',
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
            [
                'kode'    => '21',
                'nama_regional' => 'Sumbagut',
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
            [
                'kode'    => '22',
                'nama_regional' => 'sumbagsel',
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
            [
                'kode'    => '23',
                'nama_regional' => 'sumbagteng',
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data ke tabel "users" php spark db:seed
        $this->db->table('area')->insertBatch($data);
    }
}

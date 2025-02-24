<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'nama_role'       => 'Staff',
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_role'       => 'Supervisor',
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_role'       => 'Manager',
                'is_deleted' => 0,
                'idt' => date('Y-m-d H:i:s'),
                'udt' => date('Y-m-d H:i:s'),
            ],

        ];

        // Insert data ke tabel "users"
        $this->db->table('role')->insertBatch($data);
    }
}

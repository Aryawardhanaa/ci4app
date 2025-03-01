<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoryAccountSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'code_account'    => '52',
                'desc' => 'Operations and Maintenance'
            ],
            [
                'code_account'    => '53',
                'desc' => 'Personel'
            ],
            [
                'code_account'    => '54',
                'desc' => 'Marketing and Sales'
            ],
            [
                'code_account'    => '55',
                'desc' => 'General and Administrative'
            ],
            [
                'code_account'    => '56',
                'desc' => 'Cost of Service'
            ],
        ];

        // Insert data ke tabel "users" php spark db:seed
        $this->db->table('category_account_2')->insertBatch($data);
    }
}

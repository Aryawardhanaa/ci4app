<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeDataTypeAvailibility extends Migration
{
    public function up()
    {
        //
        $this->forge->modifyColumn('revenue', [
            'availability_m1' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'null'       => true,
            ],
            'availability_m2' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'null'       => true,
            ],
            'availability_m3' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'null'       => true,
            ],
            'availability_m4' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'null'       => true,
            ],
            'availability_m5' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'null'       => true,
            ],
            'availability_m6' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RevenueTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'site_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'site_label' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'regional' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'revenue_m1' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'revenue_m2' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'revenue_m3' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'revenue_m4' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'revenue_m5' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'revenue_m6' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'availability_m1' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'availability_m2' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'availability_m3' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'availability_m4' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'availability_m5' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'availability_m6' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'idt'        => ['type' => 'DATETIME', 'null' => true],
            'udt'        => ['type' => 'DATETIME', 'null' => true],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('revenue');
    }

    public function down()
    {
        //
    }
}

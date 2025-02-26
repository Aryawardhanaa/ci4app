<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'     => true,
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'gaji' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'is_deleted' => ['type' => 'SMALLINT', 'null' => true],
            'idt'        => ['type' => 'DATETIME', 'null' => true],
            'udt'        => ['type' => 'DATETIME', 'null' => true],
            'role_id' => ['type' => 'SMALLINT', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pegawai');
    }


    public function down()
    {
        //php spark make:migration CreateDokumenTable

    }
}

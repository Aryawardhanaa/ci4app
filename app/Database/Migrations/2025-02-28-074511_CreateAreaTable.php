<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAreaTable extends Migration
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
            'kode' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_regional' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],

            'is_deleted' => ['type' => 'SMALLINT', 'null' => true],
            'idt'        => ['type' => 'DATETIME', 'null' => true],
            'udt'        => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('area');
    }

    public function down()
    {
        //
        $this->forge->dropTable('area');
    }
}

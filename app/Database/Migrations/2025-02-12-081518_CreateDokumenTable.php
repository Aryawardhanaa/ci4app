<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'doc_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'upload_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            // 'idt' => [
            //     'type' => 'DATE',
            // ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
            ],

            'is_deleted' => ['type' => 'SMALLINT', 'null' => true],
            'idt'        => ['type' => 'DATETIME', 'null' => true],
            'udt'        => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('documents');
    }

    public function down()
    {
        //
    }
}

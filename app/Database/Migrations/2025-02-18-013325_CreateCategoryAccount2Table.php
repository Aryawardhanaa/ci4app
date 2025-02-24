<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryAccount2Table extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code_account'      => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true], // 1300
            'desc'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // 1300
            'created_at'        => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'        => ['type' => 'TIMESTAMP', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('category_account_2');
    }

    public function down()
    {
        //  php spark migrate:create CreateRevenueTable  php spark migrate:create Revenue
    }
}

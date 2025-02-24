<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExcelsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_dokumen'      => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true], // 1300
            'kategori_dokumen'  => ['type' => 'SMALLINT', 'null' => true], // 22, 21
            'kode_akun_1'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true], // 41023A1
            'kode_akun_2'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true], // 5221106
            'kode_akun_3'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true], // A1BO0244
            'kode_akun_4'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true], // 3OOPA
            'tanggal_dokumen'   => ['type' => 'DATE', 'null' => true], // 2024-07-31
            'periode_dokumen'   => ['type' => 'SMALLINT', 'null' => true], // 7
            'tipe_dokumen'      => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true], // SS
            'total'             => ['type' => 'NUMERIC', 'constraint' => '20,2', 'null' => true], // 4.118.449.114 atau -20.228.130.043
            'periode_awal'      => ['type' => 'DATE', 'null' => true], // 2024-05-01
            'periode_akhir'     => ['type' => 'DATE', 'null' => true], // 2024-05-31
            'created_at'        => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'        => ['type' => 'TIMESTAMP', 'null' => true],
            'total'   => [
                'type'       => 'DECIMAL',
                'constraint' => '16,2', // Maksimal 10 triliun dengan 2 desimal
                'null'       => false,  // Tidak boleh NULL
                'default'    => 0.00,   // Default 0.00
            ], // 4.118.449.114 atau -20.228.130.043
            'month_year'        => ['type' => 'DATE', 'null' => true],
            'is_deleted'        => ['type' => 'SMALLINT', 'null' => true],
            'idt'        => ['type' => 'DATETIME', 'null' => true],
            'udt'        => ['type' => 'DATETIME', 'null' => true]


        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('excel');
    }

    public function down()
    {
        //php spark make:migration RevenueTable
    }
}

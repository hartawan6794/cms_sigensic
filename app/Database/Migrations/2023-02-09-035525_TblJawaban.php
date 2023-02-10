<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblJawaban extends Migration
{
    public function up()
    {
        $fields = [
            'id_jawaban' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
            ],
            'id_soal' => [
                'type' => 'TINYINT',
            ],
            'jawaban_soal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null' => true,
                // 'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                // 'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id_jawaban');
        $this->forge->addForeignKey('id_soal','tbl_soal','id_soal','CASCADE','CASCADE');
        $this->forge->createTable('tbl_jawaban', false);
    }

    public function down()
    {
        //
    }
}

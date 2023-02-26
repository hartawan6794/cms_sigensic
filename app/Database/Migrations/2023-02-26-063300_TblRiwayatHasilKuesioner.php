<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblRiwayatHasilKuesioner extends Migration
{
    public function up()
    {
        $fields = [
            'id_riwayat_hasil' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'SMALLINT',
            ],
            'kondisi' => [
                'type' => 'TINYINT',
                'constraint' => 3,
            ],
            'skor' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'default' => '',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 3,
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
        $this->forge->addPrimaryKey('id_riwayat_hasil');
        $this->forge->addForeignKey('id_user','tbl_user','id_user','CASCADE','CASCADE');
        $this->forge->createTable('tbl_riwayat_hasil_kuesioner', false);
    }

    public function down()
    {
        //
    }
}

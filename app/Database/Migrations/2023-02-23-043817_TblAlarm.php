<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblAlarm extends Migration
{
    public function up()
    {
        $fields = [
            'id_alarm' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'SMALLINT',
            ],
            'id_riwayat_hasil' => [
                'type' => 'TINYINT',
            ],
            'keterangan' => [
                'type' => 'varchar',
                'constraint' => 100,
            ],
            'tgl_alarm' => [
                'type' => 'varchar',
                'constraint' => 100,
            ],
            'jm_alarm' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 3,
            ],
            'waktu_alarm' => [
                'type' => 'TIMESTAMP',
                'null' => true,
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
        $this->forge->addPrimaryKey('id_alarm');
        $this->forge->addForeignKey('id_user', 'tbl_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_riwayat_hasil', 'tbl_riwayat_hasil_kuesioner', 'id_riwayat_hasil', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_alarm', false);
    }

    public function down()
    {
        //
    }
}

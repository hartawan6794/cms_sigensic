<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblSubMateri extends Migration
{
    public function up()
    {
        $fields = [
            'id_sub_materi' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
            ],
            'id_materi' => [
                'type' => 'TINYINT',
            ],
            'judul_sub_materi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'isi_materi' => [
                'type' => 'VARCHAR',
                'constraint' => 8024,
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
        $this->forge->addPrimaryKey('id_sub_materi');
        $this->forge->addForeignKey('id_materi','tbl_materi','id_materi','CASCADE','CASCADE');
        $this->forge->createTable('tbl_sub_materi', false);
    }

    public function down()
    {
        //
    }
}

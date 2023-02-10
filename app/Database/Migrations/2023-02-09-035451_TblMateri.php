<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblMateri extends Migration
{
    public function up()
    {

        $fields = [
            'id_materi' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
            ],
            'judul_materi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'isi_materi' => [
                'type' => 'VARCHAR',
                'constraint' => 1024,
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
        $this->forge->addPrimaryKey('id_materi');
        $this->forge->createTable('tbl_materi', false);
    }

    public function down()
    {
        //
    }
}

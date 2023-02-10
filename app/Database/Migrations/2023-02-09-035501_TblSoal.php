<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblSoal extends Migration
{
    public function up()
    {
        $fields = [
            'id_soal' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
            ],
            'soal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'pilgan_a' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'pilgan_b' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'pilgan_c' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'pilgan_d' => [
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
        $this->forge->addPrimaryKey('id_soal');
        $this->forge->createTable('tbl_soal', false);
    }

    public function down()
    {
        //
    }
}

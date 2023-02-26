<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblReminder extends Migration
{
    public function up()
    {
        $fields = [
            'id_reminder' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'SMALLINT',
            ],
            'judul' => [
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
        $this->forge->addPrimaryKey('id_reminder');
        $this->forge->addForeignKey('id_user','tbl_user','id_user','CASCADE','CASCADE');
        $this->forge->createTable('tbl_reminder', false);
    }

    public function down()
    {
        //
    }
}

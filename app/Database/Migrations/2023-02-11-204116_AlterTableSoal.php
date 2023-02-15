<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableSoal extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('tbl_soal','pilgan_a');
        $this->forge->dropColumn('tbl_soal','pilgan_b');
        $this->forge->dropColumn('tbl_soal','pilgan_c');
        $this->forge->dropColumn('tbl_soal','pilgan_d');
    }

    public function down()
    {
        //
    }
}

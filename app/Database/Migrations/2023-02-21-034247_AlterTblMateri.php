<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTblMateri extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('tbl_materi','isi_materi');
    }

    public function down()
    {
        //
    }
}

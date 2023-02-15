<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\SoalModel;

class SoalApi extends BaseController
{

    public function __construct()
    {
        $this->soal = new SoalModel();
    }

    public function getSoal(){
        $data = $this->soal->select()->findAll();
        if ($data) {
            $response['success'] = true;
            $response['messages'] = "Data berhasil ditemukan";
            $response['data'] = $data;
        } else {
            $response['success'] = false;
            $response['messages'] = "Data tidak ditemukan";
            $response['data'] = $data;
        }
        return $this->response->setJSON($response);
    }
}
?>
<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MateriModel;

class EdukasiApi extends BaseController
{
    public function __construct()
    {
        $this->judul = new MateriModel();
    }

    public function getEdukasi(){
        $response = array();
        $data = $this->judul->select()->findAll();
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
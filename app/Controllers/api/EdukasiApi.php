<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\SubMateriModel;

class EdukasiApi extends BaseController
{
    public function __construct()
    {
        $this->judul = new MateriModel();
        $this->subMateri = new SubMateriModel();
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

    public function getSubEdukasi(){
        $response = array();
        $id_materi = $this->request->getPostGet('id_materi');

        $data = $this->subMateri->select()->where('id_materi',$id_materi)->findAll();
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
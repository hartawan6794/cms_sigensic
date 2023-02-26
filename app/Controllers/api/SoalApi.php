<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\HasilKuesionerModel;
use App\Models\SoalModel;
use App\Models\TblriwayathasilkuesionerModel;

class SoalApi extends BaseController
{

    public function __construct()
    {
        $this->soal = new SoalModel();
        $this->hasilKuesioner = new HasilKuesionerModel();
        $this->riwayatHasilKuesioner = new TblriwayathasilkuesionerModel();
    }

    public function getSoal()
    {
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

    public function checkData()
    {
        $response = array();
        $id_user = $this->request->getPostGet('id_user');
        $data = $this->hasilKuesioner->where('id_user', $id_user)->findAll();
        if ($data) {
            $response['success'] = true;
            $response['messages'] = "Data berhasil ditemukan";
        } else {
            $response['success'] = false;
            $response['messages'] = "Data tidak ditemukan";
        }
        return $this->response->setJSON($response);
    }

    public function tambahHasil()
    {

        $response = array();
        $fields['id_user'] = $this->request->getPostGet('id_user');
        $fields['skor'] = $this->request->getPostGet('skor');
        // $fields['kondisi'] = $fields['skor'] >= 0 && $fields['skor'] <= 13 ? '1' : ($fields['skor'] >= 14 && $fields['skor'] <= 26 ? '2' : ($fields['skor'] >= 27 && $fields['skor'] <= 40 ? '3' : '0'));
        $fields['status'] = 0;

        if ($fields['skor'] >= 0 && $fields['skor'] <= 13) {
            $fields['kondisi'] = 1;
        } elseif ($fields['skor'] >= 14 && $fields['skor'] <= 26) {
            $fields['kondisi'] = 2;
        } else {
            $fields['kondisi'] = 3;
        }

        if ($this->hasilKuesioner->insert($fields)) {

            if ($this->riwayatHasilKuesioner->insert($fields)) {
                $response['success'] = true;
                $response['messages'] = "Berhasil Menambahkan Data";
            }
        } else {

            $response['success'] = false;
            $response['messages'] = "Gagal Menambahkan Data";
        }

        return $this->response->setJSON($response);
    }

    public function updateHasil()
    {
        $response = array();
        $id_user = $this->request->getPostGet('id_user');
        $data = $this->riwayatHasilKuesioner->select()->where([
            'id_user' => $id_user,
            'status' => 0
        ])->findAll();
        $field['status'] = '1';
        if ($this->hasilKuesioner->where('id_user', $id_user)->delete()) {

            if ($this->riwayatHasilKuesioner->update($data[0]->id_riwayat_hasil, $field)) {
                $response['success'] = true;
                $response['messages'] = "Berhasil Mengupdate status";
            }
        } else {

            $response['success'] = false;
            $response['messages'] = "Gagal mengupdate status";
        }


        return $this->response->setJSON($response);
    }
}

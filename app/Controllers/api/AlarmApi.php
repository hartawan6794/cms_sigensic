<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers\Api;

use App\Controllers\BaseController;

use App\Models\AlarmModel;
use App\Models\TblriwayathasilkuesionerModel;
use App\Models\HasilKuesionerModel;

class AlarmApi extends BaseController
{

    // protected $alarmModel;
    // protected $validation;

    public function __construct()
    {
        $this->riwayatHasilKuesioner = new TblriwayathasilkuesionerModel();
        $this->hasilKuesioner = new HasilKuesionerModel();
        $this->alarmModel = new AlarmModel();
    }

    public function add()
    {
        $response = array();

        $fields['id_alarm'] = $this->request->getPostGet('id_alarm');
        $fields['id_user'] = $this->request->getPostGet('id_user');
        $fields['id_riwayat_hasil'] = $this->request->getPostGet('id_riwayat_hasil');
        $fields['keterangan'] = $this->request->getPostGet('keterangan');
        $fields['tgl_alarm'] = $this->request->getPostGet('tgl_alarm');
        $fields['jm_alarm'] = $this->request->getPostGet('jm_alarm');
        $fields['status'] = 0;
        $fields['waktu_alarm'] = date('Y-m-d H:i:s', $this->request->getPostGet('waktu_alarm'));
        $fields['created_at'] = date('Y-m-d H:i:s');

        $data = $this->alarmModel->where([
            'status' => 0,
            'id_user' => $fields['id_user']
        ])->orderBy('waktu_alarm', 'ASC')->findAll();

        if ($this->alarmModel->insert($fields)) {

            if ($data) {
                $response['success'] = true;
                $response['messages'] = "Berhasil menambahkan data";
                $response['insert_id'] = $this->alarmModel->insertID();
                $response['data'] = true;
            } else {

                $response['success'] = true;
                $response['messages'] = "Berhasil menambahkan data";
                $response['insert_id'] = $this->alarmModel->insertID();
                $response['data'] = false;
            }
        } else {

            $response['success'] = false;
            $response['messages'] = "Gagal menambahkan data";
            $response['insert_id'] = $this->alarmModel->insertID();
        }

        return $this->response->setJSON($response);
    }

    public function getAll()
    {
        $response = array();

        $id_user = $this->request->getPostGet('id_user');
        $id_riwayat_hasil = $this->request->getPostGet('id_riwayat_hasil');

        $data = $this->alarmModel->select()->join('tbl_user tu', 'tu.id_user = tbl_alarm.id_user')->where(['tbl_alarm.id_user' => $id_user,
        'id_riwayat_hasil' =>$id_riwayat_hasil])->findAll();

        if ($data) {

            $response['success'] = true;
            $response['messages'] = "Berhasil Mendapatkan data";
            $response['data'] = $data;
        } else {

            $response['success'] = false;
            $response['messages'] = "Gagal Mendapatkan data";
            $response['data'] = $data;
        }

        return $this->response->setJSON($response);
    }

    public function checkAlarm()
    {
        $response = array();

        $id_user = $this->request->getPostGet('id_user');
        $status = $this->request->getPostGet('status');

        $data = $this->alarmModel->select('id_alarm,keterangan,tgl_alarm,jm_alarm,waktu_alarm')->where([
            'status' => $status,
            'id_user' => $id_user
        ])->orderBy('waktu_alarm', 'ASC')->findAll();

        if ($data) {

            $response['success'] = true;
            $response['messages'] = "Berhasil Mendapatkan data";
            $response['data'] = $data;
        } else {

            $response['success'] = false;
            $response['messages'] = "Gagal Mendapatkan data";
            $response['data'] = $data;
        }
        return $this->response->setJSON($response);
    }

    public function updateAlarm()
    {
        $response = array();

        $id_alarm = $this->request->getPostGet('id_alarm');
        $field['status'] = 1;

        if ($this->alarmModel->update($id_alarm, $field)) {

            $response['success'] = true;
            $response['messages'] = "Berhasil mengubah data";
        } else {

            $response['success'] = false;
            $response['messages'] = "Gagal mengubah data";
        }

        return $this->response->setJSON($response);
    }

    public function countData()
    {
        $response = array();
        $id_user = $this->request->getPostGet('id_user');
        $data = $this->riwayatHasilKuesioner->select('id_riwayat_hasil,skor')->where([
            'id_user' => $id_user,
            'status' => 0
        ])->orderBy('created_at', 'ASC')->findAll();
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

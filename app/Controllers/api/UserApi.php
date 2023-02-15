<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserApi extends BaseController
{

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function login()
    {
        $response = array();
        $username = $this->request->getPostGet('username');
        $password = $this->request->getPostGet('password');


        // cek username
        $data = $this->user->where('username', $username)->first();
        if ($data) {
            //cek password
            if ($this->user->checkPassword($password)->first()) {
                $response['success'] = true;
                $response['mesagge'] = "Berhasil login";
                $response['data'] = $data;
            } else {
                $response['success'] = false;
                $response['mesagge'] = "password salah";
                $response['data'] = $data;
            }
        } else {
            $response['success'] = false;
            $response['mesagge'] = "username tidak ditemukan";
            $response['data'] = $data;
        }
        return $this->response->setJSON($response);
    }

    public function register()
    {
        $response = array();

        // $fields['id_user'] = $this->request->getPostGet('id_user');
        $fields['username'] = $this->request->getPostGet('username');
        $fields['nm_lengkap'] = $this->request->getPostGet('nm_lengkap');
        $fields['tanggal_lahir'] = $this->request->getPostGet('tgl_lahir');
        $fields['password'] = md5($this->request->getPostGet('password'));
        $fields['created_at'] = date('Y-m-d H:i:s');

        if ($this->user->insert($fields)) {

            $response['success'] = true;
            $response['messages'] = "Data berhasil ditambah";
        } else {

            $response['success'] = false;
            $response['messages'] = "Data gagal ditambah";
        }

        return $this->response->setJSON($response);
    }
}

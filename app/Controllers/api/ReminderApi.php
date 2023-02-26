<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers\Api;

use App\Controllers\BaseController;

use App\Models\ReminderModel;

class ReminderApi extends BaseController
{

    protected $reminderModel;
    protected $validation;

    public function __construct()
    {
        $this->reminderModel = new ReminderModel();
        $this->validation =  \Config\Services::validation();
    }

    public function getAll()
	{
		$response = array();

        $id_user = $this->request->getPostGet('id_user');

		$result = $this->reminderModel->select()->join('tbl_user tu','tbl_reminder.id_user = tu.id_user','left')->where('tbl_reminder.id_user', $id_user)->findAll();
		
        if ($result) {

            $response['success'] = true;
            $response['messages'] = "Berhasil mendapatkan data reminder";
            $response['data'] = $result;
        } else {

            $response['success'] = false;
            $response['messages'] = "Gagal mendapatkan data reminder";
            $response['data'] = $result;

        }

		return $this->response->setJSON($response);
	}

    public function add()
    {
        $response = array();

        $fields['id_reminder'] = $this->request->getPost('id_reminder');
        $fields['id_user'] = $this->request->getPost('id_user');
        $fields['judul'] = $this->request->getPost('judul');
        $fields['created_at'] = $this->request->getPost('created_at');
        // $fields['updated_at'] = $this->request->getPost('updated_at');

        if ($this->reminderModel->insert($fields)) {

            $response['success'] = true;
            $response['messages'] = lang("Berhasil menambahkan reminder");
        } else {

            $response['success'] = false;
            $response['messages'] = lang("Gagal menambahkan reminder");
        }

        return $this->response->setJSON($response);
    }
}

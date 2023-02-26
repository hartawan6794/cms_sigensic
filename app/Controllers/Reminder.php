<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ReminderModel;

class Reminder extends BaseController
{

	protected $reminderModel;
	protected $validation;

	public function __construct()
	{
		$this->reminderModel = new ReminderModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'reminder',
			'title'     		=> 'Menu Reminder'
		];

		return view('reminder', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->reminderModel->select()->join('tbl_user tu','tbl_reminder.id_user = tu.id_user','left')->findAll();
		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			// $ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_reminder . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("App.edit")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_reminder . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("App.delete")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->nm_lengkap,
				$value->judul,
				$value->created_at,

				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_reminder');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->reminderModel->where('id_reminder', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_reminder'] = $this->request->getPost('id_reminder');
		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['judul'] = $this->request->getPost('judul');
		$fields['created_at'] = $this->request->getPost('created_at');
		// $fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'id_user' => ['label' => 'Nama User', 'rules' => 'required|numeric|min_length[0]|max_length[6]'],
			'judul' => ['label' => 'Judul', 'rules' => 'required|min_length[0]|max_length[255]'],
			'created_at' => ['label' => 'Tanggal Alarm', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->reminderModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("App.insert-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.insert-error");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id_reminder'] = $this->request->getPost('id_reminder');
		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['judul'] = $this->request->getPost('judul');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'id_user' => ['label' => 'Nama User', 'rules' => 'required|numeric|min_length[0]|max_length[6]'],
			'judul' => ['label' => 'Judul', 'rules' => 'required|min_length[0]|max_length[255]'],
			'created_at' => ['label' => 'Tanggal Alarm', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->reminderModel->update($fields['id_reminder'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("App.update-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.update-error");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id_reminder');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->reminderModel->where('id_reminder', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menghapus reminder");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menghapus reminder");
			}
		}

		return $this->response->setJSON($response);
	}
}

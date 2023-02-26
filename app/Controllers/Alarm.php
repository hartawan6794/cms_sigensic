<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\AlarmModel;

class Alarm extends BaseController
{

	protected $alarmModel;
	protected $validation;

	public function __construct()
	{

		$this->alarmModel = new AlarmModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{
		if (session()->get('username')) {

			$data = [
				'controller'    	=> 'alarm',
				'title'     		=> 'Menu Alarm'
			];

			return view('alarm', $data);
		} else {
			return view('login');
		}
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->alarmModel->select()->join('tbl_user tu', 'tu.id_user = tbl_alarm.id_user')->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_alarm . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("App.edit")  . '</a>';
			$ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("App.copy")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_alarm . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("App.delete")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->nm_lengkap,
				$value->tgl_alarm,
				$value->jm_alarm,
				$value->status,
				$value->waktu_alarm,

				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_alarm');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->alarmModel->where('id_alarm', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_alarm'] = $this->request->getPost('id_alarm');
		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['tgl_alarm'] = $this->request->getPost('tgl_alarm');
		$fields['jm_alarm'] = $this->request->getPost('jm_alarm');
		$fields['status'] = $this->request->getPost('status');
		$fields['waktu_alarm'] = $this->request->getPost('waktu_alarm');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'id_user' => ['label' => 'Nama User', 'rules' => 'required|numeric|min_length[0]|max_length[6]'],
			'tgl_alarm' => ['label' => 'Tgl alarm', 'rules' => 'required|min_length[0]|max_length[100]'],
			'jm_alarm' => ['label' => 'Jm alarm', 'rules' => 'required|min_length[0]|max_length[10]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]|max_length[3]'],
			'waktu_alarm' => ['label' => 'Waktu alarm', 'rules' => 'required|valid_date|min_length[0]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->alarmModel->insert($fields)) {

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

		$fields['id_alarm'] = $this->request->getPost('id_alarm');
		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['tgl_alarm'] = $this->request->getPost('tgl_alarm');
		$fields['jm_alarm'] = $this->request->getPost('jm_alarm');
		$fields['status'] = $this->request->getPost('status');
		$fields['waktu_alarm'] = $this->request->getPost('waktu_alarm');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'id_user' => ['label' => 'Nama User', 'rules' => 'required|numeric|min_length[0]|max_length[6]'],
			'tgl_alarm' => ['label' => 'Tgl alarm', 'rules' => 'required|min_length[0]|max_length[100]'],
			'jm_alarm' => ['label' => 'Jm alarm', 'rules' => 'required|min_length[0]|max_length[10]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]|max_length[3]'],
			'waktu_alarm' => ['label' => 'Waktu alarm', 'rules' => 'required|valid_date|min_length[0]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->alarmModel->update($fields['id_alarm'], $fields)) {

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

		$id = $this->request->getPost('id_alarm');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->alarmModel->where('id_alarm', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("App.delete-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.delete-error");
			}
		}

		return $this->response->setJSON($response);
	}
}

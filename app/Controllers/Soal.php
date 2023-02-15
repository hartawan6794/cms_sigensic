<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\SoalModel;

class Soal extends BaseController
{

	protected $soalModel;
	protected $validation;

	public function __construct()
	{
		$this->soalModel = new SoalModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		if (session()->get('isLogin')) {

			$data = [
				'controller'    	=> 'soal',
				'title'     		=> 'Menu Soal'
			];

			return view('soal', $data);
		} else {
			return view('login');
		}
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->soalModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_soal . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			// $ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("App.copy")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_soal . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->soal,
				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_soal');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->soalModel->where('id_soal', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_soal'] = $this->request->getPost('id_soal');
		$fields['soal'] = $this->request->getPost('soal');
		$fields['created_at'] = date("Y-m-d H:i:s");


		$this->validation->setRules([
			'soal' => ['label' => 'Soal', 'rules' => 'required|min_length[0]|max_length[255]'],
		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->soalModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menambahkan soal");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menambahkan soal");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id_soal'] = $this->request->getPost('id_soal');
		$fields['soal'] = $this->request->getPost('soal');
		$fields['updated_at'] = date("Y-m-d H:i:s");


		$this->validation->setRules([
			'soal' => ['label' => 'Soal', 'rules' => 'required|min_length[0]|max_length[255]'],
		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->soalModel->update($fields['id_soal'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil mengubah soal");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal mengubah soal");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id_soal');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->soalModel->where('id_soal', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menghapus soal");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menghapus soal");
			}
		}

		return $this->response->setJSON($response);
	}
}

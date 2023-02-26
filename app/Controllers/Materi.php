<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\MateriModel;

class Materi extends BaseController
{

	protected $materiModel;
	protected $validation;

	public function __construct()
	{
		$this->materiModel = new MateriModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		if (session()->get('isLogin')) {

			$data = [
				'controller'    	=> 'materi',
				'title'     		=> 'Menu Materi'
			];

			return view('materi', $data);
		} else {
			return view('login');
		}
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->materiModel->select()->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_materi . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_materi . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->judul_materi,
				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_materi');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->materiModel->where('id_materi', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_materi'] = $this->request->getPost('id_materi');
		$fields['judul_materi'] = $this->request->getPost('judul_materi');
		$fields['created_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'judul_materi' => ['label' => 'Judul materi', 'rules' => 'required|min_length[0]|max_length[255]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->materiModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil tambah materi");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal tambah Materi");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id_materi'] = $this->request->getPost('id_materi');
		$fields['judul_materi'] = $this->request->getPost('judul_materi');
		$fields['updated_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'judul_materi' => ['label' => 'Judul materi', 'rules' => 'required|min_length[0]|max_length[255]'],
		]);

		if ($this->validation->run($fields) == FALSE) {
			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->materiModel->update($fields['id_materi'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil ubah materi");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal ubah materi");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id_materi');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->materiModel->where('id_materi', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil hapus materi");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal hapus materi");
			}
		}

		return $this->response->setJSON($response);
	}
}

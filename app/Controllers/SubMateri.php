<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MateriModel;
use App\Models\SubMateriModel;

class SubMateri extends BaseController
{

	protected $subMateriModel;
	protected $validation;

	public function __construct()
	{
		$this->subMateriModel = new SubMateriModel();
		$this->materi = new MateriModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		// var_dump($this->materi->select('id_materi,judul_materi')->findAll());die;

		if (session()->get('isLogin')) {

			$data = [
				'controller'    	=> 'subMateri',
				'title'     		=> 'Menu Sub Materi',
				'materi'			=> $this->materi->select('id_materi,judul_materi')->findAll()
			];

			return view('subMateri', $data);
		} else {
			return view('login');
		}
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->subMateriModel->select()->join('tbl_materi tm', 'tm.id_materi= tbl_sub_materi.id_materi', 'inner')->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_sub_materi . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_sub_materi . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->judul_materi,
				$value->judul_sub_materi,
				$value->isi_materi,

				$ops
			);

			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_sub_materi');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->subMateriModel->join('tbl_materi tm','tm.id_materi = tbl_sub_materi.id_materi','inner')->where('id_sub_materi', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_sub_materi'] = $this->request->getPost('id_sub_materi');
		$fields['id_materi'] = $this->request->getPost('id_materi');
		$fields['judul_sub_materi'] = $this->request->getPost('judul_sub_materi');
		$fields['isi_materi'] = $this->request->getPost('isi_materi');
		$fields['created_at'] = date('Y-m-d');
		// $fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'id_materi' => ['label' => 'Nama Materi', 'rules' => 'required|numeric|min_length[0]|max_length[4]'],
			'judul_sub_materi' => ['label' => 'Judul sub materi', 'rules' => 'required|min_length[0]|max_length[255]'],
			'isi_materi' => ['label' => 'Isi materi', 'rules' => 'required|min_length[0]|max_length[8024]'],
		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->subMateriModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menambahkan sub materi");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menambahkan sub materi");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id_sub_materi'] = $this->request->getPost('id_sub_materi');
		$fields['id_materi'] = $this->request->getPost('id_materi');
		$fields['judul_sub_materi'] = $this->request->getPost('judul_sub_materi');
		$fields['isi_materi'] = $this->request->getPost('isi_materi');
		$fields['updated_at'] = date('Y-m-d');


		$this->validation->setRules([
			'id_materi' => ['label' => 'Nama Materi', 'rules' => 'required|numeric|min_length[0]|max_length[4]'],
			'judul_sub_materi' => ['label' => 'Judul sub materi', 'rules' => 'required|min_length[0]|max_length[255]'],
			'isi_materi' => ['label' => 'Isi materi', 'rules' => 'required|min_length[0]|max_length[8024]']
		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->subMateriModel->update($fields['id_sub_materi'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil mengubah sub materi");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal mengubah sub materi");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id_sub_materi');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->subMateriModel->where('id_sub_materi', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menghapus sub materi");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menghapus sub materi");
			}
		}

		return $this->response->setJSON($response);
	}
}

<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\HasilKuesionerModel;

class HasilKuesioner extends BaseController
{

	protected $hasilKuesionerModel;
	protected $validation;

	public function __construct()
	{
		$this->hasilKuesionerModel = new HasilKuesionerModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{
		if (session()->get('isLogin')) {
			$data = [
				'controller'    	=> 'hasilKuesioner',
				'title'     		=> 'Menu Hasil Kuesioner'
			];
			return view('hasilKuesioner', $data);
		} else {
			return view('login');
		}
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->hasilKuesionerModel->select()->join('tbl_user tu', 'tu.id_user = tbl_hasil_kuesioner.id_user', 'left')->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			// $ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_hasil . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("App.edit")  . '</a>';
			// $ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("App.copy")  . '</a>';
			// $ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_hasil . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->nm_lengkap,
				($value->kondisi == 1) ? 'Stress Ringan':($value->kondisi == 2 ? 'Stress Sedang' : ($value->kondisi == 3 ? 'Stress Berat':'Tidak Stress')),
				$value->skor,
				$value->status || $value->status == 0 ? 'Proses' : 'Selesai',
				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_hasil');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->hasilKuesionerModel->where('id_hasil', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_hasil'] = $this->request->getPost('id_hasil');
		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['kondisi'] = $this->request->getPost('kondisi');
		$fields['skor'] = $this->request->getPost('skor');
		$fields['status'] = $this->request->getPost('status');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'id_user' => ['label' => 'Nama User', 'rules' => 'required|numeric|min_length[0]|max_length[6]'],
			'kondisi' => ['label' => 'Kondisi', 'rules' => 'required|min_length[0]|max_length[100]'],
			'skor' => ['label' => 'Skor', 'rules' => 'required|min_length[0]|max_length[10]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]|max_length[3]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->hasilKuesionerModel->insert($fields)) {

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

		$fields['id_hasil'] = $this->request->getPost('id_hasil');
		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['kondisi'] = $this->request->getPost('kondisi');
		$fields['skor'] = $this->request->getPost('skor');
		$fields['status'] = $this->request->getPost('status');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'id_user' => ['label' => 'Nama User', 'rules' => 'required|numeric|min_length[0]|max_length[6]'],
			'kondisi' => ['label' => 'Kondisi', 'rules' => 'required|min_length[0]|max_length[100]'],
			'skor' => ['label' => 'Skor', 'rules' => 'required|min_length[0]|max_length[10]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]|max_length[3]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->hasilKuesionerModel->update($fields['id_hasil'], $fields)) {

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

		$id = $this->request->getPost('id_hasil');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->hasilKuesionerModel->where('id_hasil', $id)->delete()) {

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

<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;

class User extends BaseController
{

	protected $userModel;
	protected $validation;

	public function __construct()
	{
		$this->userModel = new UserModel();
		$this->validation =  \Config\Services::validation();
		helper('settings');
	}

	public function index()
	{

		if (session()->get('isLogin')) {

			$data = [
				'controller'    	=> 'user',
				'title'     		=> 'User'
			];

			return view('user', $data);
		} else {
			return view('login');
		}
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->userModel->select()->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_user . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<a class="dropdown-item text-info" onClick="changePass(' . $value->id_user . ')"><i class="fa-solid fa-key"></i> Ubah Password</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_user . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->username,
				$value->nm_lengkap,
				$value->tanggal_lahir != 0 ? tgl_indo($value->tanggal_lahir): '',
				$ops
			);

			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_user');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->userModel->where('id_user', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['username'] = $this->request->getPost('username');
		$fields['nm_lengkap'] = $this->request->getPost('nm_lengkap');
		$fields['tanggal_lahir'] = $this->request->getPost('tanggal_lahir');
		$fields['password'] = $this->request->getPost('password');
		$fields['konfpass'] = $this->request->getPost('konfpass');
		$fields['created_at'] = date('Y-m-d H:i:s');

		$userbiodata = array(
			'username' => trim($fields['username']),
			'nm_lengkap' => $fields['nm_lengkap'],
			'tanggal_lahir' => $fields['tanggal_lahir'],
			'password' => md5($fields['password']),
			'created_at' => date('Y-m-d H:i:s')
		);

		$this->validation->setRules([
			'username' => [
				'label' => 'Username', 'rules' => 'required|userExists[username]|trim|username_check_blank[username]', 'errors' => [
					'required' => 'Username Masih Kosong',
					'username_check_blank' => 'Username Tidak Boleh Spasi',
					'userExists' => 'Username sudah digunakan'
				]
			],
			'nm_lengkap' => [
				'label' => 'Nama lengkap', 'rules' => 'required|min_length[0]|max_length[100]',
				'errors' => ['required' => 'Nama Lengkap Tidak Boleh Kosong']
			],
			'tanggal_lahir' => ['label' => 'Tanggal lahir', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[4]','errors'=>[
				'required' => 'Password Tidak Boleh Kosong',
				'min_length' => 'Password Harus Lebih Dari 4 Karakter'
			]],
			'konfpass' => [
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'Password konfirmasi harus diisi',
					'matches' => 'Password konfirmasi tidak sama'
				]
			],
		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->userModel->insert($userbiodata)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil Menambanhkan Data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal Menambahkan Data");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['username'] = $this->request->getPost('username');
		$fields['nm_lengkap'] = $this->request->getPost('nm_lengkap');
		$fields['tanggal_lahir'] = $this->request->getPost('tanggal_lahir');
		$fields['password'] = md5($this->request->getPost('password'));
		$fields['konfpass'] = md5($this->request->getPost('konfpass'));
		// $fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = date('Y-m-d H:i:s');

		$this->validation->setRules([
			'nm_lengkap' => [
				'label' => 'Nama lengkap', 'rules' => 'required|min_length[0]|max_length[100]',
				'errors' => ['required' => 'Nama Lengkap Tidak Boleh Kosong']
			],
			'tanggal_lahir' => ['label' => 'Tanggal lahir', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[4]','errors'=>[
				'required' => 'Password Tidak Boleh Kosong',
				'min_length' => 'Password Harus Lebih Dari 4 Karakter'
			]],
			'konfpass' => [
				'rules' => 'required|matches[password]',
				'errors' => [
					'required' => 'Password konfirmasi harus diisi',
					'matches' => 'Password konfirmasi tidak sama'
				]
			],
		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->userModel->update($fields['id_user'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil Mengubah Data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal Mengubah Data");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id_user');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->userModel->where('id_user', $id)->delete()) {

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

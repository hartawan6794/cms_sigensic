<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

	protected $table = 'tbl_user';
	protected $primaryKey = 'id_user';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['username', 'nm_lengkap', 'tanggal_lahir', 'password', 'created_at', 'updated_at'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;

	public function userExists($username){
        $query = 'SELECT * from tbl_user where username= ?';
        $result = $this->db->query($query, $username)->getResultArray();

        if($result){
            return true;
        }else{
            return false;
        }
    }

	public function checkPassword($password)
    {
        $user = $this->select()->where('password', md5($password))->first();
        if ($user)
            return true;
        else
            return false;
    }
}

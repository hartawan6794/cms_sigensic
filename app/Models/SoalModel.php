<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class SoalModel extends Model {
    
	protected $table = 'tbl_soal';
	protected $primaryKey = 'id_soal';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['soal', 'created_at', 'updated_at'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}
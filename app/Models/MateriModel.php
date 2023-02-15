<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class MateriModel extends Model {
    
	protected $table = 'tbl_materi';
	protected $primaryKey = 'id_materi';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['judul_materi', 'isi_materi', 'created_at', 'updated_at'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}
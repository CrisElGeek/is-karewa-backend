<?php
use App\Model\BaseModel;
use App\Model\Crud;

class UnAdminComponent extends BaseModel {

	use Crud;
	
	protected $moduleFields = [
		'id' => ['field' => 'id','readonly' => true, 'saved' => false],
		'name' => ['field' => 'name'],
		'notes' => ['field' => 'notes']
	];

	protected $get_params = [
		'table' => 'admin_units',
		'filters' => [],
		'joins' => [],
		'search' => []
	];

	protected $rules = [
		'id' => 'required|numeric|unique:admin_units:id',
		'name' => 'required|max:150'
	];

	public function __construct() {
		parent::__construct();
	}

}
?>

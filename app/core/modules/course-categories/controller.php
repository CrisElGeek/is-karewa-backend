<?php
use App\Model\BaseModel;
use App\Model\Crud;

class CourseCategories extends BaseModel {

	use Crud {
		store as private storetrait;
		update as private updatetrait;
	}

	protected $moduleFields = [
		'id'   => ['field' => 'id', 'saved' => false],
		'name' => ['field' => 'name'],
		'slug'	=> ['field' => 'slug'],
		'status_id' => ['field' => 'status_id'],
		'excerpt' => ['field' => 'excerpt'],
		'thumbnail' => ['field' => 'thumbnail']
	];

	protected $get_params = [
		'table' => 'courses_categories',
		'search' => ['name']
	];

	protected $rules = [
		'name'   => 'required|max:45|min:4',
		'slug'	=> 'required|unique:courses_categories:slug',
		'status_id' => 'required|numeric|min_value:1|max_value:2',
		'thumbnail' => 'json'
	];
	
	function __construct() {
		parent::__construct();
		$this->table_assoc = [
			[
				'table'  => 'courses',
				'column' => 'category_id',
				'value'  => $_GET['id']
			]
		];
	}

	public function store() {
		$this->payload->slug = toAlphanumeric($this->payload->name);
		$this->storetrait();
	}
	
	public function update() {
		$this->payload->slug = toAlphanumeric($this->payload->name);
		$this->updatetrait();
	}
}
?>

<?php
use App\Model\BaseModel;
use App\Validation\FieldsValidator;
use App\Model\Crud;

class CoursesComponent extends BaseModel {

	use Crud {
		store as private storetrait;
		update as private updatetrait;
	}

	protected $moduleFields = [
		'id' => ['field' => 'c.id', 'saved' => false],
		'title' => ['field' => 'c.title'],
		'slug' => ['field' => 'c.slug'],
		'content' => ['field' => 'c.content', 'default' => '<p></p>'],
		'status_id' => ['field' => 'c.status_id', 'default' => 1],
		'excerpt' => ['field' => 'c.excerpt'],
		'thumbnail' => ['field' => 'c.thumbnail'],
		'tags' => ['field' => 'c.tags'],
		'goal'	=> ['field' => 'c.goal'],
		'start_date' => ['field' => 'c.start_date'],
		'end_date' => ['field' => 'c.end_date'],
		'sort_position' => ['field' => 'c.sort_position'],
		'duration' => ['field' => 'c.duration'],
		'category_id'	=> ['field' => 'c.category_id'],
		'category_name' => ['field' => 'x.name', 'saved' => false],
		'category_slug' => ['field' => 'x.slug', 'saved' => false]
	];

	protected $get_params = [
		'table' => 'courses c',
		'filters' => [],
		'joins' => [
			[
				'table' => 'courses_categories x',
				'match' => ['x.id', 'c.category_id']
			]
		],
		'search' => ['c.title', 'c.excerpt', 'c.slug', 'c.content', 'c.tags', 'c.goal', 'x.name', 'x.slug']
	];

	protected $rules = [
		'title' => 'required|max:255',
		'slug' => 'required|max:255|unique:courses:slug',
		'status_id'	 => 'max_value:1|max:2',
		'thumbnail' => 'json',
		'start_date' => 'date_format',
		'end_date' => 'date_format',
		'category_id' => 'required|numeric|exist:courses_categories:id'
	];

	public function __construct() {
		parent::__construct();
	}

	private function formatPayload() {
		$start_date = new DateTime($this->payload->start_date);
		$this->payload->start_date = $start_date->format('Y-m-d H:i:s');
		$end_date = new DateTime($this->payload->end_date);
		$this->payload->end_date = $end_date->format('Y-m-d H:i:s');
		$this->payload->slug = toalphanumeric($this->payload->title);
	}

	public function store() {
		$this->formatPayload();
		$this->storetrait();
	}
	
	public function update() {
		$this->formatPayload();
		$this->updatetrait();
	}
}
?>

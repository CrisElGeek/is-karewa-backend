<?php
use App\Helpers\ApiResponse;

class FrontendLogs {
  private $request;

  function __construct($request) {
    $this->request  = $request;
  }

  public function store() {
    // TODO: Implement frontend log storage logic here
		ApiResponse::Set('SUCCESS', [
      'message' => 'Frontend log stored successfully'
    ]);
  }
}
?>

<?php
class FrontendLogs {
  private $request;

  function __construct($request) {
    $this->request  = $request;
  }

  public function store() {
		//error_logs();
  }
}
?>

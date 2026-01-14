<?php
namespace App\Model;
use PDO;

abstract class DB {
  public static function connection() {
    try {
      $dbconn = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';port=' . MYSQL_PORT . ';charset=' . MYSQL_CHARSET, MYSQL_USER, MYSQL_PSWD);
      $dbconn->exec('SET CHARACTER SET ' . MYSQL_CHARSET);
      $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbconn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $dbconn->setAttribute(PDO::ATTR_PERSISTENT, true);
    } catch (\PDOException $e) {
      http_response_code(500);
      error_logs(['Database connection: ', $e->getMessage()], ERROR_LOG_FILE);
      die(json_encode(['message' => 'Unable to connect to database']));
    }
    return $dbconn;
  }
}
?>

<?php

namespace app\models;

abstract class Model {
  protected string $table;

  private function connect() {
    $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
    return new \PDO($string, DBUSER, DBPASS);
  }

  public function query($query, $data = []) {
    $con = $this->connect();
    $stm = $con->prepare($query);
    $success = $stm->execute($data);

    if (stripos(trim($query), 'SELECT') === 0) {
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    return $success;
}


}

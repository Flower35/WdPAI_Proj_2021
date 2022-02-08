<?php

  require_once __DIR__ . '/../dbms.php';

  class Repository {
      protected $db;

      public function __construct() {
          $this->db = DataBase::getInstance();
      }
  }

?>

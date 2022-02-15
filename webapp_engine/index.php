<?php

  require_once 'engine/Routing.php';
  require_once 'engine/dbms.php';
  require_once 'engine/ctrl/Controller.php';

  $db = DataBase::getInstance();

  if (!$db->tryToConnect()) {
    $ctrl = new Controller();
    $ctrl->defaultAction();
  } else {
    $path = trim($_SERVER['REQUEST_URI'], '/');
    $path = parse_url($path, PHP_URL_PATH);
    Router::run($path);

    // $db->closeConnection();

  }

?>

<?php

  require_once 'engine/Routing.php';
  require_once 'engine/dbms.php';
  require_once 'engine/ctrl/Controller.php';

  $db = DataBase::getInstance();

  if (!$db->tryToConnect()) {
    $ctrl = new Controller();
    $ctrl->databaseDied();
  } else {
    $path = trim($_SERVER['REQUEST_URI'], '/');
    $path = parse_url($path, PHP_URL_PATH);

    Router::get ('',             'Default');
    Router::get ('home',         'Default');
    Router::post('onLogin',      'Auth');
    Router::post('onRegister',   'Auth');
    Router::get ('registration', 'Default');

    Router::get ('settings',     'User');
    Router::get ('browsing',     'User');
    Router::get ('note',         'User');

    Router::run($path);

    // $db->closeConnection();
  }
?>

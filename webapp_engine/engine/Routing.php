<?php

  require_once 'ctrl/DefaultController.php';
  require_once 'ctrl/AuthController.php';
  require_once 'ctrl/UserController.php';

  class Router {

    public static $routes;

    private static function add_route($url, $ctrl) {
      self::$routes[$url] = $ctrl;
    }

    public static function post($url, $ctrl) {
      self::add_route($url, $ctrl);
    }

    public static function get($url, $ctrl) {
      self::add_route($url, $ctrl);
    }

    public static function run($url) {
      $action = explode("/", $url)[0];
      if (!array_key_exists($action, self::$routes)) {
        die("<div><b>Routing:</b> Wrong url!</div>");
      }

      $ctrlClass    = self::$routes[$action] . 'Controller';
      $ctrlInstance = new $ctrlClass;
      $action       = $action ?: 'index';

      $ctrlInstance->$action();
    }

  }

?>

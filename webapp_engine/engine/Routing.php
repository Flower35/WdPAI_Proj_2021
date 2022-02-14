<?php

  require_once 'routing_views_defs.php';

  require_once 'ctrl/DefaultController.php';
  require_once 'ctrl/AuthController.php';
  require_once 'ctrl/UserController.php';

  /**
   * Klasa routingu PHP
   */
  class Router {

    /**
     * Sprawdzenie poprawności działania aplikacji,
     *  czy na pewno istnieją wszystkie kontrolery
     *  i czy każdy kontroler ma odbicie akcji na metodę.
     * @return void
     */
    private static function assertContollersAndActionsExist(): void {
      function check(string $action): void {
        $ctrlClass = Router::findCtrl($action);
        if (null == $ctrlClass) {
          die("<div>Action <b>&quot;$action&quot;</b> is not assigned to any controller!</div>");
        }
        $ctrlClass .= 'Controller';
        if (!class_exists($ctrlClass)) {
          die("<div>Controller <b>&quot;$ctrlClass&quot;</b> does not exist!</div>");
        }
        if (!method_exists($ctrlClass, $action)) {
          die("<div>Controller <b>&quot;$ctrlClass&quot;</b> is missing action <b>&quot;$action&quot;</b>!</div>");
        }
      }

      check(RoutingActions\LOGGING_IN);
      check(RoutingActions\REGISTRATION);
      check(RoutingActions\TRY_LOGIN_FORM);
      check(RoutingActions\TRY_REGISTER_FORM);
      check(RoutingActions\TRY_LOG_OFF);
      check(RoutingActions\SETTINGS);
      check(RoutingActions\BROWSING);
      check(RoutingActions\EDITING);
    }

    /**
     * Wybór ścieżki routingu
     *
     * @param   string $action Wywoływana akcja
     * @return ?string Człon nazwy kontrolera odpowiadającego za akcję
     */
    public static function findCtrl(string $action): ?string {
      switch ($action) {
        case '':
          return 'Default';
        case RoutingActions\LOGGING_IN:
          return 'Default';
        case RoutingActions\REGISTRATION:
          return 'Default';
        case RoutingActions\TRY_LOGIN_FORM:
          return 'Auth';
        case RoutingActions\TRY_REGISTER_FORM:
          return 'Auth';
          case RoutingActions\TRY_LOG_OFF:
          return 'Auth';
        case RoutingActions\SETTINGS:
          return 'User';
        case RoutingActions\BROWSING:
          return 'User';
        case RoutingActions\EDITING:
          return 'User';
      }

      return null;
    }

    /**
     * Rozruch
     */
    public static function run($url) {
      self::assertContollersAndActionsExist();

      $action = explode("/", $url)[0];
      $ctrlClass = self::findCtrl($action);
      if (null == $ctrlClass) {
        die("<div><b>Routing:</b> Wrong url!</div>");
      }

      $ctrlClass    .= 'Controller';
      $ctrlInstance = new $ctrlClass;
      $action       = $action ?: 'defaultAction';

      $ctrlInstance->$action();
    }

  }

?>

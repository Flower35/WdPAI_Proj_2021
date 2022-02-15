<?php

  require_once 'ActViewHelper.php';

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
        $ctrlClass = AVHelper::findCtrl($action);
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

      check(AVHelper::ACT_LOGGING_IN);
      check(AVHelper::ACT_REGISTRATION);
      check(AVHelper::ACT_TRY_LOGIN_FORM);
      check(AVHelper::ACT_TRY_REGISTER_FORM);
      check(AVHelper::ACT_TRY_LOG_OFF);
      check(AVHelper::ACT_SETTINGS);
      check(AVHelper::ACT_BROWSING);
      check(AVHelper::ACT_EDITING);
      check(AVHelper::ACT_CHANGE_LANG);
      check(AVHelper::ACT_TRY_UPDATE_USER);
      check(AVHelper::ACT_TRY_REMOVE_USER);
    }

    /**
     * Rozruch
     */
    public static function run($url) {
      self::assertContollersAndActionsExist();

      $action = explode("/", $url)[0];
      $ctrlClass = AVHelper::findCtrl($action);
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

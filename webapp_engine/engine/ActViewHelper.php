<?php

  /**
   * Pomocnicze definicje i odwzorowania akcji na widoki
   */
  class AVHelper {

    #region Stałe dla akcji

    /**
     * Domyślna akcja, ekran logowania.
     */
    public const ACT_LOGGING_IN = 'home';

    /**
     * Ekran rejestracji nowego użytkownika.
     */
    public const ACT_REGISTRATION = 'registration';

    /**
     * Użytkownik wypełnił formularz logowania.
     */
    public const ACT_TRY_LOGIN_FORM = 'onLogin';

    /**
     * Użytkownik wypełnił formularz rejestracji.
     */
    public const ACT_TRY_REGISTER_FORM = 'onRegister';

    /**
     * Użytkownik wylogowuje się.
     */
    public const ACT_TRY_LOG_OFF = 'logOff';

    /**
     * Ekran ustawień użytkownika.
     */
    public const ACT_SETTINGS = 'settings';

    /**
     * Użytkownik zmodyfikował swoje konto.
     */
    public const ACT_TRY_UPDATE_USER = 'onUserUpdate';

    /**
     * Użytkownik wykasował się.
     */
    public const ACT_TRY_REMOVE_USER = 'onUserRemove';

    /**
     * Ekran dashboard.
     */
    public const ACT_BROWSING = 'browsing';

    /**
     * Ekran edycji notatki.
     */
    public const ACT_EDITING  = 'note';

    /**
     * Zmiana języka.
     */
    public const ACT_CHANGE_LANG  = 'changeLang';

    #endregion

    #region Stałe dla widoków

    /**
     * Wysypała się baza danych i nic nie zrobimy!
     */
    public const VIEW_DATABASE_UNREACHABLE = 'db_err';

    /**
     * Domyślny widok, ekran logowania.
     */
    public const VIEW_LOGGING_IN = 'login';

    /**
     * Ekran rejestracji nowego użytkownika.
     */
    public const VIEW_REGISTRATION = 'register';

    /**
     * Ekran ustawień użytkownika.
     */
    public const VIEW_SETTINGS = 'settings';

    /**
     * Ekran dashboard.
     */
    public const VIEW_BROWSING = 'browse';

    /**
     * Ekran edycji notatki.
     */
    public const VIEW_EDITING  = 'edit';

    #endregion

    #region Metody

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
        case self::ACT_LOGGING_IN:
          return 'Default';
        case self::ACT_REGISTRATION:
          return 'Default';
        case self::ACT_TRY_LOGIN_FORM:
          return 'Auth';
        case self::ACT_TRY_REGISTER_FORM:
          return 'Auth';
        case self::ACT_TRY_LOG_OFF:
          return 'Auth';
        case self::ACT_SETTINGS:
          return 'User';
        case self::ACT_TRY_UPDATE_USER:
          return 'User';
        case self::ACT_TRY_REMOVE_USER:
          return 'User';
        case self::ACT_BROWSING:
          return 'User';
        case self::ACT_EDITING:
          return 'User';
        case self::ACT_CHANGE_LANG:
          return 'Default';
      }

      return null;
    }

    /**
     * Pobranie dodatkowych zmiennych tekstowych dla danego widoku
     * @param  string $view Nazwa szablonu
     * @return  array Lista par (oczekiwana zmienna, identyfikator tłumaczenia)
     */
    public static function getViewVars(string $view): array {
      switch ($view) {
        case self::VIEW_LOGGING_IN:
          return [
            'hintMail' => 'FORM_MAIL',
            'hintPass' => 'FORM_PASS',
            'btnLogin' => 'FORM_BTN_LOGIN',
            'homeQuestion' => 'HOME_QUESTION',
            'btnRegister' => 'FORM_BTN_REGISTER'
          ];
        case self::VIEW_REGISTRATION:
          return [
            'hintMail' => 'FORM_MAIL',
            'hintPass' => 'FORM_PASS',
            'hintPass2' => 'FORM_PASS2',
            'hintRobot' => 'FORM_ROBOT',
            'btnRegister' => 'FORM_BTN_REGISTER'
          ];
        case self::VIEW_BROWSING:
        case self::VIEW_SETTINGS:
          return [
            'navMenuSettings' => 'NAVMENU_SETTINGS',
            'navMenuLogoff' => 'NAVMENU_LOGOFF'
          ];
        // (...)
      }
      return [];
    }

    #endregion

  }

?>

<?php

  namespace RoutingActions {

    /**
     * Domyślna akcja, ekran logowania.
     */
    const LOGGING_IN = 'home';

    /**
     * Ekran rejestracji nowego użytkownika.
     */
    const REGISTRATION = 'registration';

    /**
     * Użytkownik wypełnił formularz logowania.
     */
    const TRY_LOGIN_FORM = 'onLogin';

    /**
     * Użytkownik wypełnił formularz rejestracji.
     */
    const TRY_REGISTER_FORM = 'onRegister';

    /**
     * Użytkownik wylogowuje się.
     */
    const TRY_LOG_OFF = 'logOff';

    /**
     * Ekran ustawień użytkownika.
     */
    const SETTINGS = 'settings';

    /**
     * Ekran dashboard.
     */
    const BROWSING = 'browsing';

    /**
     * Ekran edycji notatki.
     */
    const EDITING  = 'note';

  }

  namespace ControllerViews {

    /**
     * Wysypała się baza danych i nic nie zrobimy!
     */
    const DATABASE_UNREACHABLE = 'db_err';

    /**
     * Domyślny widok, ekran logowania.
     */
    const LOGGING_IN = 'login';

    /**
     * Ekran rejestracji nowego użytkownika.
     */
    const REGISTRATION = 'register';

    /**
     * Ekran ustawień użytkownika.
     */
    const SETTINGS = 'settings';

    /**
     * Ekran dashboard.
     */
    const BROWSING = 'browse';

    /**
     * Ekran edycji notatki.
     */
    const EDITING  = 'edit';

  }

?>

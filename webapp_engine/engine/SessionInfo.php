<?php

  /**
   * Klasa odpowiedzialna za włączanie i wyłączanie sesji użytkownika
   */
  class SessionInfo {

    /**
     * Maksymalny czas trwania jednej sesji (w sekundach)
     */
    private const TIMEOUT = 60 * 30;

    /**
     * Czy użytkownik jest obecnie zalogowany?
     * @return bool Prawda jeśli użytkownik jest zalogowany.
     */
    public static function isLoggedIn(): bool {
      session_start();

      return
        isset($_SESSION['theUser']) &&
        isset($_SESSION['created']);
    }

    /**
     * Czy sesja wygasła?
     * @return bool Prawda jeśli należy zakończyć zaległą sesję
     */
    public static function hasExpired(): bool {
      if (isset($_SESSION['created'])) {
        return ((time() - $_SESSION['created']) >= self::TIMEOUT);
      }
      return true;
    }

    /**
     * Odśwież czas wygaśnięcia sesji
     * @return void
     */
    public static function refreshTimeout(): void {
      $_SESSION['created'] = time();
    }

    /**
     * Włącz sesję i zapamiętaj nowego użytkownika
     * @param  mixed $userId Identyfikator użytkownika
     * @return void
     */
    public static function rememberUser(int $userId): void {
      // isLoggedIn() => session_start();

      $_SESSION['theUser'] = $userId;
      self::refreshTimeout();
    }

    /**
     * Wyloguj użytkownika i zakończ jego sesję
     * @return void
     */
    public static function end(): void {
      session_start();
      session_unset();
      session_destroy();
    }

  }

?>

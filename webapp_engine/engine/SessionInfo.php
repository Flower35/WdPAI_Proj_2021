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
     * Czy wywołano już metodę magiczną 'session_start()'
     */
    private static bool $sessionStarted = false;

    /**
     * Czy użytkownik jest obecnie zalogowany?
     * @return bool Prawda jeśli użytkownik jest zalogowany.
     */
    public static function isLoggedIn(): bool {
      if (!self::$sessionStarted) {
        session_start();
        self::$sessionStarted = true;
      }
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
      if (!self::$sessionStarted) {
        session_start();
        self::$sessionStarted = true;
      }
      $_SESSION['theUser'] = $userId;
      self::refreshTimeout();
    }

    /**
     * Pobierz identyfikator obecnie zalogowanego użytkownika
     * @return int Identyfikator użytkownika
     */
    public static function getUserId(): int {
      return $_SESSION['theUser'];
    }

    /**
     * Wyloguj użytkownika i zakończ jego sesję
     * @return void
     */
    public static function end(): void {
      if (!self::$sessionStarted) {
        session_start();
        self::$sessionStarted = true;
      }
      session_unset();
      session_destroy();
    }

  }

?>

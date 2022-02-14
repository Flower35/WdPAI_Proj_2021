<?php

  require_once 'dbms.php';

  /**
   * Klasa odpowiadająca za wielojęzykowość aplikacji
   */
  class Translations {

    #region Zmienne

    /**
     * Statyczna instancja klasy (Singleton)
     */
    private static ?self $instance = null;

    /**
     * Identyfikator języka (do zapytań w bazie danych, przy prośbie o tekst)
     */
    private int $langId;

    /**
     * Odnośnik do Singletona bazy danych
     */
    private DataBase $db;

    #endregion

    #region Metody

    /**
     * Konstruktor klasy Translations
     */
    private function __construct() {
      $this->db = DataBase::getInstance();

      if (isset($_COOKIE['language'])) {
        $this->langId = self::getLangId($_COOKIE['language']);
      } else {
        $this->langId = 1;
      }
    }

    /**
     * Singleton nie może być klonowany
     */
    private function __clone() {}

    /**
     * Singleton nie może być wznawiany
     */
    public function __wakeup() {}

    /**
     * Pobieranie instancji Singletona Translations
     * @return self Singleton Translations
     */
    public static function getInstance(): self {
      if (!isset(self::$instance)) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    /**
     * Zmiana języka przez użytkownika
     *
     * @param  string $code Identyfikator nowego języka w postaci skróconej nazwy
     * @return void
     */
    public function setLang(string $code): void {
      // Język zapamiętywany jest przez 30 dni
      setcookie('language', $code, time() + 60 * 60 * 24 * 30);
      $this->langId = $this->getLangId($code);
    }

    /**
     * Znajduje numeryczny indeks języka w bazie danych
     *
     * @param  string $code Identyfikator wyszukiwanego języka w postaci skróconej nazwy
     * @return int    Indeks języka w bazie danych
     */
    private function getLangId(string $code): int {
      $test = $this->db->runQuery(
        "SELECT
          lang_id
        FROM
          Languages
        WHERE
          code = ?",
          [$code]);

      return $test ? $test['lang_id'] : 1;
    }

    /**
     * Odszukuje tekst o danym identyfikatorze, w uprzednio wybranym języku
     *
     * @param  string $shortname Identyfikator tłumaczonego tekstu w bazie danych
     * @return string Konkretne tłumaczenie do wyświetlenia na stronie
     */
    public function getText(string $shortname): string {
      $test = $this->db->runQuery(
        "SELECT
          tt.text
        FROM
          Translation_Text AS tt
        INNER JOIN
          Translation_Short AS ts USING(text_id)
        INNER JOIN
          Languages as l USING(lang_id)
        WHERE
          l.lang_id = ? AND ts.shortname = ?
        LIMIT 1",
          [$this->langId, $shortname]);

      return $test ? $test['text'] : ('&quot;' . $shortname . '&quot;');
    }

    /**
     * Zwraca sformatowany przetłumaczony tekst
     *
     * @param  string $shortname Identyfikator tłumaczonego tekstu w bazie danych
     * @param  array $variables  Tekst do połączenia z szablonem
     * @return string Konkretny komunikat do wyświetlenia na stronie
     */
    public function getFormattedText(string $shortname, array $variables): string {
      $format = $this->getText($shortname);

      // "{}{}{}" -> "{0}{1}{2}"
      $format = preg_replace_callback('#\{\}#', function($r) {
        static $i = 0;
        return '{' . ($i++) . '}';
      }, $format);

      $format = str_replace(
        array_map(
          function($k) { return '{' . $k . '}'; },
          array_keys($variables)),
        array_values($variables),
        $format);

        return htmlspecialchars($format);
    }

    #endregion

  }

?>

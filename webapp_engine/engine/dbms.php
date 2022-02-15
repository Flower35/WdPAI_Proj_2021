<?php

  /**
   * Klasa odpowiadająca za łączenie się z bazą danych w aplikacji
   */
  class DataBase {

    #region Zmienne

    /**
     * Statyczna instancja klasy (Singleton)
     */
    private static self $db;

    /**
     * PHP Data Object - odnośnik do aktualnego połączenia z bazą danych
     */
    private ?PDO $pdo;

    #endregion

    #region Metody

    /**
     * Konstruktor klasy DataBase
     */
    private function __construct() {
      $this->pdo = null;
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
     * Pobieranie instancji Singletona DataBase
     * @return self Singleton DataBase
     */
    public static function getInstance(): self {
      if (!isset(self::$db)) {
        self::$db = new self();
      }
      return self::$db;
    }

    /**
     * Sprawdzenie czy baza danych jest połączona
     *
     * @param  bool $throwup Prawda jeśli należy bezwłocznie wyrzucić wyjątek
     * @return bool Prawda jeśli baza danych jest połączona
     */
    public function checkConnection(bool $throwup = true): bool {
      if (!isset($this->pdo)) {
        if ($throwup) {
          throw new \Exception("DataBase is not connected at this point!");
        }
        return false;
      }
      return true;
    }

    /**
     * Próba nawiązania połączenia z bazą (raz w trakcie uruchamiania dowolnej strony)
     *
     * @return bool Prawda jeśli pomyślnie nawiązano połączenie
     */
    public function tryToConnect(): bool {
      if ($this->checkConnection(false)) {
        return true;
      }

      $pgsql = include("database_settings.inc");

      $connection =
        "pgsql:host=" . $pgsql["HOST"] .
        ";port="      . $pgsql["PORT"] .
        ";dbname="    . $pgsql["DBNAME"] .
        ";user="      . $pgsql["USERNAME"] .
        ";password="  . $pgsql["PASSWORD"];

      function connect(string $connection): ?PDO {
        try {
          return new PDO($connection);
        } catch (\PDOException) {
          return null;
        }
      }

      $this->pdo = connect($connection);
      return (null != $this->pdo);
    }

    /**
     * Zamknięcie połączenia z bazą danych
     *
     * @return void
     */
    public function closeConnection(): void {
      if (isset($this->pdo)) {
        $this->pdo = null;
      }
    }

    /**
     * Uruchomienie kwerendy do bazy danych
     *
     * @param  string $query  Tekstowa kwerenda
     * @param  ?array $params Opcjonalne parametry do wypełnienia w kwerendzie
     * @return array Tablica odpowiedzi jeśli kwerenta się powiedzie, lub wartość NULL
     */
    public function runQuery(string $query, array $params = []): ?array {
      if (!$this->checkConnection(false)) {
        return null;
      }

      $stmt = $this->pdo->prepare($query);
      $stmt->execute($params);

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return (false == $result) ? null : $result;
    }

    #endregion

  }

?>

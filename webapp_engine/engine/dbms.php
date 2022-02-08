<?php
  class DataBase {
    private static self $db;
    private ?PDO $pdo;

    private function __construct()
    {
      $this->pdo = null;
    }

    private function __clone() {}
    public function __wakeup() {}

    public static function getInstance(): self {
      if (!isset(self::$db)) {
        self::$db = new self();
      }
      return self::$db;
    }

    public function checkConnection(bool $throwup = true): bool {
      if (!isset($this->pdo)) {
        if ($throwup) {
          throw new \Exception("DataBase is not connected at this point!");
        }
        return false;
      }
      return true;
    }

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

    public function closeConnection(): void {
      if (isset($this->pdo)) {
        $this->pdo = null;
      }
    }

    public function runQuery(string $query, array $params): ?array {
      if (!$this->checkConnection(false)) {
        return null;
      }

      $stmt = $this->pdo->prepare($query);
      $stmt->execute($params);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return (false == $result) ? null : $result;
    }

    public function getLangId(string $code): int {
      $test = $this->runQuery(
        "SELECT lang_id FROM Languages WHERE code = ?",
        [$code]
      );

      if (!$test) {
        return 1;
      }

      return $test['lang_id'];
    }

    public function getTranslation(int $lang_id, string $shortname): string {
      $test = $this->runQuery(
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
        [$lang_id, $shortname]
      );
      return $test['text'];
    }

  }
?>

<?php

  require_once 'Repository.php';
  require_once __DIR__ . '/../mdl/User.php';

  /**
   * Klasa odpowiadająca za repozytorium użytkowników
   */
  class UserRepository extends Repository {

    /**
     * Znajduje obiekt użytkownika po identyfikatorze
     * @param     int $id Identyfikator użytkownika
     * @return ?array Znaleziony użytkownik, lub NULL jeśli nie istnieje
     */
    public function findUserById(int $id): ?array {
     return $this->db->runQuery(
        "SELECT *
        FROM Users
        WHERE user_id = ?
        LIMIT 1",
          [$id]);
    }

    /**
     * Znajduje obiekt użytkownika i uzupełnia go danymi z bazy
     * @param   int $id Identyfikator użytkownika
     * @return User Spreparowany obiekt użytkownika
     */
    public function getUserById(int $id): ?User {
      $db_rows = $this->findUserById($id);
      if (null == $db_rows) { return null; }
      return $this->getUserObject($db_rows[0]);
    }

    /**
     * Znajduje obiekt użytkownika po adresie e-mail
     * @param  string $email Adres mailowy użytkownika
     * @return ?array Znaleziony użytkownik, lub NULL jeśli nie istnieje
     */
    public function findUserByMail(string $email): ?array {
      return $this->db->runQuery(
         "SELECT *
         FROM Users
         WHERE email = ?
         LIMIT 1",
           [$email]);
     }

     /**
      * Znajduje obiekt użytkownika i uzupełnia go danymi z bazy
      * @param  string $email Adres mailowy użytkownika
      * @return User   Spreparowany obiekt użytkownika
      */
     public function getUserByMail(string $email): ?User {
       $db_rows = $this->findUserByMail($email);
       if (null == $db_rows) { return null; }
       return $this->getUserObject($db_rows[0]);
     }

    /**
     * Uzupełnia obiekt użytkownika danymi z bazy
     * @param  mixed $db_user Dane pobrane z bazy
     * @return User  Obiekt gotowy do użycia w PHP
     */
    private function getUserObject(array $db_user): User {
      $user = new User(); $user
        ->setUserId($db_user['user_id'])
        ->setSuperpowers($db_user['superpowers'])
        ->setActivated($db_user['activated'])
        ->setCreationTime(new DateTime($db_user['created']))
        ->setEmail($db_user['email'])
        ->setPassword($db_user['password'])
        ->setDisplayName($db_user['display_name'])
        ->setPreferredLanguage($db_user['language'])
        ->setLastNoteId($db_user['last_note']);
      return $user;
    }

    /**
     * Dodaje nowego użytkownika do bazy danych
     * @param  string $email    Adres mailowy
     * @param  string $hashPass Zahashowane hasło
     * @return bool   Prawda jeśli dodanie użytkownika się powiodło
     */
    public function addUser(string $email, string $hashPass): bool {
      $creationTime = new DateTime();

      $test = $this->db->runQuery(
        "INSERT INTO Users
        (activated, superpowers, created, email, password, display_name, language, last_note)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?)
        RETURNING user_id",
        [intval(true), intval(false), $creationTime->format('Y-m-d H:i:s'), $email, $hashPass, $email, null, null]
      );

      if (!$test) { return false; }
      return (null != $test[0]['user_id']);
    }

    /**
     * Zmiana hasła na prośbę użytkownika
     * @param  int $userId Identyfikator użytkownika
     * @param  string $hashPass Nowe, zahashowane hasło
     * @return bool Prawda jeśli modyfikacja powiedzie się
     */
    public function changePassword(int $userId, string $hashPass): bool {
      $test = $this->db->runQuery(
        "UPDATE Users
        SET password = ?
        WHERE user_id = ?",
          [$hashPass, $userId]
      );

      if (!$test) { return false; }
      return isset($test[0]);
    }

    /**
     * Zmiana nazwy wyświetlanej na prośbę użytkownika
     * @param  int $userId Identyfikator użytkownika
     * @param  string $displayName Nowa nazwa wyświetlana
     * @return bool Prawda jeśli modyfikacja powiedzie się
     */
    public function changeDisplayName(int $userId, string $displayName): bool {
      $test = $this->db->runQuery(
        "UPDATE Users
        SET display_name = ?
        WHERE user_id = ?",
          [$displayName, $userId]
      );

      if (!$test) { return false; }
      return isset($test[0]);
    }

    /**
     * Usunięcie konta na prośbę użytkownika
     * @param  int $userId Identyfikator użytkownika
     * @return bool Prawda jeśli konto zostało zniszczone
     */
    public function removeUser(int $userId): bool {
      $test = $this->db->runQuery(
        "DELETE FROM Users
        WHERE user_id = ?",
          [$userId]
      );

      if (!$test) { return false; }
      return isset($test[0]);
    }

  }

?>

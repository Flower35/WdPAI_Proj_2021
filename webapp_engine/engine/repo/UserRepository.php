<?php

  require_once 'Repository.php';
  require_once __DIR__ . '/../mdl/User.php';

  class UserRepository extends Repository {

    public function findUser(string $email): ?array {

     return $this->db->runQuery(
        "SELECT * FROM Users WHERE email = ?",
        [$email]
      );
    }

    public function getUser(string $email): ?User {

      // debug
      $lang = $this->db->getLangId('eng');
      $text = $this->db->getTranslation($lang, 'TITLE_LOGIN');

      $db_user = $this->findUser($email);

      if (null == $db_user) {
        return null;
      }

      $user = new User(); $user
        ->setActivated($db_user['activated'])
        ->setCreationTime(new DateTime($db_user['created']))
        ->setEmail($db_user['email'])
        ->setPassword($db_user['password'])
        ->setDisplayName($db_user['display_name'])
        ->setPreferredLanguage($db_user['language'])
        ->setLastNoteId($db_user['last_note']);

      return $user;
    }

    public function addUser(string $email, string $hashPass): bool {
      $creationTime = new DateTime();

      $test = $this->db->runQuery(
        "INSERT INTO Users
        (activated, created, email, password, display_name, language, last_note)
        VALUES(?, ?, ?, ?, ?, ?, ?)
        RETURNING user_id",
        [true, $creationTime->format('Y-m-d H:i:s'), $email, $hashPass, $email, null, null]
      );

      if (!$test) {
        return false;
      }

      return (null != $test['user_id']);
    }

  }

?>

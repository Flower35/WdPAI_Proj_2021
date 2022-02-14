<?php

  require_once 'Repository.php';
  require_once __DIR__ . '/../mdl/Note.php';

  class NoteRepository extends Repository {

    public function getNote(int $id): ?Note {

      $db_test = $this->db->runQuery(
        "SELECT * FROM Notes
        WHERE note_id = ?"
          [$id]);

      if (!$db_test) {
        return false;
      }

      $note = new Note(); $note
        ->setIconColor($db_test['icon_color'])
        ->setBackgroundColor($db_test['bkg_color'])
        ->setFontColor($db_test['fnt_color'])
        ->setCreationTime(new DateTime($db_test['created']))
        ->setModificationTime(new DateTime($db_test['modified']))
        ->setExpirationTime(new DateTime($db_test['expires']))
        ->setName($db_test['name']);

      return $note;
    }

    public function getFullNote(Note $note): Note {

      $db_test = $this->db->runQuery(
        "SELECT nh.name FROM NoteHeaders AS nh
        INNER JOIN Notes USING(note_id)
        WHERE nh.note_id = ?
        ORDER BY nh.col_older"
          [$id]
      );

      if (!$db_test) {
        return false;
      }

      $rows = array();
      $row_headers = array();

      foreach ($db_test as $tab_header) {
        array_push($row_headers, $tab_header);
      }

      array_push($rows, $row_headers);

      // TODO: (...)

      $note->setRows($rows);

      return $note;
    }

    public function getUserNotes(int $userId): array {

      $test = $this->db->runQuery(
        "SELECT Notes.note_id
        FROM Notes
        WHERE user_id = ?"
          [$userId]
      );

      return $test ?: array('1');
    }

  }

?>

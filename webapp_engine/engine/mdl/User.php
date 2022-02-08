<?php

  class User {

    private bool      $activated;
    private ?DateTime $created;
    private string    $email;
    private string    $password;
    private ?string   $displayName;
    private ?int      $lang;
    private ?int      $lastNote;

    public function __construct ()  {
      $this->activated   = false;
      $this->created     = new DateTime();
      $this->email       = '';
      $this->password    = '';
      $this->displayName = '';
      $this->lang        = null;
      $this->lastNote    = null;
    }

    public function getActivated(): bool {
      return $this->activated;
    }

    public function setActivated(bool $activated): User {
      $this->activated = $activated;
      return $this;
    }

    public function getCreationTime(): DateTime {
      return $this->created;
    }

    public function setCreationTime(DateTime $created): User {
      $this->created = $created;
      return $this;
    }

    public function getEmail(): string {
      return $this->email;
    }

    public function setEmail(string $email): User {
      $this->email = $email;
      return $this;
    }

    public function getPassword(): string {
      return $this->password;
    }

    public function setPassword(string $password): User {
      $this->password = $password;
      return $this;
    }

    public function getDisplayName(): string {
      return $this->displayName;
    }

    public function setDisplayName(string $displayName): User {
      $this->displayName = $displayName;
      return $this;
    }

    public function getPreferredLanguage(): int {
      return $this->lang;
    }

    public function setPreferredLanguage(mixed $lang): User {
       if (null != $lang) {
         $this->lang = $lang;
       } else {
         $this->lang = null;
       }
       return $this;
    }

    public function getLastNoteId(): int {
      return $this->lastNote;
    }

    public function setLastNoteId(mixed $lastNote): User {
      if (null != $lastNote) {
        $this->lastNote = $lastNote;
      } else {
        $this->lastNode = null;
      }
      return $this;
    }

  }

?>

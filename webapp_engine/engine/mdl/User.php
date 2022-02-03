<?php

  class User {

    private bool      $activated;
    private ?DateTime $created;
    private string    $email;
    private string    $password;
    private ?string   $displayName;
    private ?int      $lang;
    private ?int      $lastNote;

    public function __construct (
      ?bool     $activated,
      ?DateTime $created,
      string    $email,
      string    $password,
      ?string   $displayName,
      ?int      $lang,
      ?int      $lastNote
    ) {
      $this->activated   = $activated;
      $this->created     = $created;
      $this->email       = $email;
      $this->password    = $password;
      $this->displayName = $displayName;
      $this->lang        = $lang;
      $this->lastNote    = $lastNote;
    }

    public function isActivated(): bool {
      return $this->activated;
    }

    public function getCreationTime(): DateTime {
      return $this->created;
    }

    public function getEmail(): string {
      return $this->email;
    }

    public function getPassword(): string {
      return $this->password;
    }

    public function getDisplayName(): string {
      return $this->displayName;
    }

    public function getPreferredLanguage(): int {
      return $this->lang;
    }

    public function getLastNoteId(): int {
      return $this->lastNode;
    }

  }

?>

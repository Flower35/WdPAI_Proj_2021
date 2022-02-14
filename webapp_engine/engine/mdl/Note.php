<?php

  class Note {

    private int       $iconColor;
    private int       $bkgColor;
    private int       $fntColor;
    private ?DateTime $created;
    private ?DateTime $modified;
    private ?DateTime $expires;
    private string    $name;

    private array $rows;

    public function __construct () {
      $this->iconColor = 0;
      $this->bkgColor  = 0;
      $this->fntColor  = 0;
      $this->created   = new DateTime();
      $this->modified  = $this->created;
      $this->expires   = null;
      $this->name      = '';

      $this->rows = null; // array(array(''));
    }

    public function getIconColor(): int {
      return $this->iconColor;
    }

    public function setIconColor(int $color): Note {
      $this->iconColor = $color;
      return $this;
    }

    public function getBackgroundColor(): int {
      return $this->bkgColor;
    }

    public function setBackgroundColor(int $color): Note {
      $this->bkgColor = $color;
      return $this;
    }

    public function getFontColor(): int {
      return $this->fntColor;
    }

    public function setFontColor(int $fntColor): Note {
      $this->fntColor = $fntColor;
      return $this;
    }

    public function getCreationTime(): DateTime {
      return $this->created;
    }

    public function setCreationTime(DateTime $created): Note {
      $this->created = $created;
      return $this;
    }

    public function getModificationTime(): DateTime {
      return $this->modified;
    }

    public function setModificationTime(DateTime $modified): Note {
      $this->modified = $modified;
      return $this;
    }

    public function getExpirationTime(): DateTime {
      return $this->expires;
    }

    public function setExpirationTime(DateTime $expires): Note {
      $this->expires = $expires;
      return $this;
    }

    public function getName(): string {
      return $this->name;
    }

    public function setName(string $name): Note {
      $this->name = $name;
      return $this;
    }

    public function getRows(): array {
      return $this->rows;
    }

    public function setRows(array $rows): Note {
      $this->rows = $rows;
      return $this;
    }

  }

?>

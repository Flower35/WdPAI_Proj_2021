<?php

  require_once 'Controller.php';

  class UserController extends Controller {

    public function browsing() {
      $this->render('browse_notes');
    }

    public function settings() {
      $this->render('user_settings');
    }

    public function note() {
      $this->render('edit_notes');
    }

  }

?>

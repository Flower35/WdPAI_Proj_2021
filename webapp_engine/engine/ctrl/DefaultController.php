<?php

  require_once 'Controller.php';

  class DefaultController extends Controller {

    public function index() {
      $this->render('user_login');
    }

    public function home() {
      $this->render('user_login');
    }

    public function registration() {
      $this->render('user_registration');
    }

    public function browse() {
      $this->render('browse_notes');
    }

  }

?>

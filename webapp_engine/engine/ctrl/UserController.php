<?php

  require_once __DIR__ . '/../routing_views_defs.php';
  require_once 'Controller.php';

  class UserController extends Controller {

    public function browsing() {
      if ($this->validateSession()) {
        $this->render(ControllerViews\BROWSING);
      }
    }

    public function settings() {
      if ($this->validateSession()) {
        $this->render(ControllerViews\SETTINGS);
      }
    }

    public function note() {
      if ($this->validateSession()) {
        $this->render(ControllerViews\EDITING);
      }
    }

  }

?>

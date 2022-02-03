<?php

  require_once 'Controller.php';

  require_once __DIR__ . '/../mdl/User.php';

  class AuthController extends Controller {

    const LOGON_VIEW = 'user_login';

    public function onLogin() {
      if (!$this->isPost()) {
        return $this->render(self::LOGON_VIEW);
      }

      $testUser = new User (
        true, null, 'admin@poczta.pl', '123', null, null, null
      );

      $email = $_POST['email'];
      $pass  = $_POST['password'];

      if ($email != $testUser->getEmail()) {
        return $this->render(self::LOGON_VIEW, ['messages' => [
          'User with this e-mail does not exist.'
        ]]);
      }

      if ($pass != $testUser->getPassword()) {
        return $this->render(self::LOGON_VIEW, ['messages' => [
          'Incorrect password for "' . $testUser->getEmail() . '".'
        ]]);
      }

      $url = "http://$_SERVER[HTTP_HOST]";
      header("Location: {$url}/browsing");
    }

    public function onRegister() {
      echo '<h3>Registering...</h3>';
      // (...)
    }

  }

?>

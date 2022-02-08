<?php

  require_once 'Controller.php';

  require_once __DIR__ . '/../mdl/User.php';
  require_once __DIR__ . '/../repo/UserRepository.php';

  class AuthController extends Controller {

    const LOGON_VIEW = 'user_login';
    const REGISTER_VIEW = 'user_registration';

    private UserRepository $repository;

    public function __construct() {
      parent::__construct();
      $this->repository = new UserRepository();
    }

    public function onLogin() {
      if (!$this->isPost()) {
        return $this->render(self::LOGON_VIEW);
      }

      $email = $_POST['email'];
      $pass  = hash('sha256', $_POST['password']);

      $user = $this->repository->getUser($email);

      if (!$user) {
        return $this->render(self::LOGON_VIEW, ['messages' => [
          'User "' . $email . '" not found!'
        ]]);
      }

      if ($pass != $user->getPassword()) {
        return $this->render(self::LOGON_VIEW, ['messages' => [
          'Incorrect password for "' . $email . '".'
        ]]);
      }

      $url = "http://$_SERVER[HTTP_HOST]";
      header("Location: {$url}/browsing");
    }

    public function onRegister() {
      if (!$this->isPost()) {
        return $this->render(self::REGISTER_VIEW);
      }

      $email = $_POST['email'];
      $pass1 = $_POST['password1'];
      $pass2 = $_POST['password2'];

      if (!$email) {
        return $this->render(self::REGISTER_VIEW, ['messages' => [
          'Please provide an e-mail address!'
        ]]);
      }

      if ((!$pass1) || (!$pass2)) {
        return $this->render(self::REGISTER_VIEW, ['messages' => [
          'Please provide a password!'
        ]]);
      }

      if ($pass1 != $pass2) {
        return $this->render(self::REGISTER_VIEW, ['messages' => [
          'Password mismatch! Try again.'
        ]]);
      }

      if ($this->repository->findUser($email)) {
        return $this->render(self::REGISTER_VIEW, ['messages' => [
          'Sorry, user "' . $email . '" already exists!'
        ]]);
      }

      if (!$this->repository->addUser($email, hash('sha256', $pass1))) {
        return $this->render(self::REGISTER_VIEW, ['messages' => [
          'Sorry, could not add user to the database!'
        ]]);
      }

      return $this->render(self::LOGON_VIEW, ['messages' => [
        'Successfully registered account! :)'
      ]]);
    }

  }

?>

<?php

  require_once __DIR__ . '/../ActViewHelper.php';
  require_once 'Controller.php';

  require_once __DIR__ . '/../SessionInfo.php';

  require_once __DIR__ . '/../mdl/User.php';
  require_once __DIR__ . '/../repo/UserRepository.php';

  /**
   * Kontroler autoryzacji użytkownika
   */
  class AuthController extends Controller {

    #region Zmienne

    /**
     * Repozytorium wyszukujące użytkowników
     */
    private UserRepository $repository;

    #endregion

    #region Metody

    /**
     * Konstruktor kontrolera AuthController
     */
    public function __construct() {
      parent::__construct();
      $this->repository = new UserRepository();
    }

    /**
     * Akcja: próba zalogowania się
     */
    public function onLogin() {

      if (!SessionInfo::isLoggedIn() || SessionInfo::hasExpired()) {

        if (!$this->isPost()) {
          // Próba uruchomienia akcji przez niepoprawne żądanie
          return $this->render(AVHelper::VIEW_LOGGING_IN);
        }

        // Odczyt danych z formularza logowania
        $email = filter_var($_POST['email'] ?? null, FILTER_VALIDATE_EMAIL);
        $pass  = $_POST['password'] ?? null;

        // Czy wpisano niepusty adres email
        if (!self::isTextSet($email)) {
          return $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
            $this->tra->getText('ERROR_REGISTER_EMAIL'));
        }
        // Czy wpisano niepuste hasło
        if (!self::isTextSet($pass)) {
          return $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
            $this->tra->getText('ERROR_REGISTER_PASS'));
        }

        // Wyszukiwanie użytkownika wraz z jego pełnymi danymi
        $user = $this->repository->getUserByMail($email);

        if (!$user) {
          return $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
            $this->tra->getFormattedText('ERROR_LOGIN_MAIL', array($email)));
        }

        // Porównanie zahashowanego hasła
        $pass  = hash('sha256', $pass);

        if ($pass != $user->getPassword()) {
          return $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
            $this->tra->getFormattedText('ERROR_LOGIN_PASS', array($email)));
        }

        // Logowanie pomyślne, rozpocznij sesję użytkownika
        SessionInfo::rememberUser($user->getUserId());
      }

      self::enterDashboard();
    }

    /**
     * Akcja: próba zarejestrowania się
     */
    public function onRegister() {

      if (SessionInfo::isLoggedIn() && !SessionInfo::hasExpired()) {
        return self::enterDashboard();
      }

      if (!$this->isPost()) {
        // Próba uruchomienia akcji przez niepoprawne żądanie
        return $this->render(AVHelper::VIEW_REGISTRATION);
      }

      // Odczyt danych
      $email = filter_var($_POST['email'] ?? null, FILTER_VALIDATE_EMAIL);
      $pass1 = $_POST['password1'] ?? null;
      $pass2 = $_POST['password2'] ?? null;
      $human = $_POST['human']     ?? null;

      // Czy osoba rejestrująca się nie jest robotem
      if (!self::isTextSet($human) || ('on' != $human)) {
        return $this->renderWithMessage(AVHelper::VIEW_REGISTRATION,
          $this->tra->getText('ERROR_REGISTER_HUMAN'));
      }

      // Czy wpisano niepusty adres email
      if (!self::isTextSet($email)) {
        return $this->renderWithMessage(AVHelper::VIEW_REGISTRATION,
          $this->tra->getText('ERROR_REGISTER_EMAIL'));
      }

      // Czy użytkownik o podanej nazwie już istnieje
      if ($this->repository->findUserByMail($email)) {
        return $this->renderWithMessage(AVHelper::VIEW_REGISTRATION,
        $this->tra->getFormattedText('ERROR_REGISTER_EXISTS', array($email)));
      }

      // Czy wpisano niepuste hasła
      if (!self::isTextSet($pass1) || !self::isTextSet($pass2)) {
        return $this->renderWithMessage(AVHelper::VIEW_REGISTRATION,
          $this->tra->getText('ERROR_REGISTER_PASS'));
      }

      // Czy hasła podane podczas rejestracji pasują do siebie
      if ($pass1 != $pass2) {
        return $this->renderWithMessage(AVHelper::VIEW_REGISTRATION,
          $this->tra->getText('ERROR_REGISTER_PASSMISS'));
      }

      // Dodaj użytkownika do bazy danych
      if (!$this->repository->addUser($email, hash('sha256', $pass1))) {
        return $this->renderWithMessage(AVHelper::VIEW_REGISTRATION,
          $this->tra->getText('ERROR_REGISTER_ANYTHING'));
      }

      return $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
        $this->tra->getText('SUCCESS_REGISTER'));
    }

    /**
     * Akcja: próba wylogowania się
     */
    public function logOff() {

      SessionInfo::end();

      return $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
        $this->tra->getText('SUCCESS_LOGOFF'));
    }

    #endregion

  }

?>

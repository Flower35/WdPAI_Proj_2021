<?php

  require_once __DIR__ . '/../ActViewHelper.php';
  require_once __DIR__ . '/../SessionInfo.php';
  require_once 'Controller.php';

  require_once __DIR__ . '/../mdl/User.php';
  require_once __DIR__ . '/../repo/UserRepository.php';
  require_once __DIR__ . '/../mdl/Note.php';
  // require_once __DIR__ . '/../repo/NoteRepository.php';

  /**
   * Kontroler dostępu do ustawień i notatek
   */
  class UserController extends Controller {

    #region Zmienne

    /**
     * Repozytorium wyszukujące użytkowników
     */
    private UserRepository $userRepo;
    // private NoteRepository $noteRepo;

    #endregion

    #region Metody

    /**
     * Konstruktor kontrolera UserController
     */
    public function __construct() {
      parent::__construct();
      $this->userRepo = new UserRepository();
      // $this->noteRepo = new NoteRepository();
    }

    /**
     * Pobiera dane obecnie zalogowanego użytkownika
     * @return array Lista zmiennych do wyświetlenia na stronie
     */
    private function getCurrentUserVars(): array {
      $id = SessionInfo::getUserId();
      $user = $this->userRepo->getUserById($id);
      if (null == $user) {
        return ['id' => $id];
      }
      return [
        'id' => $id,
        'email' => $user->getEmail(),
        'name' => $user->getDisplayName()
      ];
    }

    /**
     * Akcja: Dashboard
     */
    public function browsing() {
      if ($this->validateSession()) {
        $vars = $this->GetCurrentUserVars();

        $notes = array();
        $tempNote = new Note();
        array_push($notes, $tempNote->setName('Pusta notatka'));
        $tempNote = new Note();
        array_push($notes, $tempNote->setName('Notatka #2'));

        $this->render(AVHelper::VIEW_BROWSING, ['user' => $vars, 'notes' => $notes]);
      }
    }

    /**
     * Akcja: Zmiana ustawień użytkownika
     */
    public function settings() {
      if ($this->validateSession()) {
        $vars = $this->GetCurrentUserVars();

        $this->render(AVHelper::VIEW_SETTINGS, ['user' => $vars]);
      }
    }

    /**
     * Akcja: Edycja notatki
     */
    public function note() {
      if ($this->validateSession()) {
        $vars = $this->GetCurrentUserVars();

        $this->render(AVHelper::VIEW_EDITING, ['user' => $vars]);
      }
    }

    /**
     * Akcja: Użytkownik zmienił dane swoje
     */
    public function onUserUpdate() {
      if ($this->validateSession()) {

        if (!$this->isPost()) {
          // Próba uruchomienia akcji przez niepoprawne żądanie
          return $this->render(AVHelper::VIEW_SETTINGS);
        }

        $messages = array();
        $userId = SessionInfo::getUserId();

        // Odczyt danych
        $name  = $_POST['displayName'] ?? null;
        $pass1 = $_POST['password1'] ?? null;
        $pass2 = $_POST['password2'] ?? null;

        // Czy wpisano nową niepustą nazwę
        if (self::isTextSet($name)) {
          if ($this->userRepo->changeDisplayName($userId, $name)) {
            array_push($messages, $this->tra->getFormattedText('UPDATE_USERNAME_SUCCESS', array($name)));
          } else {
            array_push($messages, $this->tra->getText('UPDATE_USERNAME_FAIL'));
          }
        }

        // Czy wpisano niepuste hasła
        if (self::isTextSet($pass1) && self::isTextSet($pass2)) {
          if ($pass1 != $pass2) {
            array_push($messages, $this->tra->getText('ERROR_REGISTER_PASSMISS'));
          } else {
            if ($this->userRepo->changePassword($userId, hash('sha256', $pass1))) {
              array_push($messages, $this->tra->getText('UPDATE_USERPASS_SUCCESS'));
            } else {
              array_push($messages, $this->tra->getText('UPDATE_USERPASS_FAIL'));
            }
          }
        }

        $vars = $this->GetCurrentUserVars();
        $this->render(AVHelper::VIEW_SETTINGS, ['messages' => $messages, 'user' => $vars]);
      }
    }

    /**
     * Akcja: Użytkownik usuwa się
     */
    public function onUserRemove() {
      if ($this->validateSession()) {

        if (!$this->isPost()) {
          // Próba uruchomienia akcji przez niepoprawne żądanie
          return $this->render(AVHelper::VIEW_SETTINGS);
        }

        $userId = SessionInfo::getUserId();

        if ($this->userRepo->removeUser($userId)) {
          SessionInfo::end();

          return $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
            $this->tra->getText('SUCCESS_LOGOFF'));
        } else {
          $vars = $this->GetCurrentUserVars();
          $messages = array($this->tra->getFormattedText('REMOVE_USER_FAIL', array($userId, $vars['mail'])));
          $this->render(AVHelper::VIEW_SETTINGS, ['messages' => $messages, 'user' => $vars]);
        }
      }
    }

    #endregion

  }

?>

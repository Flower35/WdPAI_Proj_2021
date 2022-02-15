<?php

  require_once __DIR__ . '/../ActViewHelper.php';
  require_once __DIR__ . '/../SessionInfo.php';
  require_once 'Controller.php';

  require_once __DIR__ . '/../mdl/User.php';
  require_once __DIR__ . '/../repo/UserRepository.php';
  require_once __DIR__ . '/../mdl/Note.php';
  require_once __DIR__ . '/../repo/NoteRepository.php';

  /**
   * Kontroler dostępu do ustawień i notatek
   */
  class UserController extends Controller {

    #region Zmienne

    /**
     * Repozytorium wyszukujące użytkowników
     */
    private UserRepository $userRepo;
    private NoteRepository $noteRepo;

    #endregion

    #region Metody

    /**
     * Konstruktor kontrolera UserController
     */
    public function __construct() {
      parent::__construct();
      $this->userRepo = new UserRepository();
      $this->noteRepo = new NoteRepository();
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

        $this->render(AVHelper::VIEW_BROWSING, ['user' => $vars]);
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

    #endregion

  }

?>

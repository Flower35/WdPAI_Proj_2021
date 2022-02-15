<?php

  require_once __DIR__ . '/../ActViewHelper.php';
  require_once 'Controller.php';

  require_once __DIR__ . '/../SessionInfo.php';

  /**
   * Kontroler domyślny (logowanie i rejestracja)
   */
  class DefaultController extends Controller {

    /**
     * Akcja domyślna: Strona główna
     */
    public function defaultAction() {
      $this->homeCheckSession();
    }

    /**
     * Akcja: Strona logowania
     */
    public function home() {
      $this->homeCheckSession();
    }

    /**
     * Akcja: Logowanie wraz ze sprawdzeniem sesji
     */
    private function homeCheckSession() {
      // Kiedy użytkownik nie jest zalogowany
      // lub kiedy wygaśnie sesja logowania,
      // zostanie wyświetlony ekran logowania
      if ($this->validateSession(false)) {
        self::enterDashboard();
      }
    }

    /**
     * Akcja: Strona rejestracji
     */
    public function registration() {
      $this->render(AVHelper::VIEW_REGISTRATION);
    }

    /**
     * Akcja: Zmiana języka (bez wyświetlania zawartości)
     */
    public function changeLang() {

      if (!$this->isPost()) {
        return self::enterDashboard();
      }

      $this->tra->setLang($_POST['code'] ?? '');
    }

  }

?>

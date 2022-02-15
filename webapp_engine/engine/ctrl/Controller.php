<?php

  require_once __DIR__ . '/../ActViewHelper.php';

  require_once __DIR__ . '/../Translations.php';

  /**
   * Kontroler wykonujący wybraną akcję
   */
  class Controller {

    #region Zmienne

    /**
     * Rodzaj żądania HTTP (GET, POST, PUT, DELETE)
     */
    private $request;

    /**
     * Odnośnik do bazy tekstów tłumaczonych.
     */
    protected Translations $tra;

    #endregion

    #region Metody

    /**
     * Konstruktor klasy Controller
     */
    public function __construct() {
      $this->request = $_SERVER['REQUEST_METHOD'];
      $this->tra = Translations::getInstance();
    }

    /**
     * Sprawdzenie rodzaju żądania HTTP
     * @return bool Prawda jeśli metodą było GET
     */
    protected function isGet(): bool {
      return 'GET' === $this->request;
    }

    /**
     * Sprawdzenie rodzaju żądania HTTP
     * @return bool Prawda jeśli metodą było POST
     */
    protected function isPost(): bool {
      return 'POST' === $this->request;
    }

    /**
     * Renderowanie konkretnego widoku
     * @param string $template Nazwa szablonu do wyrenderowania
     * @param array  $variables Zmienne przekazywane do szablonu
     * @return void
     */
    protected function render(string $template = null, array $variables = []): void {
      $templatePath = 'views/'. $template.'.php';
      $output = 'File "' . $templatePath . '"not found';

      if(file_exists($templatePath)) {

        extract($variables);

        // "$title" jest przypisane, jeśli nie było dostępu
        // do bazy danych w momencie uruchomienia aplikacji.
        if (!isset($title1)) {
          $title1 = $this->tra->getText('TITLE_' . strtoupper($template));

          $available_langs = $this->tra->getLangs();

          $additional_vars = AVHelper::getViewVars($template);
          $additional_vars = $this->tra->mapTranslations($additional_vars);
          extract($additional_vars);
        }

        ob_start();
        include $templatePath;
        $output = ob_get_clean();
      }

      print $output;
    }

    /**
     * Domyślna akcja
     */
    public function defaultAction() {
      $this->render(AVHelper::VIEW_DATABASE_UNREACHABLE,
        ['title1' => 'Database unreachable']);
    }

    /**
     * Upewnij się że sesja użytkownika jest aktywna
     * @param  bool $prompt Czy należy przypomnieć użytkownikowi
     *  że musi być zalogowany aby mieć dostęp do danej strony
     * @return bool Prawda, jeśli nie upłynął limit sesji
     *  i dowolny użytkownik jest zalogowany, w przeciwnym razie
     *  wyświetlany jest widok logowania z ekranu startowego
     */
    protected function validateSession(bool $prompt = true): bool {

      if (SessionInfo::isLoggedIn()) {

        if (SessionInfo::hasExpired()) {

          SessionInfo::end();

          $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
            $this->tra->getText('SESSION_EXPIRED'));

          return false;

        } else {

          SessionInfo::refreshTimeout();
          return true;
        }

      } elseif ($prompt) {

        $this->renderWithMessage(AVHelper::VIEW_LOGGING_IN,
          $this->tra->getText('SESSION_REQUIRED'));

        return false;

      } else {

        $this->render(AVHelper::VIEW_LOGGING_IN);
        return false;
      }
    }

    /**
     * Przeskoczenie do dashboardu z notatkami
     * (użytkownik musi być zalogowany)
     * @return void
     */
    protected static function enterDashboard(): void {
      $url = "http://$_SERVER[HTTP_HOST]";
      header("Location: {$url}/" . AVHelper::ACT_BROWSING);
    }

    /**
     * Renderowanie widoku z wiadomością zwrotną
     *
     * @param  string $view Szablon widoku do wyrenderowania
     * @param  array  $message Wiadomość do wypisania w szablonie
     * @return void
     */
    protected function renderWithMessage(string $view, string $message) {
      $this->render($view, ['messages' => [$message]]);
    }

    /**
     * Sprawdza czy przekazana wartość jest ustawiona
     *  i nie jest pustym tekstem.
     *
     * @param  mixed $text Sprawdzany tekst
     * @return bool Prawda jeśli tekst jest poprawny i niepusty
     */
    protected static function isTextSet(?string $text): bool {
      return
        isset($text) &&
        ("" != trim($text))  &&
        (!empty($text) || (0 == trim($text)));
    }

    #endregion

  }

?>

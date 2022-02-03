<?php

  class Controller {

    private $request;

    public function __construct() {
      $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool {
      return 'GET' === $this->request;
    }

    protected function isPost(): bool {
      return 'POST' === $this->request;
    }

    protected function render(string $template = null, array $variables = []) {
        $templatePath = 'views/'. $template.'.php';
        $output = 'File "' . $templatePath . '"not found';

        if(file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }

}

?>

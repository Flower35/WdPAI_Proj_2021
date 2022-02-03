<!DOCTYPE html>
<html lang="pl">
<head>
  <title>Rejestracja nowego użytkownika</title>
  <link rel="stylesheet" type="text/css" href="styling/default.css" />
</head>
<body>
  <div id="witryna">
    <img src="images/reko.png" />
    <div class="login-container">
      <form class="login" action="onRegister" method="POST">
        <div class="messages">
          <?php
            if(isset($messages)) {
              foreach($messages as $message) {
                echo $message;
              }
            }
          ?>
        </div>
        <span>Podaj swój e-mail:</span>
        <input name="email" type="text" placeholder="email@email.com"><br />
        <span>Podaj hasło:</span>
        <input name="password1" type="password" placeholder="password"><br />
        <span>Powtórz hasło:</span>
        <input name="password2" type="password" placeholder="password"><br />
        <button type="submit">REGISTER</button><br />
      </form>
    </div>
  </div>
</body>
</html>

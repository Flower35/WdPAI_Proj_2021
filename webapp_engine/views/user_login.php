<!DOCTYPE html>
<html lang="pl">
<head>
  <title>Strona logowania</title>
  <link rel="stylesheet" type="text/css" href="styling/default.css" />
</head>
<body>
  <div id="witryna">
    <img src="images/reko.png" />
    <div class="login-container">
      <form class="login" action="onLogin" method="POST">
        <div class="messages">
          <?php
            if(isset($messages)) {
              foreach($messages as $message) {
                echo $message;
              }
            }
          ?>
        </div>
        <input name="email" type="text" placeholder="email@email.com"><br />
        <input name="password" type="password" placeholder="password"><br />
        <button type="submit">LOGIN</button><br />
      </form>
      <form action="registration" method="POST">
        <p>Nie masz jeszcze konta?</p>
        <button type="submit">Zarejestruj się</button>
      </form>
    </div>
  </div>
</body>
</html>

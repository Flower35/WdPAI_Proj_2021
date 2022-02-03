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
      <form class="login" action="login" method="POST">
        <div class="messages">
          <?php
            if(isset($messages)) {
              foreach($messages as $message) {
                echo $message;
              }
            }
          ?>
        </div>
        <input name="email" type="text" placeholder="email@email.com">
        <input name="password" type="password" placeholder="password">
        <button type="submit">LOGIN</button>
      </form>
    </div>
  </div>
</body>
</html>

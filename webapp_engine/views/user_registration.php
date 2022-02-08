<?php
  $title1 = 'Rejestracja';
  $title2 = 'Create your account!';
  include 'header.php';
?>
    <div class="catsite-logon-row catsite-background-night">
      <div class="catsite-logon-col catsite-logon-imgcol">
        <img src="../images/rdj-waits.png" />
      </div>
      <div class="catsite-logon-col">
        <?php if (isset($messages) && count($messages) > 0) {
          echo '<br />';
          echo '<div class="catsite-logon-messages">';
          foreach ($messages as $message) {
            echo '<span>' . $message . '</span>';
          }
          echo '</div>';
        } ?>
        <br />
        <form action="onRegister" method="POST">
          <input name="email" required type="text" placeholder="adres e-mail">
          <input name="password1" required type="password" placeholder="password">
          <input name="password2" required type="password" placeholder="confirm password">
          <button type="submit">Registeruj</button>
        </form>
        <br />
      </div>
    </div>
<?php include 'footer.php'; ?>

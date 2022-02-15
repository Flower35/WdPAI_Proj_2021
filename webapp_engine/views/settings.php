<?php
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
        <form action="onUserUpdate" method="POST">
          <span>Your avatar:</span>
          <img src="images/user.png"/>
          <input name="avatar" required type="file" placeholder="twój awatar">
          <button type="submit">Aktualizuj</button>
        </form>
        <br />
        <form action="onUserUpdate" method="POST">
          <input name="displayName" type="text" placeholder="nazwa wyświetlana">
          <input name="password1" type="password" placeholder="nowe password">
          <input name="password2" type="password" placeholder="confirm password">
          <button type="submit">Aktualizuj</button>
        </form>
        <br />
        <form action="onUserRemove" method="POST">
          <button type="submit">Zniszcz konto</button>
        </form>
        <br />
      </div>
    </div>
<?php include 'footer.php'; ?>

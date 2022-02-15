<?php
  $title1 = 'User settings';
  $title2 = 'Change your account settings.';
  include 'header.php';
?>
    <div class="catsite-logon-row catsite-background-night">
      <div class="catsite-logon-col catsite-logon-imgcol">
        <img src="../images/rdj-waits.png" />
      </div>
      <div class="catsite-logon-col">
        <br />
        <div class="catsite-logon-messages">
          <span>Amongus!</span>
        </div>
        <br />
        <form action="onUserUpdate" method="POST">
          <span>Your avatar:</span>
          <img src="../avatars/1.png"/>
          <input name="avatar" required type="file" placeholder="twój awatar">
          <button type="submit">Aktualizuj</button>
        </form>
        <br />
        <form action="onUserUpdate" method="POST">
          <input name="displayName" required type="text" placeholder="nazwa wyświetlana">
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

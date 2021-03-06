<?php
  include 'header.php';
?>
    <div class="catsite-logon-row catsite-background-coffee">
      <div class="catsite-logon-col catsite-logon-imgcol">
        <img src="../images/rdj-welcome.png" />
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
        <form action="onLogin" method="POST">
          <input name="email" required type="text" placeholder="<?=$hintMail?>">
          <input name="password" required type="password" placeholder="<?=$hintPass?>">
          <button type="submit"><?=$btnLogin?></button>
        </form>
        <br />
        <form action="registration" method="POST">
          <span><?=$homeQuestion?></span>
          <button type="submit"><?=$btnRegister?></button>
        </form>
        <br />
      </div>
    </div>
<?php include 'footer.php'; ?>

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
        <form action="onRegister" method="POST">
          <input name="email" required type="text" placeholder="<?=$hintMail?>">
          <input name="password1" required type="password" placeholder="<?=$hintPass?>">
          <input name="password2" required type="password" placeholder="<?=$hintPass2?>">
          <input name="human" type="checkbox" ><label for="human"><i><?=$hintRobot?></i></label><br />
          <button type="submit"><?=$btnRegister?></button>
        </form>
        <br />
      </div>
    </div>
<?php include 'footer.php'; ?>

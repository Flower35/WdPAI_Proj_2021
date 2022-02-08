<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Catalog :: <?=$title1?></title>
  <link rel="stylesheet" type="text/css" href="styling/default.css" />
  <link rel="icon" type="image/png" href="images/cat.png" />
</head>
<body>
  <div class="catsite-wrapper">
    <div class="catsite-header">
      <div class="catsite-header-col">
        <a href="home">
          <img class="catsite-header-logo" src="../images/catalog.png" />
        </a>
      </div>
      <div class="catsite-header-col">
        <div class="catsite-header-btns">
        <?php if (isset($user_logged_in) && $user_logged_in) {
          echo '<img class="catsite-header-icon" src="../images/settings.png" />';
          echo '<img class="catsite-header-icon" src="../images/logout.png" />';
        } ?>
        </div>
        <div class="catsite-header-btns">
          <img class="catsite-header-icon" src="../images/language.png" />
        </div>
      </div>
    </div>

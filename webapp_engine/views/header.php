<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Catalog :: <?=$title1?></title>
  <link rel="stylesheet" type="text/css" href="styling/default.css" />
  <link rel="icon" type="image/png" href="images/cat.png" />
  <script type="text/javascript" src="scripting/default.js"></script>
</head>
<body>
  <div class="catsite-wrapper">
    <div class="catsite-header">
      <div class="catsite-header-col">
        <a href="home">
          <img class="catsite-header-logo" src="images/catalog.png" />
        </a>
      </div>
      <div class="catsite-header-col">
        <?php
          if (isset($user)) { include 'header_nav0a.php'; }
          if (isset($available_langs)) { include 'header_nav1a.php'; }
        ?>
      </div>
    </div>
    <?php
      if (isset($user)) { include 'header_nav0b.php'; }
      if (isset($available_langs)) { include 'header_nav1b.php'; }
    ?>

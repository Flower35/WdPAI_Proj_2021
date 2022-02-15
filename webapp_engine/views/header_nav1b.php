<div class="catsite-header-links" id="navMenu1">
  <?php
    foreach($available_langs as $lang) {
      echo "<a href=\"javascript:void(0);\" onclick=\"changeLang('$lang[code]');\">";
      echo "  <img class=\"catsite-header-icon\" src=\"images/language.png\" />";
      echo "  <span>$lang[name]</span>";
      echo "</a>";
    }
  ?>
</div>

<?php
  $title2 = 'Browse your notes.';
  include 'header.php';
?>
    <div class="catsite-browser-row catsite-background-coffee">
      <div class="catsite-browser-nav">
        <br />
        <div class="catsite-browser-messages">
          <span>Wyświetlam wszystkie twoje notatki</span>
        </div>
        <br />
        <form action="browse" method="GET">
          <input type="hidden" name="sort" value="dates" />
          <button type="submit">Sortuj według daty</button>
        </form>
        <br />
        <form action="browse" method="GET">
          <input type="hidden" name="sort" value="names" />
          <button type="submit">Sortuj według nazwy</button>
        </form>
        <br />
        <form action="browse" method="POST">
          <input name="name" required type="text" placeholder="nazwa notatki" />
          <button type="submit">Szukaj</button>
        </form>
      </div>
      <div class="catsite-browser-grid">
        <div>
          <a href="."></a>
          <div class="catsite-browser-plus">+</div>
          <span>Dodaj notatkę</span>
        </div>
        <div>
          <a href="."></a>
          <b>title</b><br /><span>modified: today</span>
        </div>
        <div><a></a><span>note-2</span></div>
        <div><a></a><span>note-3</span></div>
        <div><a></a><span>note-4</span></div>
      </div>
    </div>
<?php include 'footer.php'; ?>

<?php
  $title1 = 'Edycja notatki';
  $title2 = 'Edit your note.';
  $user_logged_in = true;
  include 'header.php';
?>
    <div class="catsite-editor-row catsite-background-sus">
      <div class="catsite-editor-head">
        <div class="catsite-editor-head-col">
          <form action="updateNote" method="POST">
            <p>Edytujesz: <b>Nazwa notatki</b></p>
            <p>Data ostatniej aktualizacji: <b>Dzisiaj</b></p>
            <input name="name" required type="text" placeholder="nowa nazwa" />
            <button type="submit">Zmień</button>
          </form>
        </div>
        <div class="catsite-editor-head-col">
          <form action="updateNote" method="POST">
            <input class="catsite-editor-color" type="color" name="color" />
            <button type="submit">Zmień kolor</button>
          </form>
        </div>
        <div class="catsite-editor-head-col">
          <form action="updateNote" method="POST">
            <input type="hidden" name="delete" value="1" />
            <button type="submit">Skasuj notatkę</button>
          </form>
        </div>
      </div>
      <div class="catsite-editor-table">
        <form action="updateNote" method="POST">
          <input type="hidden" name="table" value="1" />
          <table><tr>
            <th>lorem ipsum</th><th>dolor sit</th><th>amet consectetur</th>
          </tr><tr>
            <th>adipisicing elit</th><th>laudantium quidem</th><th>magnam consequuntur</th>
          </tr><tr>
            <td><input type="text" name="x1y1" /></td>
            <td><input type="text" name="x2y1" /></td>
            <td><input type="text" name="x3y1" /></td>
          </tr><tr>
            <td><input type="text" name="x1y2" /></td>
            <td><input type="text" name="x2y2" /></td>
            <td><input type="text" name="x3y2" /></td>
          </tr></table>
          <button type="submit">Zapisz</button>
        </form>
    </div>
<?php include 'footer.php'; ?>


// Menu nawigacyjne
let navMenuStatus = [false, false];
function navMenu(id) {
  let menu = document.getElementById("navMenu" + id);
  navMenuStatus[id] = !navMenuStatus[id];
  menu.style.display = navMenuStatus[id] ? "block" : "none";
}

// Zmiana języka i odświeżenie ostatniej strony
function changeLang(code) {
  fetch("/changeLang", {
    method: "POST",
    headers: {"Content-type": "application/x-www-form-urlencoded; charset=UTF-8"},
    body: 'code=' + code
  }).then(() => location.reload());
}

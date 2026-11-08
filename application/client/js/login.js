// JavaScript de la pantalla de login.
// Solo hace de interfaz: valida que no falten datos, envía la petición
// al servidor y muestra el resultado. Nunca calcula ni guarda nada.

// Muestra un mensaje en la página
function showMessage(text) {
  document.getElementById("message").textContent = text;
}

// Envía los datos al servidor (POST) y gestiona la respuesta
function sendLogin(user, password) {
  const data = new FormData();
  data.append("user", user);
  data.append("password", password);

  fetch("../server/login.php", { method: "POST", body: data })
    .then(function (response) {
      if (response.ok) {
        // Autenticación correcta: va al menú de operaciones
        window.location.href = "menu.html";
      } else {
        // Autenticación incorrecta: muestra el error y vuelve al inicio
        showMessage("Authentication error: invalid user or password.");
        setTimeout(function () {
          window.location.href = "index.html";
        }, 2000);
      }
    });
}

// Comprueba que no falten datos (control hecho solo en el cliente)
function handleLoginClick() {
  const user = document.getElementById("user").value.trim();
  const password = document.getElementById("password").value;

  if (user === "" || password === "") {
    showMessage("Please enter user name and password.");
    return;
  }
  sendLogin(user, password);
}

// Asocia la función al evento click del botón
document.getElementById("loginButton").addEventListener("click", handleLoginClick);

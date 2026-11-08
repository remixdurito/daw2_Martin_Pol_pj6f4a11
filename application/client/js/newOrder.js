// JavaScript de la pantalla de nueva comanda.
// Solo hace de interfaz: activa/desactiva campos, valida que no falten
// datos, envía el formulario al servidor y muestra el resultado.
// El cálculo del precio con IVA lo hace siempre el servidor (PHP).

// Habilita o deshabilita el campo de cantidad según el checkbox
function toggleQuantity(event) {
  const row = event.target.closest("tr");
  const quantity = row.querySelector('input[type="number"]');
  quantity.disabled = !event.target.checked;
}

// Muestra un mensaje de error
function showMessage(text) {
  document.getElementById("message").textContent = text;
}

// Comprueba que no falten datos (solo control en el cliente, sin cálculos)
function isFormComplete() {
  const ids = ["orderId", "fullName", "address", "email", "phone"];
  for (let i = 0; i < ids.length; i++) {
    if (document.getElementById(ids[i]).value.trim() === "") {
      return false;
    }
  }
  return document.querySelectorAll(".productCheck:checked").length > 0;
}

// Envía el formulario al servidor (POST) y muestra el resultado
function sendOrder() {
  const data = new FormData(document.getElementById("orderForm"));

  fetch("../server/createOrder.php", { method: "POST", body: data })
    .then(function (response) {
      if (response.ok) {
        // Comanda guardada: el servidor devuelve solo el precio con IVA
        response.text().then(function (total) {
          document.getElementById("result").textContent =
            "Order saved. Total price with 21% VAT: " + total + " €";
        });
      } else {
        // Error 404: el servidor devuelve una página de error completa
        response.text().then(function (html) {
          document.open();
          document.write(html);
          document.close();
        });
      }
    });
}

// Gestiona el clic del botón de envío
function handleSendClick() {
  showMessage("");
  document.getElementById("result").textContent = "";

  if (!isFormComplete()) {
    showMessage("Please fill in all the fields and select at least one product.");
    return;
  }
  sendOrder();
}

// Asocia los eventos: un evento "change" por cada checkbox de producto,
// y un evento "click" para el botón de enviar
const checks = document.querySelectorAll(".productCheck");
for (let i = 0; i < checks.length; i++) {
  checks[i].addEventListener("change", toggleQuantity);
}
document.getElementById("sendButton").addEventListener("click", handleSendClick);

window.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".typing-area");
  const inputChat = form.querySelector(".input-chat");
  const sendBtn = form.querySelector("button");
  const chatBox = document.querySelector(".chat-box");

  sendBtn.addEventListener("click", function (e) {
    e.preventDefault();

    //AJAX
    let xhr = new XMLHttpRequest(); //Creamos el objeto XML
    xhr.open("POST", "chatNuevoMensaje.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          inputChat.value = ""; //Tras enviar el mensaje, se limpia el campo de texto
        }
      }
    };
    //Enviar los datos a php a través de AJAX
    let formData = new FormData(form); //Creamos el objeto FormData
    xhr.send(formData); //Lo mandamos al php
  });

  setInterval(() => {
    //AJAX
    let xhr = new XMLHttpRequest(); //Creamos el objeto XML
    xhr.open("POST", "chatActualizar.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          chatBox.innerHTML = data;
        }
      }
    };
    //Enviar los datos a php a través de AJAX
    let formData = new FormData(form); //Creamos el objeto FormData
    xhr.send(formData); //Lo mandamos al php
  }, 250);
});

//CONFIRMACIÓN EN BOTONES DE ACCIONES PELIGROSAS

function eliminarReserva(id_reserva){
    var opcion = confirm("¿Estás seguro de que quieres eliminar la reserva?");
    if (opcion == true) {
        window.location.href = "includes/src/procesarPropiedades/eliminarReserva.php?id_reserva=" + id_reserva;
    }
}

function eliminarCuenta(id_usuario){
    var opcion = confirm("¿Estás seguro de que quieres eliminar la cuenta?");
    if (opcion == true) {
        window.location.href = "includes/src/procesarUsuario/eliminarUsuario.php?id_usuario=" + id_usuario;
    }
}

function eliminarPropiedad(id_casa){
    var opcion = confirm("¿Estás seguro de que quieres eliminar la propiedad?");
    if (opcion == true) {
        window.location.href = "includes/src/procesarPropiedades/eliminarPropiedad.php?id_casa=" + id_casa;
    }
}

function eliminarValoracion(id_valoracion){
    var opcion = confirm("¿Estás seguro de que quieres eliminar esta valoracion?");
    if (opcion == true) {
        window.location.href = "includes/src/procesarPropiedades/eliminarValoracion.php?id_valoracion=" + id_valoracion;
    }
}

//SLIDER FOTOS

let indice = 1;
function siguiente(n) {
    mostrar(indice += n);
}

function actual(n) {
    mostrar(indice = n);
}

function mostrar(n) {
    let i;
    let slides = document.getElementsByClassName('slider');
    let puntos = document.getElementsByClassName('punto');
    if (n > slides.length) {indice = 1}    
    if (n < 1) {indice = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';  
    }
    for (i = 0; i < puntos.length; i++) {
        puntos[i].className = puntos[i].className.replace(' active', '');
    }
    slides[indice-1].style.display = 'block';  
    puntos[indice-1].className += ' active';
}

// Enviar valoracion 

function mensajeValoracion(tipo, mensaje) {
    const divMensaje = document.getElementById('div-mensaje');
    divMensaje.innerHTML = mensaje;
    divMensaje.className = tipo;
  }

//VALIDAR FORMULARIOS

function validarLogin(formulario) {
    if ((formulario.email.value != "") && !(/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/.test(formulario.email.value))){ //validar el correo
        alert("La dirección de correo electrónico no es válida" );
        formulario.email.focus();
        return false; // Cancela el envío
    }
}

function validarRegistro(formulario){
    if ((formulario.email.value != "") && !(/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/.test(formulario.email.value))){ //validar el correo
        alert("La dirección de correo electrónico no es válida" );
        formulario.email.focus();
        return false; // Cancela el envío
    }
    if((formulario.password.value != "") && (formulario.password2.value != "") && (formulario.password.value != formulario.password2.value)){ //validar contraseñas
        alert("Las contraseñas deben coincidir!" );
        formulario.password.focus();
        formulario.password2.focus();
        return false; // Cancela el envío
    }
    if((formulario.telefono.value != "") && !(/^\d{9}$/.test(formulario.telefono.value))){ //validar telefono
        alert("El número de teléfono no es válido!" );
        formulario.telefono.focus();
        return false; // Cancela el envío
    }
}

function validarValoracion( form ) {
    if( form.estrellas.value == "" ) {
        mensajeValoracion('error', 'Debes seleccionar una valoración');
        form.estrellas.focus();
        return false;
    }
    if( form.opinion.value == "" ) {
        mensajeValoracion('error', 'Debes escribir un comentario');
        form.opinion.focus();
        return false;
    }
    return true;
}

function validarCambioContraseña(formulario){
    if((formulario.password.value != "") && (formulario.password2.value != "") && (formulario.password.value != formulario.password2.value)){ //validar contraseñas
        alert("Las contraseñas deben coincidir!" );
        formulario.password.focus();
        formulario.password2.focus();
        return false; // Cancela el envío
    }
}

function validarEdicionDatos(formulario){
    if((formulario.telefono.value != "") && !(/^\d{9}$/.test(formulario.telefono.value))){ //validar telefono
        alert("El número de teléfono no es válido!" );
        formulario.telefono.focus();
        return false; // Cancela el envío
    }
}

function validarReserva(formulario){
    if((formulario.fecha_entrada.value > formulario.fecha_salida.value) && (formulario.fecha_entrada.value != "") && (formulario.fecha_salida.value != "")){ //validar fechas
        alert("La fecha de salida debe ser posterior a la fecha de entrada!");
        formulario.fecha_entrada.focus();
        formulario.fecha_salida.focus();
        return false;
    }
    if((formulario.fecha_entrada.value == formulario.fecha_salida.value) && (formulario.fecha_entrada.value != "") && (formulario.fecha_salida.value != "")){
        alert("La fecha de entrada no puede coincidir con la de salida!");
        formulario.fecha_entrada.focus();
        formulario.fecha_salida.focus();
        return false;
    }
}

//VALORACIONES RADIO BUTTONS
function updateValoracion(estrellas) {
    const estrellasInput = document.querySelector('#estrellas');
    estrellasInput.value = estrellas;
  }
  
  const radios = document.querySelectorAll('input[name="rating"]');
  
  radios.forEach((radio) => {
    radio.addEventListener('click', () => {
      const estrellas = radio.value;
      updateValoracion(estrellas);
    });
  });
  
  
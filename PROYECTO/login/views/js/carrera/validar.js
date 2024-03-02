// document.getElementById('task-form').addEventListener('submit', function(event) {
//   var codigo = document.getElementById('codigo').value;
//   var codigoPattern = /^[0-9]{1,4}$/;
  
//   if (!codigoPattern.test(codigo)) {
//     alert('El campo código debe ser solo números y maximo 4 en total, por ejemplo : 3325, 2555, 1234');
//     event.preventDefault();
//   }
// });



// const form = document.getElementById('task-form');
// const codigo = document.getElementById('codigo');
// const programa = document.getElementById('nombre');
// const iconos = document.querySelectorAll('.icono i');

// form.addEventListener('submit', function(event) {
//   event.preventDefault();

//   if (validarCodigo() || validarPrograma()) {
//     form.submit();
//       alert('¡Se ha registrado con éxito!');
//   }
// });

// function validarCodigo() {
    
//   const codigoValue = codigo.value.trim();

//   if (codigoValue === '') {
//     mostrarError(codigo, 'El campo no puede estar vacío');
//     return false;
//   } else if (!/^[0-9]{4}$/.test(codigoValue)) {
//     mostrarError(codigo, 'Deben ser datos numericos y 4 en total');
//     return false;
//   } else {
//     mostrarExito(codigo);
//     return true;
//   }
// }

// function validarPrograma() {
//   const programaValue = programa.value.trim();

//   if (programaValue === '') {
//     mostrarError(programa, 'El campo no puede estar vacío');
//     return false;
//   } else if (!/^[a-zA-Z]+$/.test(programaValue)) {
//     mostrarError(programa, 'El programa solo puede contener letras alfabéticas');
//     return false;
//   } else {
//     mostrarExito(programa);
//     return true;
//   }
// }

// function mostrarError(campo, mensaje) {
//   campo.classList.add('error');
//   campo.classList.remove('exito');
//   campo.nextElementSibling.innerHTML = mensaje;
//   campo.nextElementSibling.style.color = '#ff4d4d';
//   iconos[campo.id === 'codigo' ? 0 : 1].classList.remove('fa-check-circle');
//   iconos[campo.id === 'codigo' ? 0 : 1].classList.add('fa-times-circle');
// }

// function mostrarExito(campo) {
//   campo.classList.remove('error');
//   campo.classList.add('exito');
//   campo.nextElementSibling.innerHTML = '';
//   iconos[campo.id === 'codigo' ? 0 : 1].classList.remove('fa-times-circle');
//   iconos[campo.id === 'codigo' ? 0 : 1].classList.add('fa-check-circle');
// }

// codigo.addEventListener('blur', validarCodigo);
// programa.addEventListener('blur', validarPrograma);


const form = document.getElementById('task-form');
const codigo = document.getElementById('codigo');
const lapso = document.getElementById('nombre');
const iconos = document.querySelectorAll('.icono i');

form.addEventListener('submit', function(event) {
  event.preventDefault();

  if (validarCodigo() || validarLapso()) {
    form.submit();
  }
});

function validarCodigo() {
    
  const codigoValue = codigo.value.trim();

  if (codigoValue === '') {
    mostrarError(codigo, 'El campo no puede estar vacío');
    return false;
  } else if (!/^[0-9]+$/.test(codigoValue)) {
    mostrarError(codigo, 'El campo debe contener solo números');
    return false;
  } else {
    mostrarExito(codigo);
    return true;
  }
}

function validarLapso() {
    
  const lapsoValue = lapso.value.trim();

  if (lapsoValue === '') {
    mostrarError(lapso, 'El campo no puede estar vacío');
    return false;
    }else if (!/^[0-9_-]+$/.test(lapsoValue)) {
        mostrarError(lapso, 'Debe contener solo números y guion');
        return false;
    }else {
    mostrarExito(lapso);
    return true;
  }
}

function mostrarError(campo, mensaje) {
  campo.classList.add('error');
  campo.classList.remove('exito');
  campo.nextElementSibling.innerHTML = mensaje;
  campo.nextElementSibling.style.color = '#ff4d4d';
  iconos[campo.id === 'codigo' ? 0 : 1].classList.remove('fa-check-circle');
  iconos[campo.id === 'codigo' ? 0 : 1].classList.add('fa-times-circle');
}

function mostrarExito(campo) {
  campo.classList.remove('error');
  campo.classList.add('exito');
  campo.nextElementSibling.innerHTML = '';
  iconos[campo.id === 'codigo' ? 0 : 1].classList.remove('fa-times-circle');
  iconos[campo.id === 'codigo' ? 0 : 1].classList.add('fa-check-circle');
}

codigo.addEventListener('blur', validarCodigo);
lapso.addEventListener('blur', validarLapso);
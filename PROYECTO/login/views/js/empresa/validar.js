const form = document.getElementById('task-form');
const rif = document.getElementById('rif');
const empresa = document.getElementById('nombre');
const direccion = document.getElementById('direccion');
const nombre_contacto = document.getElementById('nombre_contacto');
const telefono_contacto = document.getElementById('telefono_contacto');
const telefono_empresa = document.getElementById('telefono_empresa');
const iconos = document.querySelectorAll('.icono i');

form.addEventListener('submit', function(event) {
  event.preventDefault();

  if (validarFormulario()) {
    form.submit();
    alert('¡Se ha registrado con éxito!');
  }
});

function validarFormulario() {
  const rifValido = validarRif();
  const empresaValida = validarEmpresa();
  const direccionValida = validarDireccion();
  const nombreContactoValido = validarNombre_contacto();
  const telefonoContactoValido = validarTelefono_contacto();
  const telefonoEmpresaValido = validarTelefono_empresa();


}

function validarRif() {
  const rifValue = rif.value.trim();
  const alphanumericRegex = /^[a-zA-Z0-9]*$/; // Expresión regular para validar que solo se admiten caracteres alfanuméricos

  if (rifValue === '') {
    mostrarError(rif, 'El campo no puede estar vacío');
    return false;
  } else if (!alphanumericRegex.test(rifValue)) {
    mostrarError(rif, 'El campo solo puede contener números y letras');
    return false;
  } else {
    mostrarExito(rif);
    return true;
  }
}

function validarEmpresa() {
  const empresaValue = empresa.value.trim();
  const empresaRegex = /^[a-zA-Z0-9\s]*$/; // Expresión regular para validar empresa

  if (empresaValue === '') {
    mostrarError(empresa, 'El campo no puede estar vacío');
    return false;
  } else if (!empresaRegex.test(empresaValue)) {
    mostrarError(empresa, 'El campo solo debe contener números y letras');
    return false;
  } else {
    mostrarExito(empresa);
    return true;
  }
}

function validarDireccion() {
  const direccionValue = direccion.value.trim();
  const alphanumericRegex = /^[a-zA-Z0-9]*$/; // Expresión regular para validar que solo se admiten caracteres alfanuméricos

  if (direccionValue === '') {
    mostrarError(direccion, 'El campo no puede estar vacío');
    return false;
  } else if (!alphanumericRegex.test(direccionValue)) {
    mostrarError(direccion, 'El campo solo puede contener números y letras');
    return false;
  } else {
    mostrarExito(direccion);
    return true;
  }
}

function validarNombre_contacto() {
  const nombre_contactoValue = nombre_contacto.value.trim();
  const alphanumericRegex = /^[a-zA-Z]*$/; // Expresión regular para validar que solo se admiten caracteres alfanuméricos

  if (nombre_contactoValue === '') {
    mostrarError(nombre_contacto, 'El campo no puede estar vacío');
    return false;
  } else if (!alphanumericRegex.test(nombre_contactoValue)) {
    mostrarError(nombre_contacto, 'El campo solo puede contener letras');
    return false;
  } else {
    mostrarExito(nombre_contacto);
    return true;
  }
}

function validarTelefono_contacto() {
  const telefono_contactoValue = telefono_contacto.value.trim();
  const alphanumericRegex = /^\d{12}$/; // Expresión regular para validar que solo se admiten caracteres alfanuméricos

  if (telefono_contactoValue === '') {
    mostrarError(telefono_contacto, 'El campo no puede estar vacío');
    return false;
  } else if (!alphanumericRegex.test(telefono_contactoValue)) {
    mostrarError(telefono_contacto, 'El campo solo puede contener numeros y 12 en total');
    return false;
  } else {
    mostrarExito(telefono_contacto);
    return true;
  }
}

function validarTelefono_empresa() {
  const telefono_empresaValue = telefono_empresa.value.trim();
  const alphanumericRegex = /^\d{12}$/; // Expresión regular para validar que solo se admiten caracteres alfanuméricos

  if (telefono_empresaValue === '') {
    mostrarError(telefono_empresa, 'El campo no puede estar vacío');
    return false;
  } else if (!alphanumericRegex.test(telefono_empresaValue)) {
    mostrarError(telefono_empresa, 'El campo solo puede contener numeros y 12 en total');
    return false;
    } else {
    mostrarExito(telefono_empresa);
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
    
    rif.addEventListener('blur', validarRif);
    empresa.addEventListener('blur', validarEmpresa);
    direccion.addEventListener('blur', validarDireccion)
    nombre_contacto.addEventListener('blur', validarNombre_contacto)
    telefono_contacto.addEventListener('blur', validarTelefono_contacto)
    telefono_empresa.addEventListener('blur', validarTelefono_empresa)


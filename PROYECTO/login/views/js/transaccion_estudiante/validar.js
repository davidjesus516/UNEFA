function validateInputs() {
  const searchInput = document.getElementById("search");
  const docenteSearchInput = document.getElementById("docenteSearch");
  const tutorSearchInput = document.getElementById("tutorSearch");

  const regex = /^\d{1,8}$/;

  if (!regex.test(searchInput.value)) {
    alert("El campo 'Cédula del Estudiante' debe contener solo números y tener una longitud de 8 caracteres.");
    return false;
  }

  if (!regex.test(docenteSearchInput.value)) {
    alert("El campo 'Docente' debe contener solo números y tener una longitud de 8 caracteres.");
    return false;
  }

  if (!regex.test(tutorSearchInput.value)) {
    alert("El campo 'Tutor Empresarial' debe contener solo números y tener una longitud de 8 caracteres.");
    return false;
  }

  return true;
}

const form = document.querySelector('form');
form.addEventListener('submit', (event) => {
  if (!validateInputs()) { // Agrega la validación
    event.preventDefault(); // Previene el envío del formulario si los campos no son válidos
    return false;
  }
});
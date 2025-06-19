document.addEventListener("DOMContentLoaded", function () {
  // Asegúrate de que window.dialog apunte al elemento dialog
  window.dialog = document.getElementById('dialog');

  // SweetAlert2 Helper Functions (copiadas de la solución anterior)
  function mostrarMensajeExito(mensaje, callback) {
    Swal.fire({
      icon: 'success',
      title: 'Éxito',
      text: mensaje,
      allowOutsideClick: false,
      allowEscapeKey: false
    }).then(() => {
      if (typeof callback === 'function') {
        callback();
      }
    });
  }

  function mostrarMensajeError(mensaje, callback) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: mensaje,
      allowOutsideClick: false,
      allowEscapeKey: false
    }).then(() => {
      if (typeof callback === 'function') {
        callback();
      }
    });
  }

  // Tu código existente
  let message = document.querySelector('.message'); // Se mantiene si lo usas en el HTML para otros fines
  const expresiones = {
    codigo: /^[0-9]{3,10}$/, // 3-10 solo números
    nombre: /^[a-zA-ZÀ-ÿ\s]{5,100}$/, // 5-100 letras y espacios
    nota: /^(?:[0-9]|1[0-9]|20)(?:\.\d{1,2})?$/, // 0-20, decimales opcionales
    abreviatura: /^[a-zA-Z0-9-]{2,15}$/ // 2-15 caracteres alfanuméricos y guiones
  };

  function isCorrect(id) {
    const grupo = document.getElementById(id);
    if (!grupo) return;
    grupo.classList.add("formulario__grupo-correcto");
    grupo.classList.remove("formulario__grupo-incorrecto");
    const icon = grupo.querySelector('i');
    if (icon) {
      icon.classList.add("fa-check-circle");
      icon.classList.remove("fa-times-circle");
    }
    const errorMsg = grupo.querySelector('.formulario__input-error');
    if (errorMsg) errorMsg.classList.remove("formulario__input-error-activo");
  }

  function isIncorrect(id, message) {
    const grupo = document.getElementById(id);
    if (!grupo) return;
    grupo.classList.add("formulario__grupo-incorrecto");
    grupo.classList.remove("formulario__grupo-correcto");
    const icon = grupo.querySelector('i');
    if (icon) {
      icon.classList.add("fa-times-circle");
      icon.classList.remove("fa-check-circle");
    }
    const errorMsg = grupo.querySelector('.formulario__input-error');
    if (errorMsg) {
      errorMsg.classList.add("formulario__input-error-activo");
      if (message) errorMsg.textContent = message;
    }
  }

  function validateInput(input, regex, id, message) {
    if (regex.test(input.value)) {
      isCorrect(id);
      return true;
    } else {
      isIncorrect(id, message || 'El campo no es válido');
      return false;
    }
  }

  async function validateForm() {
    let errores = false;
    // La validación de existencia se hará en tiempo real y el submit la validará de nuevo
    // Si codigoExiste o nombreExiste regresan true, ya habrán marcado el campo como incorrecto.
    // Aquí solo nos aseguramos que el campo no esté marcado como incorrecto por una validación en tiempo real fallida.

    // Validar código
    if (!validateInput(document.getElementById('codigo'), expresiones.codigo, 'grupo__codigo', 'El código debe contener entre 3 y 10 caracteres numéricos')) {
      errores = true;
    }
    // Validar nombre
    if (!validateInput(document.getElementById('nombre'), expresiones.nombre, 'grupo__nombre', 'El nombre debe contener entre 5 y 100 caracteres alfanuméricos')) {
      errores = true;
    }
    // Validar nota
    if (!validateInput(document.getElementById('nota'), expresiones.nota, 'grupo__nota', 'La nota debe estar entre 0 y 20')) {
      errores = true;
    }
    // Validar abreviatura
    if (!validateInput(document.getElementById('abreviatura'), expresiones.abreviatura, 'grupo__abreviatura', 'La abreviatura debe tener entre 2 y 15 caracteres alfanuméricos y guiones.')) {
      errores = true;
    }
    // Validar tipos de pasantías
    const tipos = document.querySelectorAll('input[name="tipos_pasantias"]:checked');
    if (tipos.length === 0) {
      isIncorrect('grupo__tipos_pasantias', 'Seleccione al menos un tipo de práctica');
      errores = true;
    } else {
      isCorrect('grupo__tipos_pasantias');
    }

    // Adicionalmente, validar que no existan el código o nombre en la base de datos
    if (await codigoExiste() || await nombreExiste()) {
      errores = true;
    }

    return !errores;
  }

  async function codigoExiste() {
    const codigoInput = document.getElementById('codigo');
    const codigo = codigoInput.value;
    const id = document.getElementById('id_form').value;

    if (codigo.length < 3) {
      // Si el código es muy corto, no podemos validar existencia aún.
      // Esto es para la validación en tiempo real, no debe bloquear el submit si no es un error de formato.
      isIncorrect('grupo__codigo', 'Mínimo 3 caracteres para el código');
      return false;
    }

    try {
      const response = await fetch(`../controllers/carrera/Carrera.php?accion=codigo_existe&id=${id}&codigo=${codigo}`);
      if (!response.ok) {
        console.error('Error al verificar el código:', response.statusText);
        return false; // Manejar error de red, no considerarlo como existente
      }
      const data = await response.json();
      if (data.existe) {
        isIncorrect('grupo__codigo', 'El código ya está registrado');
        return true;
      } else {
        // Solo si el formato es correcto, lo marcamos como correcto después de la verificación de existencia
        if (expresiones.codigo.test(codigo)) {
          isCorrect('grupo__codigo');
        }
        return false;
      }
    } catch (error) {
      console.error('Error en la verificación de código:', error);
      mostrarMensajeError('Error de red al verificar el código.');
      return false;
    }
  }

  async function nombreExiste() {
    const nombreInput = document.getElementById('nombre');
    const nombre = nombreInput.value;
    const id = document.getElementById('id_form').value;

    if (nombre.length < 5) {
      // Si el nombre es muy corto, no podemos validar existencia aún.
      isIncorrect('grupo__nombre', 'Mínimo 5 caracteres para el nombre');
      return false;
    }

    try {
      const response = await fetch(`../controllers/carrera/Carrera.php?accion=nombre_existe&id=${id}&nombre=${nombre}`);
      if (!response.ok) {
        console.error('Error al verificar el nombre:', response.statusText);
        return false; // Manejar error de red
      }
      const data = await response.json();
      if (data.existe) {
        isIncorrect('grupo__nombre', 'El nombre ya está registrado');
        return true;
      } else {
        // Solo si el formato es correcto, lo marcamos como correcto después de la verificación de existencia
        if (expresiones.nombre.test(nombre)) {
          isCorrect('grupo__nombre');
        }
        return false;
      }
    } catch (error) {
      console.error('Error en la verificación de nombre:', error);
      mostrarMensajeError('Error de red al verificar el nombre.');
      return false;
    }
  }

  // Validación en tiempo real
  document.getElementById('codigo').addEventListener('input', async function () {
    // Primero validar el formato, luego la existencia
    if (!validateInput(this, expresiones.codigo, 'grupo__codigo', 'El código debe contener entre 3 y 10 caracteres numéricos')) {
      return; // Si el formato es incorrecto, no validar existencia
    }
    await codigoExiste();
  });
  document.getElementById('nombre').addEventListener('input', async function () {
    // Primero validar el formato, luego la existencia
    if (!validateInput(this, expresiones.nombre, 'grupo__nombre', 'El nombre debe contener entre 5 y 100 caracteres alfanuméricos')) {
      return; // Si el formato es incorrecto, no validar existencia
    }
    await nombreExiste();
  });
  document.getElementById('nota').addEventListener('input', function () {
    validateInput(this, expresiones.nota, 'grupo__nota');
  });
  document.getElementById('abreviatura').addEventListener('input', function () {
    validateInput(this, expresiones.abreviatura, 'grupo__abreviatura');
  });

  function validateTiposPasantias() {
    const tipos = document.querySelectorAll('#checkbox_container input[name="tipos_pasantias"]:checked');
    if (tipos.length === 0) {
      isIncorrect('grupo__tipos_pasantias', 'Seleccione al menos un tipo de práctica');
      return false;
    } else {
      isCorrect('grupo__tipos_pasantias');
      return true;
    }
  }

  // Cargar tipos de pasantías al abrir el modal
  document.querySelector('.primary').addEventListener('click', function () {
    cargarTiposPasantias();
    document.getElementById('dialog').showModal();
    document.getElementById('formulario').reset();
    // Asegurarse de que el display del custom select se resetee
    const selectedDisplay = document.querySelector('#checkbox_container .custom-select-selected');
    if (selectedDisplay) {
      selectedDisplay.textContent = 'Seleccione Tipos de Práctica...';
    }
    document.getElementById('id_form').value = ''; // Resetear ID del formulario
    // Resetear visualmente las validaciones
    document.querySelectorAll('.formulario__grupo-correcto, .formulario__grupo-incorrecto').forEach(el => {
      el.classList.remove('formulario__grupo-correcto', 'formulario__grupo-incorrecto');
    });
    document.querySelectorAll('.formulario__input-error-activo').forEach(el => {
      el.classList.remove('formulario__input-error-activo');
    });
    document.querySelectorAll('.formulario__grupo i').forEach(icon => {
      icon.classList.remove("fa-check-circle", "fa-times-circle");
    });
  });

  function updateSelectedDisplay(displayElement, optionsContainer) {
    const selectedOptions = [];
    optionsContainer.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
      const label = checkbox.closest('.option-item').querySelector('label');
      if (label) selectedOptions.push(label.textContent);
    });

    if (selectedOptions.length > 0) {
      displayElement.textContent = selectedOptions.join(', ');
    } else {
      displayElement.textContent = 'Seleccione Tipos de Práctica...';
    }
  }

  function cargarTiposPasantias() {
    fetch('../controllers/carrera/Carrera.php?accion=listar_tipos_pasantias')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('checkbox_container');
        container.innerHTML = ''; // Limpiar contenido previo

        const selectContainer = document.createElement('div');
        selectContainer.className = 'custom-select-container';

        const selectedDisplay = document.createElement('div');
        selectedDisplay.className = 'custom-select-selected';
        selectedDisplay.textContent = 'Seleccione Tipos de Práctica...';
        selectContainer.appendChild(selectedDisplay);

        const arrowIcon = document.createElement('i');
        arrowIcon.className = 'fas fa-chevron-down custom-select-arrow';
        selectContainer.appendChild(arrowIcon);

        const optionsContainer = document.createElement('div');
        optionsContainer.className = 'custom-select-options';
        optionsContainer.style.display = 'none'; // Oculto inicialmente

        data.forEach(tipo => {
          const optionDiv = document.createElement('div');
          optionDiv.className = 'option-item';

          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.id = `tipo_${tipo.INTERNSHIP_TYPE_ID}`;
          checkbox.name = 'tipos_pasantias';
          checkbox.value = tipo.INTERNSHIP_TYPE_ID;
          checkbox.setAttribute('priority', tipo.PRIORITY);

          const label = document.createElement('label');
          label.htmlFor = `tipo_${tipo.INTERNSHIP_TYPE_ID}`;
          label.textContent = tipo.NAME;

          optionDiv.appendChild(checkbox);
          optionDiv.appendChild(label);
          optionsContainer.appendChild(optionDiv);

          checkbox.addEventListener('change', function () {
            const priority = this.getAttribute("priority");
            const priorityZeroCheckbox = optionsContainer.querySelector("input[type=checkbox][priority='0']");

            if (this.checked) {
              if (priority === "0") {
                optionsContainer.querySelectorAll("input[type=checkbox]").forEach(cb => {
                  if (cb !== this) cb.checked = false;
                });
              } else {
                if (priorityZeroCheckbox && priorityZeroCheckbox.checked) {
                  priorityZeroCheckbox.checked = false;
                }
              }
            }
            updateSelectedDisplay(selectedDisplay, optionsContainer);
            validateTiposPasantias();
          });
        });

        selectContainer.appendChild(optionsContainer);
        container.appendChild(selectContainer);

        selectedDisplay.addEventListener('click', (event) => {
          event.stopPropagation(); // Evitar que el click se propague al document
          optionsContainer.style.display = optionsContainer.style.display === 'none' ? 'block' : 'none';
        });

        // Cerrar el dropdown si se hace clic fuera
        document.addEventListener('click', function (event) {
          if (!selectContainer.contains(event.target) && optionsContainer.style.display === 'block') {
            optionsContainer.style.display = 'none';
          }
        });
      });
  }

  function listarCarreras(tipo) {
    const endpoint = tipo === 'activos' ? 'listar_activos' : 'listar_inactivos';
    const tablaId = tipo === 'activos' ? 'datos-activos' : 'datos-inactivos';
    fetch(`../controllers/carrera/Carrera.php?accion=${endpoint}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById(tablaId).innerHTML = '';
        data.forEach(carrera => {
          let acciones = '';
          if (tipo === 'activos') {
            acciones = `
                              <button class="task-edit" onclick="editarCarrera(${carrera.CAREER_ID})" title="Editar">
                                  <span class="texto">Editar</span>
                                  <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                              </button>
                              <button class="task-delete" onclick="eliminarCarrera(${carrera.CAREER_ID})" title="Eliminar">
                                  <span class="texto">Borrar</span>
                                  <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                              </button>
                          `;
          } else {
            acciones = `
                              <button class="task-restore" onclick="activarCarrera(${carrera.CAREER_ID})" title="Restaurar">
                                  <span class="texto">Restaurar</span>
                                  <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                              </button>
                          `;
          }
          document.getElementById(tablaId).innerHTML += `
                              <tr>
                                  <td>${carrera.CAREER_CODE}</td>
                                  <td>${carrera.CAREER_NAME}</td>
                                  <td>${carrera.MINIMUM_GRADE}</td>
                                  <td>${carrera.CAREER_ABBREVIATION || ''}</td>
                                  <td colspan="2">
                                      <div class="acciones-carrera">
                                          ${acciones}
                                      </div>
                                  </td>
                              </tr>
                      `;
        });
      });
  }

  // Inicializar ambas listas
  listarCarreras('activos');
  listarCarreras('inactivos');

  // Manejar el envío del formulario
  document.getElementById('formulario').addEventListener('submit', async function (e) {
    e.preventDefault();

    // 1. Guardar el estado actual del dialog y cerrarlo antes de cualquier Swal.fire
    const wasDialogOpen = window.dialog && window.dialog.open;
    if (wasDialogOpen) {
      window.dialog.close();
    }

    // 2. Validar el formulario
    if (!(await validateForm())) {
      mostrarMensajeError('Por favor, corrige los errores antes de enviar el formulario.', () => {
        // Reabrir el dialog solo si estaba abierto y se necesita corrección
        if (wasDialogOpen && !window.dialog.open) {
          window.dialog.showModal();
        }
      });
      return;
    }

    // Si la validación pasa, proceder con la confirmación de envío
    Swal.fire({
      title: '¿Quieres proceder con el registro?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí',
      cancelButtonText: 'No',
      allowOutsideClick: false,
      allowEscapeKey: false
    }).then(async (result) => { // Usamos 'async' aquí porque haremos un fetch dentro
      if (!result.isConfirmed) {
        // Si la confirmación de envío se canceló, reabrimos el dialog si estaba abierto
        if (wasDialogOpen && !window.dialog.open) {
          window.dialog.showModal();
        }
        console.log('Registro cancelado por el usuario.');
        return;
      }

      // Si se confirmó el envío
      const formData = new FormData(this);
      const id = formData.get("id_form");
      formData.append("id", id);

      const tiposPasantias = Array.from(document.querySelectorAll('#checkbox_container input[name="tipos_pasantias"]:checked'))
        .map(checkbox => checkbox.value);
      formData.append('tipos_pasantias', JSON.stringify(tiposPasantias));

      try {
        const response = await fetch(`../controllers/carrera/Carrera.php?accion=${id ? 'actualizar' : 'insertar'}`, {
          method: 'POST',
          body: formData
        });
        const data = await response.json();

        if (data.success) {
          mostrarMensajeExito(data.message || 'Operación exitosa', () => {
            // Cierra el dialog si aún está abierto después del éxito
            if (window.dialog && window.dialog.open) {
              window.dialog.close();
            }
            this.reset();
            // Resetear visualmente las validaciones
            document.querySelectorAll('.formulario__grupo-correcto, .formulario__grupo-incorrecto').forEach(el => {
              el.classList.remove('formulario__grupo-correcto', 'formulario__grupo-incorrecto');
            });
            document.querySelectorAll('.formulario__input-error-activo').forEach(el => {
              el.classList.remove('formulario__input-error-activo');
            });
            document.querySelectorAll('.formulario__grupo i').forEach(icon => {
              icon.classList.remove("fa-check-circle", "fa-times-circle");
            });
            listarCarreras('activos');
            listarCarreras('inactivos');
          });
        } else {
          mostrarMensajeError('Error: ' + (data.error || 'No se pudo completar la operación'), () => {
            // Reabrir el dialog si hubo un error en la operación y estaba abierto
            if (wasDialogOpen && !window.dialog.open) {
              window.dialog.showModal();
            }
          });
        }
      } catch (error) {
        console.error('Error al enviar formulario:', error);
        mostrarMensajeError('Error de red o del servidor al enviar el formulario.', () => {
          // Reabrir el dialog si hubo un error de red y estaba abierto
          if (wasDialogOpen && !window.dialog.open) {
            window.dialog.showModal();
          }
        });
      }
    });
  });

  window.editarCarrera = function (id) {
    fetch(`../controllers/carrera/Carrera.php?accion=buscar_para_editar&id=${id}`)
      .then(response => response.json())
      .then(data => {
        if (data.length > 0) {
          const carrera = data[0];
          document.getElementById("id_form").value = carrera.CAREER_ID;
          document.getElementById('codigo').value = carrera.CAREER_CODE;
          document.getElementById('nombre').value = carrera.CAREER_NAME;
          document.getElementById('nota').value = carrera.MINIMUM_GRADE;
          document.getElementById('abreviatura').value = carrera.CAREER_ABBREVIATION || '';

          // Resetear visualmente las validaciones antes de cargar los datos de edición
          document.querySelectorAll('.formulario__grupo-correcto, .formulario__grupo-incorrecto').forEach(el => {
            el.classList.remove('formulario__grupo-correcto', 'formulario__grupo-incorrecto');
          });
          document.querySelectorAll('.formulario__input-error-activo').forEach(el => {
            el.classList.remove('formulario__input-error-activo');
          });
          document.querySelectorAll('.formulario__grupo i').forEach(icon => {
            icon.classList.remove("fa-check-circle", "fa-times-circle");
          });

          cargarTiposPasantias(); // Esto reconstruirá el select

          setTimeout(() => { // Esperar a que cargarTiposPasantias complete y renderice
            const optionsContainer = document.querySelector('#checkbox_container .custom-select-options');
            const selectedDisplay = document.querySelector('#checkbox_container .custom-select-selected');

            if (optionsContainer && selectedDisplay) {
              // Desmarcar todos primero
              optionsContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
              // Marcar los correspondientes
              carrera.CAREER_INTERNSHIP_TYPES.forEach(tipo => {
                const checkbox = optionsContainer.querySelector(`#tipo_${tipo.INTERNSHIP_TYPE_ID}`);
                if (checkbox) checkbox.checked = true;
              });
              updateSelectedDisplay(selectedDisplay, optionsContainer);
            }
            validateTiposPasantias(); // Validar después de establecer
          }, 300); // Un pequeño delay para asegurar la renderización
          document.getElementById('dialog').showModal();
          // Ejecutar validación de campos para mostrar el estado correcto inicial (verde/rojo)
          validateInput(document.getElementById('codigo'), expresiones.codigo, 'grupo__codigo');
          validateInput(document.getElementById('nombre'), expresiones.nombre, 'grupo__nombre');
          validateInput(document.getElementById('nota'), expresiones.nota, 'grupo__nota');
          validateInput(document.getElementById('abreviatura'), expresiones.abreviatura, 'grupo__abreviatura');

        }
      })
      .catch(error => {
        console.error('Error al cargar datos para edición:', error);
        mostrarMensajeError('Error al cargar datos para edición.');
      });
  };

  window.eliminarCarrera = function (id) {
    // Cerrar el dialog si está abierto antes de cualquier Swal.fire
    if (window.dialog && window.dialog.open) {
      window.dialog.close();
    }

    Swal.fire({
      title: '¿Está seguro de desactivar esta carrera?',
      text: "¡Esto la moverá a la lista de carreras inactivas!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, desactivar!',
      cancelButtonText: 'Cancelar',
      allowOutsideClick: false,
      allowEscapeKey: false
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('../controllers/carrera/Carrera.php?accion=eliminar', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              mostrarMensajeExito(data.message || 'Carrera desactivada correctamente');
              listarCarreras('activos');
              listarCarreras('inactivos');
            } else {
              mostrarMensajeError('Error: ' + (data.error || 'No se pudo desactivar la carrera'));
            }
          })
          .catch(error => {
            console.error('Error al eliminar carrera:', error);
            mostrarMensajeError('Error de red o del servidor al desactivar la carrera.');
          });
      }
    });
  };

  window.activarCarrera = function (id) {
    // Cerrar el dialog si está abierto antes de cualquier Swal.fire
    if (window.dialog && window.dialog.open) {
      window.dialog.close();
    }

    Swal.fire({
      title: '¿Está seguro de reactivar esta carrera?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, reactivar!',
      cancelButtonText: 'No',
      allowOutsideClick: false,
      allowEscapeKey: false
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('../controllers/carrera/Carrera.php?accion=restaurar', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              mostrarMensajeExito(data.message || 'Carrera reactivada correctamente');
              listarCarreras('activos');
              listarCarreras('inactivos');
            } else {
              mostrarMensajeError('Error: ' + (data.error || 'No se pudo reactivar la carrera'));
            }
          })
          .catch(error => {
            console.error('Error al reactivar carrera:', error);
            mostrarMensajeError('Error de red o del servidor al reactivar la carrera.');
          });
      }
    });
  };

  window.cambiarTab = function (tab, event) {
    document.querySelectorAll('.tab-button').forEach(btn => {
      btn.classList.remove('active');
    });
    if (event) event.target.classList.add('active');
    if (tab === 'activos') {
      document.getElementById('datos-activos').style.display = '';
      document.getElementById('datos-inactivos').style.display = 'none';
      listarCarreras('activos'); // Refrescar solo la lista activa
    } else {
      document.getElementById('datos-activos').style.display = 'none';
      document.getElementById('datos-inactivos').style.display = '';
      listarCarreras('inactivos'); // Refrescar solo la lista inactiva
    }
  };
});
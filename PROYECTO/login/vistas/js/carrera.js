$(document).ready(function () {
  let edit = false;
  console.log("jquery is working");
  let errores = false; // Variable para comprobar si hay errores
  fetchTask();
  $("task-result").hide();
  $.ajax({
    url: "../controllers/carrera/InternshipTypeList.php",
    type: "GET",
    async: false,
    success: function (response) {
      let task = JSON.parse(response);
      let template = `<label for="" class="formulario__label">Tipo pasantia<span class="obligatorio">*</span>
                    <div class="tooltip-container">
                        <div class="icon-circle-tooltip">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <span class="tooltip-text">
                        <h3>IMPORTANTE</h3>
                        <h5>Prioridad de Pasantia:</h5>
                        <h6>Ordinaria: 0</h6>
                        <h6>Hospitalaria: 1</h6>
                        <h6>Comunitaria: 2</h6>
                        </span>
                    </div></label> `; //creo la plantilla donde imprimire los datos
      task.forEach((task) => {
        //hago un array que me recorra el json y me lo imprima en el tbody
        template += `<label class="checkbox">
        <input type="checkbox" name="my_opt[]" value=${task.INTERNSHIP_TYPE_ID} priority = ${task.PRIORITY} >${task.NAME}</label>`;
      })
      $("#grupo__checkbox").html(template); //los imprimo en el html
    }
  });
  $("#search").keyup(function (e) {
    let search = $("#search").val();
    if (/^\d{1,8}$/.test(search)) {
      $.ajax({
        url: "../controllers/carrera/UserSearch.php",
        type: "POST",
        data: { search },
        success: function (response) {
          let datasearch = JSON.parse(response);
          let template = "";
          datasearch.forEach((task) => {
            template += `<li>${task.CAREER_CODE}</li>`;
          });
          $("#container").html(template);
          $("#task-result").show();
        },
      });
    } else {
      $("#task-result").hide();
    }
  });
  $("#nombre").keyup(function (e) {
    validarNombre();
  });
  $("#codigo").keyup(function (e) {
    validarCodigo();
  });
  $("input[name='my_opt[]']").change(function () {
      const $this = $(this);
      if ($this.attr("priority") === "0" && $this.is(":checked")) {
          // Si el de prioridad 0 se selecciona, deselecciona los demás
          $("input[type=checkbox]").not($this).prop("checked", false);
      } else if ($("input[type=checkbox][priority=0]").is(":checked")) {
          // Si el de prioridad 0 está seleccionado, deselecciona este
          $("input[type=checkbox][priority=0]").prop("checked", false);
          alert("No puedes seleccionar más de un tipo de pasantía cuando haz seleccionado un tipo de pasantía que es unico");
      }
      // Mostrar los valores seleccionados
      const selectedValues = $("input[type=checkbox]:checked").map(function () {
          return $(this).val();
      }).get();
  });
  // ...existing code...
  $("#formulario").submit(function (e) {
    const Id_Carrera = $("#id").val();
    const Codigo = $("#codigo").val();
    const Nombre_Carrera = $("#nombre").val();
    const MINIMUM_GRADE = $("#nota").val();
    const selectedValues = $("input[type=checkbox]:checked").map(function () {
      return $(this).val();
    }).get();
    if (!validarFormulario()) {
      // Se comprueba si hay errores
      e.preventDefault(); // C    ancela el envío del formulario si hay errores
      alert("Debe llenar correctamente el formulario");
      return false;
    }

    // Agregamos la alerta de confirmación
    if (confirm("¿Quieres proceder con el Registro?")) {
      const postData = {
        Id_Carrera: Id_Carrera,
        Codigo: Codigo,
        Nombre_Carrera: Nombre_Carrera,
        MINIMUM_GRADE: MINIMUM_GRADE,
        CAREER_INTERNSHIP_TYPES: selectedValues
      };
      let url =
        edit === false
          ? "../controllers/carrera/UserAdd.php"
          : "../controllers/carrera/UserEdit.php";
      $.post(url, postData, function (response) {
        data = JSON.parse(response);
        $(".message").html(data.message);
        let message = $("#message").get(0);
        message.showModal();
        $(".x").on("click", function () {
          message.close();
        });
        fetchTask();
        $("#formulario").trigger("reset");
        dialog.close();
        edit = false; // Reiniciar la variable edit después de guardar
      });
    } else {
      // Si el usuario hace clic en "Cancelar", no se envía el formulario
      return false;
    }

    e.preventDefault();
  });

  function fetchTask() {
    //esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
    $.ajax({
      //realizo una peticion ajax
      url: "../controllers/carrera/UserList.php", //al url que trae la lista
      type: "GET", //le pido una peticion GET
      success: function (response) {
        // si tengo una respuesta ejecuta la funcion
        let task = JSON.parse(response); // convierto el json en string
        let template = ""; //creo la plantilla donde imprimire los datos
        task.forEach((task) => {
          //hago un array que me recorra el json y me lo imprima en el tbody
          template += `<tr taskid="${task.CAREER_ID}">
                        <td>${task.CAREER_CODE}</td>
                        <td>${task.CAREER_NAME}</td>
                        <td>
                            <button class="task-delete "><spam class="texto">Borrar</spam><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button>
                        </td>
                        <td>
                            <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
                        </td>
                    </tr>
                    `;
        });
        $("#datos").html(template); //los imprimo en el html
      },
    });
  }
  $(document).on("click", ".task-delete", function () {
    //escucho un click del boton task-delete que es una clase
    let element = $(this)[0].parentElement.parentElement; // accedo al elemento padre de este hasta conseguir el ID de la fila
    let id = $(element).attr("taskid"); //accedo al tributo que cree que contiene la cedula que busco

    // Agregamos la alerta de confirmación
    if (confirm("¿Está seguro de eliminar este Registro?")) {
      $.post(
        "../controllers/carrera/UserDelete.php",
        { id },
        function (response) {
          //mando los datos al controlador
          alert("usuario eliminado");
          fetchTask(); //vuelvo a llamar a la funcion de la tabla para que actualize los datos
        }
      );
    } else {
      // Si el usuario hace clic en "Cancelar", no se envía el formulario
      return false;
    }
  });

  $(document).on("click", ".primary", function () {
    $("#formulario").trigger("reset");
    edit = false;
  });

  $(document).on("click", ".task-edit", function () {
    //escucho un click del boton task-edit que es una clase
    let element = $(this)[0].parentElement.parentElement; // accedo al elemento padre de este hasta conseguir el ID de la fila
    let Id_Carrera = $(element).attr("taskid"); //accedo al tributo que cree que contiene la cedula que busco
    $.post(
      "../controllers/carrera/UserEditSearch.php",
      { Id_Carrera: Id_Carrera },
      function (response) {
        //mando los datos al controlador
        const task = JSON.parse(response)[0]; // accede al primer objeto en el array
        $("#id").val(task.CAREER_ID).prop("readonly", true); //añado los elementos al formulario y lo hago de solo lectura
        $("#codigo").val(task.CAREER_CODE); //añado los elementos al formulario y lo hago de solo lectura
        $("#nombre").val(task.CAREER_NAME);
        $("#nota").val(task.MINIMUM_GRADE);
        for (let i = 0; i < task.CAREER_INTERNSHIP_TYPES.length; i++) {
          // Recorre el array de tipos de pasantía  
          const internshipTypeId = task.CAREER_INTERNSHIP_TYPES[i].INTERNSHIP_TYPE_ID;
          // Marca el checkbox correspondiente
          $(`input[type=checkbox][value=${internshipTypeId}]`).prop("checked", true);
        }
        edit = true; //valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
      }
    );
  });
  function isCorrect(id) {
    $(`#${id}`).addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
    $(`#${id} i`).addClass("fa-check-circle").removeClass("fa-times-circle");
    $(`#${id} .formulario__input-error`).removeClass("formulario__input-error-activo");
  }
  function isIncorrect(id, message) {
    $(`#${id}`).addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
    $(`#${id} i`).addClass("fa-times-circle").removeClass("fa-check-circle");
    $(`#${id} .formulario__input-error`).addClass('formulario__input-error-activo');
    $(`#${id} p`).text(message);
  }
  function validarNombre() {
    let Nombre_Carrera = $("#nombre").val();
    let validacion = false;
    $.ajax({
      url: "../controllers/carrera/UserSearch.php",
      type: "POST",
      data: { Nombre_Carrera },
      async: false,
      success: function (response) {
        let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
        if (
          !(
            Object.keys(data).length === 0 ||
            (edit === true && data[0].CAREER_ID === parseInt($("#id").val()))
          )
        ) {
          isIncorrect("grupo__nombre", "Esta carrera ya existe");
          validacion = false;
        } else if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test(Nombre_Carrera)) {
          isIncorrect('grupo__nombre', "Este campo solo permite letras");
          validacion = false;
        } else {
          isCorrect("grupo__nombre");
          validacion = true;
        }
      },
    });
    return validacion;
  }
  function validarCodigo() {
    let Codigo = $("#codigo").val();
    var validacion = false;
    $.ajax({
      url: "../controllers/carrera/UserSearch.php",
      type: "POST",
      data: { Codigo },
      async: false,
      success: function (response) {
        let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
        if (
          !(
            Object.keys(data).length === 0 ||
            (edit === true && data[0].CAREER_ID === parseInt($("#id").val()))
          )
        ) {
          isIncorrect("grupo__codigo", "Este codigo ya existe");
          validacion = false;
        } else if (!/^\d+$/.test(Codigo)) {
          isIncorrect("grupo__codigo", "Este campo solo permite números");
          validacion = false;
        } else {
          isCorrect("grupo__codigo");
          validacion = true;
        }
      },
    });
    return validacion;
  }
  function validarFormulario() {
    let isvalidname = validarNombre();
    let isvalidcodigo = validarCodigo();
    return isvalidcodigo && isvalidname;
  }
});


document.addEventListener("DOMContentLoaded", function () {
  const dialog = document.getElementById("dialog");
  const closeButton = document.querySelector("#dialog .x");
  const formulario = document.getElementById("formulario");

  closeButton.addEventListener("click", function () {
    // Cerrar el modal
    dialog.close();

    // Limpiar todos los campos del formulario
    formulario.reset();

    // Ocultar mensajes de error
    const errores = formulario.querySelectorAll(".formulario__input-error");
    errores.forEach(error => error.style.display = "none");

    // Ocultar mensaje de éxito
    const mensajeExito = document.getElementById("formulario__mensaje-exito");
    if (mensajeExito) {
      mensajeExito.style.display = "none";
    }

    // Ocultar mensaje general de error
    const mensajeError = document.getElementById("formulario__mensaje");
    if (mensajeError) {
      mensajeError.style.display = "none";
    }

    // Resetear estilos de validación (iconos y bordes)
    const inputs = formulario.querySelectorAll(".formulario__input");
    inputs.forEach(input => {
      input.classList.remove("formulario__input--incorrecto", "formulario__input--correcto");
    });

    // Ocultar iconos de validación
    const iconosValidacion = formulario.querySelectorAll(".formulario__validacion-estado");
    iconosValidacion.forEach(icono => {
      icono.style.display = "none";
    });
  });
});

// Variables de estado
let currentData = [...sampleData];
let filteredData = [...sampleData];
let currentPage = 1;
let recordsPerPage = 10;
let sortColumn = null;
let sortDirection = 'asc';

// Inicialización
document.addEventListener('DOMContentLoaded', function () {
  renderTable();
  setupEventListeners();
  updatePagination();
});

// Configurar event listeners
function setupEventListeners() {
  // Ordenar al hacer clic en encabezados
  document.querySelectorAll('.sortable').forEach(header => {
    header.addEventListener('click', function () {
      const column = this.getAttribute('data-column');

      // Si ya está ordenado por esta columna, invertir la dirección
      if (sortColumn === column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        sortColumn = column;
        sortDirection = 'asc';
      }

      // Limpiar clases de ordenamiento anteriores
      document.querySelectorAll('.sortable').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
      });

      // Añadir clase al encabezado actual
      this.classList.add(`sort-${sortDirection}`);

      sortData();
      renderTable();
      updatePagination();
    });
  });

  // Cambiar registros por página
  document.getElementById('recordsPerPage').addEventListener('change', function () {
    recordsPerPage = parseInt(this.value);
    currentPage = 1;
    updatePagination();
    renderTable();
  });

  // Aplicar filtros
  document.getElementById('applyFilters').addEventListener('click', applyFilters);

  // Restablecer filtros
  document.getElementById('resetFilters').addEventListener('click', resetFilters);

  // Paginación
  document.getElementById('prevPage').addEventListener('click', function () {
    if (currentPage > 1) {
      currentPage--;
      renderTable();
      updatePagination();
    }
  });

  document.getElementById('nextPage').addEventListener('click', function () {
    const totalPages = Math.ceil(filteredData.length / recordsPerPage);
    if (currentPage < totalPages) {
      currentPage++;
      renderTable();
      updatePagination();
    }
  });

  // Permitir búsqueda al presionar Enter
  document.getElementById('searchInput').addEventListener('keyup', function (e) {
    if (e.key === 'Enter') {
      applyFilters();
    }
  });
}

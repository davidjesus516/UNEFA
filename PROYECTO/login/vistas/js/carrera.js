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
      let template = `<label for="" class="formulario__label">Tipo pasantia<span class="obligatorio">*</span></label>`; //creo la plantilla donde imprimire los datos
      task.forEach((task) => {
        //hago un array que me recorra el json y me lo imprima en el tbody
        template += `<label class="checkbox">
        <input type="checkbox" name="my_opt[]" value=${task.INTERNSHIP_TYPE_ID} priority = ${task.PRIORITY} >${task.NAME}</label>`;
      })
      $("#grupo__checkbox").html(template); //los imprimo en el html
    }}); 
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
      console.log("Valores seleccionados:", selectedValues);
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
                            <button class="task-delete "><spam class="texto">Borrar</spam><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path></svg></span></button>
                        </td>
                        <td>
                            <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><spam class="icon"><svg viewBox="0 0 512 512">
                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg></spam></button>
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
  function isCorrect(id){ 
                    $(`#${id}`).addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
                    $(`#${id} i`).addClass("fa-check-circle").removeClass("fa-times-circle");
                    $(`#${id} .formulario__input-error`).removeClass("formulario__input-error-activo");
}
    function isIncorrect(id,message){
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
          isIncorrect('grupo__nombre',"Este campo solo permite letras");
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
          isIncorrect("grupo__codigo","Este codigo ya existe");
          validacion = false;
        } else if (!/^\d+$/.test(Codigo)) {
          isIncorrect("grupo__codigo","Este campo solo permite números");
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

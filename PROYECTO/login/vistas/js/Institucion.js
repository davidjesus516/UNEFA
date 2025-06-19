$(document).ready(function(){//aqui inicializamos javascript
    let edit = false;// esta variable de lectura la inicializo para que el form de enviar pueda volverse en un editar si es True
    console.log("jquery is working");// para saber que jquery este funcionando
    console.log(edit);
    fetchTask();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    function modalclose() {
        $('#close').on('click', function(e) {
            $('#respuesta')[0].close();
            $("#respuesta").html('');
        });
    }
    function modalopen(response) {
        $('#respuesta').html(response);
        $('#respuesta')[0].showModal();
    }
    let errores = false;
    // funcion que hara el cierre de las ventanas modal
    $.ajax({//realizo una peticion ajax
        url: '../controllers/carrera/UserList.php',//al url que trae la lista
        type: 'GET',//le pido una peticion GET
        success: function (response){// si tengo una respuesta ejecuta la funcion
            let task = JSON.parse(response);// convierto el json en string
            let template = '<option id = "carrera-option" value="" disabled selected>Seleccione una opción</option>';//creo la plantilla donde imprimire los datos
            task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                template +=`<option id = "carrera-option" value="${task.CAREER_ID}" >${task.CAREER_NAME}</option>
                `
            })
            $('#carrera').html(template);//los imprimo en el html
        }
    }) 
    $.ajax({//realizo una peticion ajax
        url: '../controllers/Tipo_Institucion/UserList.php',//al url que trae la lista
        type: 'GET',//le pido una peticion GET
        success: function (response){// si tengo una respuesta ejecuta la funcion
            let task = JSON.parse(response);// convierto el json en string
            let template = '<option id = "Tipo_Institucion-option" value="" disabled selected>Seleccione una opción</option>';//creo la plantilla donde imprimire los datos
            task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                template +=`<option id = "Tipo_Institucion-option" value="${task.IdTipo_Institucion}" >${task.Tipo_Institucion}</option>
                `
            })
            $('#Tipo_Institucion').html(template);//los imprimo en el html
        }
    }) 
    $.ajax({//realizo una peticion ajax
        url: '../controllers/Tipo_Practica/UserList.php',//al url que trae la lista
        type: 'GET',//le pido una peticion GET
        success: function (response){// si tengo una respuesta ejecuta la funcion
            let task = JSON.parse(response);// convierto el json en string
            let template = '<option id = "Tipo_Practica-option" value="" disabled selected>Seleccione una opción</option>';//creo la plantilla donde imprimire los datos
            task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                template +=`<option id = "Tipo_Practica-option" value="${task.IdTipo_Pasantias}" >${task.Nombre}</option>
                `
            })
            $('#Tipo_Practica').html(template);//los imprimo en el html
        }
    })
        
    const expresiones = {
        rif: /^\d{1,9}$/, // rif debe ser un numero de maximo 9 digitos
        telefono: /^\d{11}$/ // telefono debe ser un numero de 11 digitos 
    }

    $('#n_rif').keyup(function(e){
    if (expresiones.rif.test($('#n_rif').val())) {
        $('#grupo__rif').addClass("formulario__grupo-correcto").removeClass( "formulario__grupo-incorrecto");
        $('#grupo__rif i').addClass("fa-check-circle").removeClass("fa-times-circle")
        $(`#grupo__rif .formulario__input-error`).removeClass('formulario__input-error-activo');

        errores = false
    }
    else {
        $('#grupo__rif').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
        $('#grupo__rif i').addClass("fa-times-circle").removeClass("fa-check-circle");
        $(`#grupo__rif .formulario__input-error`).addClass('formulario__input-error-activo');
        $('#grupo__rif p').text("Este campo solo puede contener numeros.");
        errores = true
    }
    
    })
    $('#tlf').keyup(function(e){
    if (expresiones.telefono.test($('#tlf').val())) {
        $('#grupo__telefono').addClass("formulario__grupo-correcto").removeClass( "formulario__grupo-incorrecto");
        $('#grupo__telefono i').addClass("fa-check-circle").removeClass("fa-times-circle")
        $(`#grupo__telefono .formulario__input-error`).removeClass('formulario__input-error-activo');

        errores = false
    }
    else {
        $('#grupo__telefono').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
        $('#grupo__telefono i').addClass("fa-times-circle").removeClass("fa-check-circle");
        $(`#grupo__telefono .formulario__input-error`).addClass('formulario__input-error-activo');
        errores = true
    }
    
    })
    $("#n_rif").keyup(function (e) {
        let rif = $('#l_rif').val()+$('#n_rif').val();
        $.ajax({
            url: "../controllers/Institucion/UserSearch.php",
            type: "POST",
            data: { rif: rif },
            success: function (response) {
                let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
                if (Object.keys(data).length === 0 || edit === true) {
                    // Verificamos si el objeto está vacío
                    console.log("no existe");
                    $('#grupo__rif').addClass("formulario__grupo-correcto").removeClass( "formulario__grupo-incorrecto");
                    $('#grupo__rif i').addClass("fa-check-circle").removeClass("fa-times-circle")
                    $(`#grupo__rif .formulario__input-error`).removeClass('formulario__input-error-activo');
                    errores = false
                } 
                else {
                    $("#grupo__nombre").addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
                    $("#grupo__nombre i").addClass("fa-times-circle").removeClass("fa-check-circle");
                    $(`#grupo__nombre .formulario__input-error`).addClass("formulario__input-error-activo");
                    $("#grupo__nombre p").text("este rif ya existe");
                    errores = true;
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    errores = false

    $('#formulario').submit(function(e){//reviso del formulario task el evento submit
          // Agregamos la alerta de confirmación
        if (!confirm('¿Quieres proceder?')) {
            e.preventDefault(); // Cancela el envío del formulario si el usuario hace clic en "Cancelar"
            return false;
        }
        const id = $('#id').val();
        const rif = $('#l_rif').val()+$('#n_rif').val();
        const nombre = $('#nombre').val();
        const telefono = $('#telefono_Empresa').val() +$('#telefono').val();
        const direccion = $('#direccion').val();
        const carrera = $('#carrera').val();
        const Tipo_Institucion = $('#Tipo_Institucion').val();
        const Tipo_Practica = $('#Tipo_Practica').val();
        
    
        if (errores) { // Se comprueba si hay errores
            e.preventDefault(); // Cancela el envío del formulario si hay errores
            alert("debe llenar correctamente el formulario");
            return false;
        }
    
        const postData = {
            id: id,
            rif: rif,
            nombre: nombre,
            telefono: telefono,
            direccion: direccion,
            carrera: carrera,
            Tipo_Institucion: Tipo_Institucion,
            Tipo_Practica: Tipo_Practica

        };
        if (edit === false) {
            let url = '../controllers/empresa/UserAdd.php';
            $.post(url, postData, function (response) {
            console.log(response);
            console.log(edit)
            if(response==1){
                alert('Este Nuevo Registro ha sido añadido');
            } else if (response==0) {
                alert('Ya Este Estudiante Existe Porfavor compruebe los Registros');
            } else {
                alert('?');
            }
            fetchTask();
            $('#formulario').trigger('reset');
            }).fail(function() {
              alert("Error en el servidor. Por favor, intenta nuevamente."); // Mostrar mensaje de error en caso de falla en la conexión con el servidor
            });
        } else {
            let url = '../controllers/empresa/UserEdit.php';
            $.post(url, postData, function (response) {
                console.log(response);
                console.log(edit)
                fetchTask();
                $('#formulario').trigger('reset');
                $('#rif').attr('readonly', false);
                edit = false;
                alert(response); // Usuario insertado correctamente
            })
        } 
          e.preventDefault(); // Se agrega para prevenir el comportamiento predeterminado del formulario     
    })

    function fetchTask(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/empresa/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<tr taskid="${task.id}">
                        <td>${task.nombre}</td>
                        <td>${task.rif}</td>
                        <td>${task.telefono_empresa}</td>
                        <td>${task.direccion}</td>
                        <td>${task.n_pasantes}</td>
                        <td>
                            <button class="task-delete "><spam class="texto">Borrar</spam><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button>
                        </td>
                        <td>
                            <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
                        </td>
                        <td>
                            ${
                                tipo === 'activos'
                                ? `<div style="display:flex;gap:0.5rem;">
                                        <button class="task-action task-edit" onclick="editarResponsable(${p.MANAGER_ID})" title="Editar">
                                            <span class="texto">Editar</span>
                                            <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                        </button>
                                        <button class="task-action task-delete" onclick="eliminarResponsable(${p.MANAGER_ID})" title="Desactivar">
                                            <span class="texto">Borrar</span>
                                            <span class="icon"><i class="fa-solid fa-trash-can"></i></span>
                                        </button>
                                   </div>`
                                : `<button class="task-action task-restore" onclick="restaurarResponsable(${p.MANAGER_ID})" title="Restaurar">
                                        <span class="texto">Restaurar</span>
                                        <span class="icon"><i class="fa-solid fa-rotate-left"></i></span>
                                   </button>`
                            }
                        </td>
                    </tr>
                    `
                })
                $('#datos').html(template);//los imprimo en el html
            }
        }) 
    }
    $(document).on('click','.task-delete',function(){
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');
        modalclose();
        // Agregamos la alerta de confirmación
        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            $.post('../controllers/empresa/UserDelete.php',{id}, function (e) {
                modalopen(response);
                modalclose();
                fetchTask();
            });}
        else {
            // Si el usuario hace clic en "Cancelar", no se elimina el usuario
            return false;
        }
    });

$(document).on('click','.task-edit',function(){//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/empresa/UserEditSearch.php', {id}, function(response){//mando los datos al controlador
            const task = JSON.parse(response)[0]; // accede al primer objeto en el array
            telefono = task.telefono_empresa.split("-");
            $('#id').val(task.id).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#l_rif').val(task.l_rif);
            $('#n_rif').val(task.rif).prop('readonly', true);
            $('#nombre').val(task.nombre);
            $('#direccion').val(task.direccion);
            $('#telefono_Empresa').val(telefono[0]+'-');
            $('#telefono').val(telefono[1]);
            $('#n_pasantes').val(task.n_pasantes);
            $('#carrera').val(task.carrera);
            $('#Tipo_Institucion').val(data.IdTipo_Institucion);
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });
    })

    // Función para limpiar el formulario
    function limpiarFormulario() {
        $('#formulario').trigger('reset');
        $('#id').val('').prop('readonly', false);
        $('#n_rif').prop('readonly', false);
        // Limpia los estilos de validación
        $('.formulario__grupo').removeClass('formulario__grupo-correcto formulario__grupo-incorrecto');
        $('.formulario__input-error').removeClass('formulario__input-error-activo');
    }

    // Mostrar el modal para nuevo registro y limpiar el formulario
    $('#btn-nueva-institucion, .primary').on('click', function() {
        limpiarFormulario();
        edit = false;
        window.dialog.showModal();
    });

    // Limpiar el formulario al cerrar el modal
    if (window.dialog) {
        window.dialog.addEventListener('close', function() {
            limpiarFormulario();
        });
    }

    // Convertir opciones de Tipo de Institución a mayúsculas después de cargarlas
    $.ajax({
        url: '../controllers/Tipo_Institucion/UserList.php',
        type: 'GET',
        success: function (response){
            let task = JSON.parse(response);
            let template = '<option id="Tipo_Institucion-option" value="" disabled selected>Seleccione una opción</option>';
            task.forEach(task =>{
                template += `<option id="Tipo_Institucion-option" value="${task.IdTipo_Institucion}">${task.Tipo_Institucion.toUpperCase()}</option>`;
            })
            $('#Tipo_Institucion').html(template);
        }
    });

    // Si usas un botón específico para cerrar el modal, también puedes limpiar el formulario ahí:
    $('#close, .x').on('click', function() {
        if (window.dialog) window.dialog.close();
        limpiarFormulario();
    });
})

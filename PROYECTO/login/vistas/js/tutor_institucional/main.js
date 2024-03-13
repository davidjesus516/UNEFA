$(document).ready(function(){//aqui inicializamos javascript
    let edit = false;// esta variable de lectura la inicializo para que el form de enviar pueda volverse en un editar si es True
    console.log("jquery is working");// para saber que jquery este funcionando
    fetchTask();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    let errores = false;
    $.ajax({//realizo una peticion ajax
        url: '../controllers/empresa/UserList.php',//al url que trae la lista
        type: 'GET',//le pido una peticion GET
        success: function (response){// si tengo una respuesta ejecuta la funcion
            let task = JSON.parse(response);// convierto el json en string
            let template = '<option id = "empresa-option" value="" disabled selected>Seleccione una opción</option>';//creo la plantilla donde imprimire los datos
            task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                template +=`<option id = "empresa-option" value="${task.id}" >${task.nombre}</option>
                `
            })
            $('#empresa').html(template);//los imprimo en el html
        }
    }) 
    const expresiones = {
        usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
        solo_letras: /^[a-zA-ZÀ-ÿ\s]+$/, // Letras y espacios, pueden llevar acentos.
        correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_.+-]*$/, // formato correo ejemplo@mail.com
        cedula: /^\d{1,8}$/, // cedula debe ser un numero de maximo 9 digitos
        telefono: /^\d{11}$/ // telefono debe ser un numero de 11 digitos 
    }

    $('#nombre').keyup(function(e){
    if (expresiones.solo_letras.test($('#nombre').val())) {
        $('#grupo__nombre').addClass("formulario__grupo-correcto").removeClass( "formulario__grupo-incorrecto");
        $('#grupo__nombre i').addClass("fa-check-circle").removeClass("fa-times-circle")
        $(`#grupo__nombre .formulario__input-error`).removeClass('formulario__input-error-activo');

        errores = false
    }
    else {
        $('#grupo__nombre').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
        $('#grupo__nombre i').addClass("fa-times-circle").removeClass("fa-check-circle");
        $(`#grupo__nombre .formulario__input-error`).addClass('formulario__input-error-activo');
        errores = true
    }
})
    $('#apellido').keyup(function(e){
    if (expresiones.solo_letras.test($('#apellido').val())) {
        $('#grupo__apellido').addClass("formulario__grupo-correcto").removeClass( "formulario__grupo-incorrecto");
        $('#grupo__apellido i').addClass("fa-check-circle").removeClass("fa-times-circle")
        $(`#grupo__apellido .formulario__input-error`).removeClass('formulario__input-error-activo');

        errores = false
    }
    else {
        $('#grupo__apellido').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
        $('#grupo__apellido i').addClass("fa-times-circle").removeClass("fa-check-circle");
        $(`#grupo__apellido .formulario__input-error`).addClass('formulario__input-error-activo');
        errores = true
    }
})
    $('#cedula').keyup(function(e){
    if (expresiones.cedula.test($('#cedula').val())) {
        $('#grupo__cedula').addClass("formulario__grupo-correcto").removeClass( "formulario__grupo-incorrecto");
        $('#grupo__cedula i').addClass("fa-check-circle").removeClass("fa-times-circle")
        $(`#grupo__cedula .formulario__input-error`).removeClass('formulario__input-error-activo');

        errores = false
    }
    else {
        $('#grupo__cedula').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
        $('#grupo__cedula i').addClass("fa-times-circle").removeClass("fa-check-circle");
        $(`#grupo__cedula .formulario__input-error`).addClass('formulario__input-error-activo');
        $('#grupo__cedula p').text("Este campo solo puede contener numeros.");
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
    $('#e_mail').keyup(function(e){
        if (expresiones.correo.test($('#e_mail').val())) {
            $('#grupo__correo').addClass("formulario__grupo-correcto").removeClass( "formulario__grupo-incorrecto");
            $('#grupo__correo i').addClass("fa-check-circle").removeClass("fa-times-circle")
            $(`#grupo__correo .formulario__input-error`).removeClass('formulario__input-error-activo');
    
            errores = false
        }
        else {
            $('#grupo__correo').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $('#grupo__correo i').addClass("fa-times-circle").removeClass("fa-check-circle");
            $(`#grupo__correo .formulario__input-error`).addClass('formulario__input-error-activo');
            errores = true
        }
        
        })
    $('#cedula').change(function(e){
        let search = $('#cedula').val();
        $.ajax({
            url: '../controllers/tutor_inst/UserSearch.php',
            type: 'POST',
            data: {search},
            success: function(response){
                let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
                if (Object.keys(data).length === 0) { // Verificamos si el objeto está vacío
                    console.log('no existe');
                } else {
                    $('#grupo__cedula').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
                    $('#grupo__cedula i').addClass("fa-times-circle").removeClass("fa-check-circle");
                    $(`#grupo__cedula .formulario__input-error`).addClass('formulario__input-error-activo');
                    $('#grupo__cedula p').text("Cedula ya existe");
                    errores = true
                }
            },
            error: function(error) {
                console.log(error);
            } 
        })
    })

    $('#task-form').submit(function(e){//reviso del formulario task el evento submit

        // Agregamos la alerta de confirmación
        if (!confirm('¿Quieres proceder con el registro?')) {
            return false; // Cancela el envío del formulario si el usuario hace clic en "Cancelar"
        }
        
        const id = $('#id').val();
        const cedula = $('#cedula').val();
        const nombre = $('#nombre').val();
        const apellido = $('#apellido').val();
        const genero = $('#genero').val();
        const correo = $('#correo').val();
        const telefono = $('#tlf').val();
        const profesion = $('#profesion').val();
        const empresa = $('#empresa').val();
        
    
        
    
        if (errores) { // Se comprueba si hay errores
            return false; // Cancela el envío del formulario
        }
    
        const postData = {
            id: id,
            nombre: nombre,
            cedula: cedula,
            correo: correo,
            telefono: telefono,
            apellido: apellido,
            genero: genero,
            profesion: profesion,
            empresa: empresa
    
        };
        if (edit === false) {
            let url = '../controllers/tutor_inst/UserAdd.php';
            $.post(url, postData, function (response) {
            console.log(response);
            console.log(edit)
            if(response==1){
                alert('Nuevo Registro añadido');
            } else if (response==0) {
                alert('Ya Este Tutor Existe Porfavor comprobe los Registros')
            } else {
                alert('?')
            }
            fetchTask();
            $('#task-form').trigger('reset');
            }).fail(function() {
              alert("Error en el servidor. Por favor, intenta nuevamente."); // Mostrar mensaje de error en caso de falla en la conexión con el servidor
            });
        } else {
            let url = '../controllers/tutor_inst/UserEdit.php';
            $.post(url, postData, function (response) {
                console.log(response);
                console.log(edit)
                fetchTask();
                $('#task-form').trigger('reset');
                $('#cedula').attr('readonly', false);
                edit = false;
                alert("Tutor Empresarial Editado"); // Usuario insertado correctamente
            })
        } 
          e.preventDefault(); // Se agrega para prevenir el comportamiento predeterminado del formulario    
    })

    function fetchTask(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/tutor_inst/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<tr taskid="${task.ID}">
                        <td>${task.CEDULA}</td>
                        <td>${task.NOMBRE}</td>
                        <td>${task.APELLIDO}</td>
                        <td>${task.GENERO}</td>
                        <td>${task.TELEFONO}</td>
                        <td>${task.E_MAIL}</td>
                        <td>${task.CARGO}</td>
                        <td>${task.PROFESION}</td>
                        <td>${task.EMPRESA}</td>
                        <td>
                            <button class="task-delete "><spam class="texto">Borrar</spam><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path></svg></span></button>
                        </td>
                        <td>
                            <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><spam class="icon"><svg viewBox="0 0 512 512">
                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg></spam></button>
                        </td>
                    </tr>
                    `
                })
                $('#datos').html(template);//los imprimo en el html
            }
        }) 
    }
    $(document).on('click','.task-delete',function(){//escucho un click del boton task-delete que es una clase

        // Agregamos la alerta de confirmación
        if (!confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            return false; // Cancela la eliminación si el usuario hace clic en "Cancelar"
        }
    
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/tutor_inst/UserDelete.php',{id}, function (response) {//mando los datos al controlador
            alert(response)
            fetchTask();//vuelvo a llamar a la funcion de la tabla para que actualize los datos
        })
    })

    $(document).on('click','.task-edit',function(){//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/tutor_inst/UserEditSearch.php', {id}, function(response){//mando los datos al controlador
            alert(response)
            const task = JSON.parse(response)[0]; // accede al primer objeto en el array
            const cedula = task.CEDULA.split("-");
            $('#id').val(task.ID).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#nacionalida').val(cedula[0]).prop('readonly', true);
            $('#cedula').val(cedula[1]).prop('readonly', true);
            $('#nombre').val(task.NOMBRE);
            $('#apellido').val(task.APELLIDO);
            $('#genero').val(task.GENERO);
            $('#tlf').val(task.TELEFONO);
            $('#e_mail').val(task.E_MAIL);
            $('#carrera').val(task.ID_CARRERA);
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });
    })
    
})

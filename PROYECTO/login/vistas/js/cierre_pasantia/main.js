$(document).ready(function(){//aqui inicializamos javascript
    let edit = false;// esta variable de lectura la inicializo para que el form de enviar pueda volverse en un editar si es True
    console.log("jquery is working");// para saber que jquery este funcionando
    fetchTask()
    combofiltrocarrera();
    combolapso();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    comboempresa();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    combocarrera();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    combodocente();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    $('#estudiante').hide();//esto lo hice para que el buscar no se muestre mientras no exista una busqueda

    // Validation for search input
    $('#search').on('input', function() {
        // Remove any non-digit characters
        let search = $(this).val().replace(/\D/g,'');
        // Limit to 8 digits
        search = search.substring(0, 8);
        $(this).val(search);
    }).on('click', function() {
        let search = $('#search').val();
        if (!/^\d{1,8}$/.test(search)) {
            alert('Solo se admiten números y un máximo de 8 dígitos.');
        }
    });
    
     // Validation for search input
     $('#docenteSearch').on('input', function() {
        // Remove any non-digit characters
        let docenteSearch = $(this).val().replace(/\D/g,'');
        // Limit to 8 digits
        docenteSearch = docenteSearch.substring(0, 8);
        $(this).val(docenteSearch);
    }).on('click', function() {
        let docenteSearch = $('#docenteSearch').val();
        if (!/^\d{1,8}$/.test(docenteSearch)) {
            alert('Solo se admiten números y un máximo de 8 dígitos.');
        }
    });

     // Validation for search input
     $('#tutorSearch').on('input', function() {
        // Remove any non-digit characters
        let tutorSearch = $(this).val().replace(/\D/g,'');
        // Limit to 8 digits
        tutorSearch = tutorSearch.substring(0, 8);
        $(this).val(tutorSearch);
    }).on('click', function() {
        let tutorSearch = $('#tutorSearch').val();
        if (!/^\d{1,8}$/.test(tutorSearch)) {
            alert('Solo se admiten números y un máximo de 8 dígitos.');
        }
    });

      // Validation for search input
      $('#empresaSearch').on('input', function() {
        // Remove any non-digit characters
        let empresaSearch = $(this).val().replace(/\D/g,'');
        // Limit to 9 digits
        empresaSearch = empresaSearch.substring(0, 9);
        $(this).val(empresaSearch);
    }).on('click', function() {
        let empresaSearch = $('#empresaSearch').val();
        if (!/^\d{1,8}$/.test(empresaSearch)) {
            alert('Solo se admiten números y un máximo de 9 dígitos.');
        }
    });

    $('#search').keyup(function(e){ //esta es una funcion q cada vez que en el campo #search se levante una tecla se realize una peticion
        let search = $('#search').val();//leemos el valor que existe en el input
        if (/^\d{1,8}$/.test(search)) {//si el valor es un número entre 1 y 8 dígitos, realiza la búsqueda
            $.ajax({//realizamos una peticion ajax
                url: '../controllers/cierre_pasantia/InscripcionList.php',// a esta url
                type: 'POST',//que envie los datos del input search cada vez que una tecla se presiona de forma dinamica
                data: {search},//enviamosla variable de tipo lectura search q fue declarada arriba
                success: function(response){ //si recibo una respuesta exitosa haz esto
                    let datasearch = JSON.parse(response);//primero convierte el json q recibi de php en un string 
                    let template = '<option value="" disabled="" selected="">Seleccione una opción</option>';// inicializo una plantilla donde cargare los datos del servidor
                    datasearch.forEach(task =>{//itero el codigo con un foreach para que me traiga lo que encontro en el array
                        template +=`<option value="${task.id}">Inscripcion:${task.id}</option>">`
                    })
                    $('#estudiante').html(template);//imprimo eso en el html
                    $('#estudiante').show();// muestro los resultados
                }
            })
        } else {//si el valor no es un número entre 1 y 8 dígitos, oculta los resultados de búsqueda
            $('#estudiante').hide();
        }
    })
    

    $('#task-form').submit(function(e){//reviso del formulario task el evento submit
            const lapso = $('#lapso').val();
            const carrera = $('#carrera').val();
            const estudiante = $('#estudiante').val();
            const empresa = $('#empresa').val();
            const docente = $('#docente').val();
            const tutor = $('#tutor').val();

            if (!confirm('¿Quieres proceder con el registro?')) {
                return false; // Cancela el envío del formulario si el usuario hace clic en "Cancelar"
              }

            const postData = {
                lapso: lapso,
                carrera: carrera,
                estudiante: estudiante,
                empresa: empresa,
                docente: docente,
                tutor: tutor
        
            };
            
            let url = '../controllers/cierre_pasantia/UserAdd.php';
            $.post(url,postData, function (response) {
                console.log(response)
                $('#task-form').trigger('reset');
                fetchTask()
            })
            e.preventDefault();
        })
    

    function fetchTask(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/cierre_pasantia/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<tr taskid="${task.id}">
                        <td>${task.lapso_academico}</td>
                        <td>${task.id_persona}</td>
                        <td>${task.estudiante_nombre}</td>
                        <td>${task.estudiante_apellido}</td>
                        <td>${task.empresa_nombre}</td>
                        <td>${task.carrera_nombre}</td>
                        <td>${task.docente_id_persona}</td>
                        <td>${task.docente_nombre}</td>
                        <td>${task.docente_apellido}</td>
                        <td>${task.tutor_empresarial_id_persona}</td>
                        <td>${task.tutor_empresarial_nombre}</td>
                        <td>${task.tutor_empresarial_apellido}</td>
                        <td>
                            <button class="task-delete">Eliminar</button>
                        </td>
                        <td>
                            <button class="task-report">Reporte</button>
                        </td>
                    </tr>
                    `
                })
                $('#datos').html(template);//los imprimo en el html
            }
        }) 
    }
    $(document).on('click','.task-delete',function(){//escucho un click del boton task-delete que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
       // Display confirmation dialog
    if (confirm('¿Estás seguro de eliminar este registro?')) {
        $.post('../controllers/cierre_pasantia/UserDelete.php',{id}, function (response) {
            fetchTask();
        });
    }
});

$(document).on('click','.task-edit',function(){//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/cierre_pasantia/UserEditSearch.php', {id}, function(response){//mando los datos al controlador
            const task = JSON.parse(response)[0]; // accede al primer objeto en el array
            $('#id').val(task.id).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#cedula').val(task.cedula).prop('readonly', true);
            $('#nombre').val(task.nombre);
            $('#apellido').val(task.apellido);
            $('#genero').val(task.genero);
            $('#fecha_nacimiento').val(task.fecha_nacimiento);
            $('#rif').val(task.rif);
            $('#direccion').val(task.direccion);
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });  
    })

    $(document).on('click','.task-report',function(){
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');
        $.post('../controllers/cierre_pasantia/UserEditSearch.php', {id}, function(response){
            const task = JSON.parse(response)[0];
    
            // Generar el informe y abrirlo en una nueva ventana
            const reportUrl = 'reporte.html?id=' + task.id;
            window.open(reportUrl, '_blank');
    
            // Volver a la página original
            window.location.href = 'index.html';
        });
    });
    
    function combolapso(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/cierre_pasantia/LapsoList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '<option value="" disabled="" selected="">Seleccione una opción</option>'; // Agregar la opción fuera del bucle
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<option value="${task.codigo}">${task.nombre}</option>">`
                })
                $('#lapso').html(template);//los imprimo en el html
            }
        }) 
    }

    function comboempresa(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/cierre_pasantia/LapsoList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '<option value="" disabled="" selected="">Seleccione una opción</option>'; // Agregar la opción fuera del bucle
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<option value="${task.codigo}">${task.nombre}</option>">`
                })
                $('#lapso').html(template);//los imprimo en el html
            }
        }) 
    }

    $('#area').hide();//esto lo hice para que el buscar no se muestre mientras no exista una busqueda
    $('#areaSearch').keyup(function(e){ //esta es una funcion q cada vez que en el campo #search se levante una tecla se realize una peticion
        let search = $('#areaSearch').val();//leemos el valor que existe en el input
        if (/^\d{1,8}$/.test(search)) {//si el valor es un número entre 1 y 8 dígitos, realiza la búsqueda
            $.ajax({//realizamos una peticion ajax
                url: '../controllers/cierre_pasantia/AreaList.php',// a esta url
                type: 'POST',//que envie los datos del input search cada vez que una tecla se presiona de forma dinamica
                data: {search},//enviamosla variable de tipo lectura search q fue declarada arriba
                success: function(response){ //si recibo una respuesta exitosa haz esto
                    let datasearch = JSON.parse(response);//primero convierte el json q recibi de php en un string
                    let taskNombre; 
                    let template = '<option value="" disabled="" selected="">Seleccione una opción</option>'; // Agregar la opción fuera del bucle
                    datasearch.forEach(task =>{//itero el codigo con un foreach para que me traiga lo que encontro en el array
                        template +=`<option value="${task.codigo}">${task.codigo}-${task.nombre}</option>`
                        taskNombre = task.nombre;
                    })
                    $('#area').html(template);//imprimo eso en el html
                    $('#area').show();// muestro los resultados
                    $('#titulo-proyecto').val(taskNombre);
                }
            })
        } else {//si el valor no es un número entre 1 y 8 dígitos, oculta los resultados de búsqueda
            $('#area').hide();
        }
    })

    $('#docente').hide();//esto lo hice para que el buscar no se muestre mientras no exista una busqueda
    $('#docenteSearch').keyup(function(e){ //esta es una funcion q cada vez que en el campo #search se levante una tecla se realize una peticion
        let search = $('#docenteSearch').val();//leemos el valor que existe en el input
        if (/^\d{1,8}$/.test(search)) {//si el valor es un número entre 1 y 8 dígitos, realiza la búsqueda
            $.ajax({//realizamos una peticion ajax
                url: '../controllers/cierre_pasantia/DocenteList.php',// a esta url
                type: 'POST',//que envie los datos del input search cada vez que una tecla se presiona de forma dinamica
                data: {search},//enviamosla variable de tipo lectura search q fue declarada arriba
                success: function(response){ //si recibo una respuesta exitosa haz esto
                    let datasearch = JSON.parse(response);//primero convierte el json q recibi de php en un string 
                    let template = '<option value="" disabled="" selected="">Seleccione una opción</option>'; // Agregar la opción fuera del bucle
                    datasearch.forEach(task =>{//itero el codigo con un foreach para que me traiga lo que encontro en el array
                        template +=`<option value="${task.id}">${task.cedula}-${task.nombre} ${task.apellido}-${task.nombre_profesion}</option>`
                    })
                    $('#docente').html(template);//imprimo eso en el html
                    $('#docente').show();// muestro los resultados
                }
            })
        } else {//si el valor no es un número entre 1 y 8 dígitos, oculta los resultados de búsqueda
            $('#docente').hide();
        }
    })




    function combocarrera(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/cierre_pasantia/CarreraList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '<option value="" disabled="" selected="">Seleccione una opción</option>'; // Agregar la opción fuera del bucle
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<option value="${task.codigo}">${task.codigo}-${task.nombre}</option>">`
                })
                $('#carrera').html(template);//los imprimo en el html
            }
        }) 
    }

    function combodocente(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/cierre_pasantia/DocenteFilter.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '<option value="" selected="">Seleccione una opción</option>'; // Agregar la opción fuera del bucle
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<option value="${task.id}">Docente: ${task.nombre} ${task.apellido}</option>">`
                })
                $('#filtrarDocente').html(template);//los imprimo en el html
            }
        }) 
    }



    function combofiltrocarrera(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/cierre_pasantia/CarreraList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '<option value=""selected="">Seleccione una opción</option>'; // Agregar la opción fuera del bucle
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<option value="${task.codigo}">${task.nombre}</option>">`
                })
                $('#filtrarCarrera').html(template);//los imprimo en el html
            }
        }) 
    }

    
    
})

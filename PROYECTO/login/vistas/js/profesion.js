$(document).ready(function(){//aqui inicializamos javascript
    let edit = false;// esta variable de lectura la inicializo para que el form de enviar pueda volverse en un editar si es True
    console.log("jquery is working");// para saber que jquery este funcionando
    fetchTask();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    $('task-result').hide();//esto lo hice para que el buscar no se muestre mientras no exista una busqueda
    $('#search').keyup(function(e){ //esta es una funcion q cada vez que en el campo #search se levante una tecla se realize una peticion
        let search = $('#search').val();//leemos el valor que existe en el input
        if (/^\d{1,8}$/.test(search)) {//si el valor es un número entre 1 y 8 dígitos, realiza la búsqueda
            $.ajax({//realizamos una peticion ajax
                url: '../controllers/profesion/UserSearch.php',// a esta url
                type: 'POST',//que envie los datos del input search cada vez que una tecla se presiona de forma dinamica
                data: {search},//enviamosla variable de tipo lectura search q fue declarada arriba
                success: function(response){ //si recibo una respuesta exitosa haz esto
                    let datasearch = JSON.parse(response);//primero convierte el json q recibi de php en un string 
                    let template = '';// inicializo una plantilla donde cargare los datos del servidor
                    datasearch.forEach(task =>{//itero el codigo con un foreach para que me traiga lo que encontro en el array
                        template += `<li>${task.codigo}</li>`//imprimo por cada item que exista en el array lo que encontro
                    })
                    $('#container').html(template);//imprimo eso en el html
                    $('#task-result').show();// muestro los resultados
                }
            })
        } else {//si el valor no es un número entre 1 y 8 dígitos, oculta los resultados de búsqueda
            $('#task-result').hide();
        }
    })
    

    
    $('#task-form').submit(function(e){
        const codigo = $('#codigo').val();
        const nombre = $('#nombre').val();
        const estatus = $('#estatus').val();
        let errores = false; // Variable para comprobar si hay errores
        
        
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test(nombre)) { // Validating "nombre" field
            alert("El campo 'Profesión' solo puede contener letras");
            errores = true; // Se marca que hay errores
        }
        
        if (errores) { // Se comprueba si hay errores
            return false; // Cancela el envío del formulario
        }
        
        // Agregamos la alerta de confirmación
        if (confirm('¿Confirmar acción?')) {
            const postData = {
                codigo: codigo,
                nombre: nombre,
                estatus: estatus
            };
            
            let url = edit === false ? '../controllers/profesion/UserAdd.php' : '../controllers/controllers_profesion/UserEdit.php';
            $.post(url,postData, function (response) {
                console.log(response)
                fetchTask();
                $('#task-form').trigger('reset');
            })
            e.preventDefault();
        } else {
            // Si el usuario hace clic en "Cancelar", no se envía la solicitud de registro
            return false;
        }
    });

    function fetchTask(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/profesion/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<tr taskid="${task.codigo}">
                        <td>${task.codigo}</td>
                        <td>${task.nombre}</td>
                        <td>
                            <button class="task-delete "><spam class="texto">Borrar</spam><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button>
                        </td>
                        <td>
                            <button class="task-edit" onclick="window.dialog.showModal();"><spam class="texto">Editar</spam><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
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
        
        // Agregamos la alerta de confirmación
        if (confirm('¿Está seguro de eliminar este registro?')) {
            $.post('../controllers/profesion/UserDelete.php',{id}, function (response) {//mando los datos al controlador
                fetchTask();//vuelvo a llamar a la funcion de la tabla para que actualize los datos
            });
        } else {
            // Si el usuario hace clic en "Cancelar", no se envía la solicitud de eliminación
            return false;
        }
    });
$(document).on('click','.task-edit',function(){//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/profesion/UserEditSearch.php', {id}, function(response){//mando los datos al controlador
            const task = JSON.parse(response)[0]; // accede al primer objeto en el array
            $('#codigo').val(task.codigo).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#nombre').val(task.nombre);
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });

        
        
    })
})

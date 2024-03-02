$(document).ready(function(){//aqui inicializamos javascript
    let edit = false;// esta variable de lectura la inicializo para que el form de enviar pueda volverse en un editar si es True
    console.log("jquery is working");// para saber que jquery este funcionando
    fetchTask();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    $('#rif').change(function(e){
        let search = $('#rif').val();
        $.ajax({
            url: '../controllers/empresa/UserSearch.php',
            type: 'POST',
            data: {search},
            success: function(response){
                let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
                if (Object.keys(data).length === 0) { // Verificamos si el objeto está vacío
                    console.log('no existe');
                } else {
                    alert("Este RIF Ya Existe");

                }
            },
            error: function(error) {
                console.log(error);
            } 
        })
    })
    

    $('#task-form').submit(function(e){//reviso del formulario task el evento submit
        const id = $('#id').val();
        const rif = $('#rif').val();
        const rif2 = $('#rif2').val();
        const nombre = $('#nombre').val();
        const direccion = $('#direccion').val();
        const nombre_contacto = $('#nombre_contacto').val();
        const telefono_contacto = $('#telefono_contacto').val();
        const telefono_contacto2 = $('#telefono_contacto2').val();
        const telefono_empresa = $('#telefono_empresa').val();
        const telefono_empresa2 = $('#telefono_empresa2').val();
        let errores = false;
    
        if (!/^\d{9}$/.test(rif2)) { // Validating "rif" field
            alert("El campo 'Rif' solo puede contener números y 9 en total");
            errores = true; // Se marca que hay errores
        }
        
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test(nombre)) { // Validating "nombre" field
            alert("El campo 'Empresa' solo puede contener letras");
            errores = true; // Se marca que hay errores
        }
        
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test(nombre_contacto)) { // Validating "nombre_contacto" field
            alert("El campo 'Nombre de Contacto' solo puede contener letras");
            errores = true; // Se marca que hay errores
        }
        
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ0-9.,;:¡!¿?"'()-_@ ]+$/.test(direccion)) { // Validating "direccion" field
            alert("El campo 'Direccion' solo puede contener letras y numeros");
            errores = true; // Se marca que hay errores
        }
        
        if (!/^\d{7}$/.test(telefono_contacto2)) { // Validating "telefono_contacto" field
            alert("El campo 'Telefono de Contacto' debe contener 7 numeros");
            errores = true; // Se marca que hay errores
        }
        
        
        if (!/^\d{7}$/.test(telefono_empresa2)) { // Validating "telefono_empresa" field
            alert("El campo 'Telefono de la Empresa' debe contener 7 numeros");
            errores = true; // Se marca que hay errores
        }
        
        if (errores) { // Se comprueba si hay errores
            return false; // Cancela el envío del formulario
        }
        
        // Agregamos la alerta de confirmación
        if (confirm('¿Quieres proceder con el registro?')) {
            const postData = {
                id: id,
                rif: rif,
                rif2: rif2,
                nombre: nombre,
                direccion: direccion,
                nombre_contacto: nombre_contacto,
                telefono_contacto: telefono_contacto,
                telefono_contacto2: telefono_contacto2,
                telefono_empresa: telefono_empresa,
                telefono_empresa2: telefono_empresa2,
    
            };
            if (edit === false) {
                let url = '../controllers/empresa/UserAdd.php';
                $.post(url, postData, function (response) {
                  console.log(response);
                  console.log(edit)
                  if(response==1){
                    alert('Ya Ha sido añadido');
                  } else if (response==0) {
                    alert('Ya Esta Empresa Existe Porfavor comprobe los Registros')
                  } else {
                    alert('?')
                  }
                  fetchTask();
                  $('#task-form').trigger('reset');
                }).fail(function() {
                  alert("Error en el servidor. Por favor, intenta nuevamente."); // Mostrar mensaje de error en caso de falla en la conexión con el servidor
                });
              }
              e.preventDefault(); // Se agrega para prevenir el comportamiento predeterminado del formulario
              if (edit === true) {
                let url = '../controllers/empresa/UserEdit.php';
                $.post(url, postData, function (response) {
                  console.log(response);
                  fetchTask();
                  $('#task-form').trigger('reset');
                  $('#rif2').attr('readonly', false);
                  edit = false;
                })
              }
              
              e.preventDefault(); // Se agrega para prevenir el comportamiento predeterminado del formulario
        } else {
            // Si el usuario hace clic en "Cancelar", no se envía el formulario
            return false;
        }
    });

    function fetchTask(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/empresa/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<tr taskid="${task.id}">
                        <td>${task.rif}</td>
                        <td>${task.nombre}</td>
                        <td>${task.direccion}</td>
                        <td>${task.nombre_contacto}</td>
                        <td>${task.telefono_contacto}</td>
                        <td>${task.telefono_empresa}</td>
                        <td>
                            <button class="task-delete">Delete</button>
                        </td>
                        <td>
                            <button class="task-edit">Editar</button>
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
        if (confirm('¿Estás seguro que deseas eliminar este registro?')) {
            $.post('../controllers/empresa/UserDelete.php',{id}, function (response) {//mando los datos al controlador
                fetchTask();//vuelvo a llamar a la funcion de la tabla para que actualize los datos
            });
        } else {
            // Si el usuario hace clic en "Cancelar", no se elimina el registro
            return false;
        }
    });

$(document).on('click','.task-edit',function(){//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/empresa/UserEditSearch.php', {id}, function(response){//mando los datos al controlador
            const task = JSON.parse(response)[0]; // accede al primer objeto en el array
            $('#id').val(task.id).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#rif2').val(task.rif.slice(2)).prop('readonly', true);
            $('#nombre').val(task.nombre);
            $('#direccion').val(task.direccion);
            $('#nombre_contacto').val(task.nombre_contacto);
            $('#telefono_contacto2').val(task.telefono_contacto.slice(5));
            $('#telefono_empresa2').val(task.telefono_empresa.slice(5));
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });

        
        
    })
})

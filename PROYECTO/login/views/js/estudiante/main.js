$(document).ready(function(){//aqui inicializamos javascript
    let edit = false;// esta variable de lectura la inicializo para que el form de enviar pueda volverse en un editar si es True
    console.log("jquery is working");// para saber que jquery este funcionando
    console.log(edit);
    fetchTask();//inicializo la funcion que cada vez que cargue la pagina le pida al servidor que me de los campos
    $('#cedula').change(function(e){
        let search = $('#cedula').val();
        $.ajax({
            url: '../controllers/estudiante/UserSearch.php',
            type: 'POST',
            data: {search},
            success: function(response){
                let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
                if (Object.keys(data).length === 0) { // Verificamos si el objeto está vacío
                    console.log('no existe');
                } else {
                    alert("El Estudiante Con esta Cedula Ya Existe");
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
            e.preventDefault(); // Cancela el envío del formulario si el usuario hace clic en "Cancelar"
            return false;
        }
        
        const id = $('#id').val();
        const cedula = $('#cedula').val();
        // const cedula2 = $('#cedula2').val();
        const nombre = $('#nombre').val();
        const apellido = $('#apellido').val();
        const genero = $('#genero').val();
        const direccion = $('#direccion').val();
        let errores = false;
    
        if (!/^\d{8}$/.test(cedula)) { // Validating "telefono_empresa" field
            alert("El campo 'Cedula' debe contener 8 numeros");
            errores = true; // Se marca que hay errores
        }
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test(nombre)) { // Validating "nombre" field
            alert("El campo 'Nombre' solo puede contener letras");
            errores = true; // Se marca que hay errores
        }
    
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test(apellido)) { // Validating "nombre_contacto" field
            alert("El campo 'Apellido' solo puede contener letras");
            errores = true; // Se marca que hay errores
        }
    
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ0-9.,;:¡!¿?"'()-_@ ]+$/.test(direccion)) { // Validating "direccion" field
            alert("El campo 'Direccion' solo puede contener letras y numeros");
            errores = true; // Se marca que hay errores
        }
    
        if (errores) { // Se comprueba si hay errores
            e.preventDefault(); // Cancela el envío del formulario si hay errores
            return false;
        }
    
        const postData = {
            id: id,
            nombre: nombre,
            direccion: direccion,
            cedula: cedula,
            // cedula2: cedula2,
            apellido: apellido,
            genero: genero
    
        };
        if (edit === false) {
            let url = '../controllers/estudiante/UserAdd.php';
            $.post(url, postData, function (response) {
              console.log(response);
              console.log(edit)
              if(response==1){
                alert('Este Nuevo Registro ha sido añadido');
              } else if (response==0) {
                alert('Ya Este Estudiante Existe Porfavor comprobe los Registros')
              } else {
                alert('?')
              }
              fetchTask();
              $('#task-form').trigger('reset');
            }).fail(function() {
              alert("Error en el servidor. Por favor, intenta nuevamente."); // Mostrar mensaje de error en caso de falla en la conexión con el servidor
            });
          } else {
            let url = '../controllers/estudiante/UserEdit.php';
            $.post(url, postData, function (response) {
                console.log(response);
                console.log(edit)
                fetchTask();
                $('#task-form').trigger('reset');
                $('#cedula').attr('readonly', false);
                edit = false;
                alert("Registro Editado"); // Usuario insertado correctamente
            })
          } 
          e.preventDefault(); // Se agrega para prevenir el comportamiento predeterminado del formulario     
    })

    function fetchTask(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/estudiante/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<tr taskid="${task.cedula}">
                        <td>${task.id_persona}</td>
                        <td>${task.nombre}</td>
                        <td>${task.apellido}</td>
                        <td>${task.genero}</td>
                        <td>${task.direccion}</td>
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
    $(document).on('click','.task-delete',function(){
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('taskid');
        
        // Agregamos la alerta de confirmación
        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            $.post('../controllers/estudiante/UserDelete.php',{id}, function (response) {
                fetchTask();
            });
        } else {
            // Si el usuario hace clic en "Cancelar", no se elimina el usuario
            return false;
        }
    });

$(document).on('click','.task-edit',function(){//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/estudiante/UserEditSearch.php', {id}, function(response){//mando los datos al controlador
            const task = JSON.parse(response)[0]; // accede al primer objeto en el array
            $('#id').val(task.id).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#cedula').val(task.cedula).prop('readonly', true);
            $('#nombre').val(task.nombre);
            $('#apellido').val(task.apellido);
            $('#genero').val(task.genero);
            $('#direccion').val(task.direccion);
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });
    })
})

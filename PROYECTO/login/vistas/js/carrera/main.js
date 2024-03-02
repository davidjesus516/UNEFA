$(document).ready(function(){
    let edit = false;
    console.log("jquery is working");
    let errores = false;// Variable para comprobar si hay errores
    fetchTask();
    $('task-result').hide();
    $('#search').keyup(function(e){
        let search = $('#search').val();
        if (/^\d{1,8}$/.test(search)) {
            $.ajax({
                url: '../controllers/carrera/UserSearch.php',
                type: 'POST',
                data: {search},
                success: function(response){
                    let datasearch = JSON.parse(response);
                    let template = '';
                    datasearch.forEach(task =>{
                        template += `<li>${task.codigo}</li>`
                    })
                    $('#container').html(template);
                    $('#task-result').show();
                }
            })
        } else {
            $('#task-result').hide();
        }
    })
    $('#nombre').change(function(e){
        let nombre = $('#nombre').val();
        $.ajax({
            url: '../controllers/carrera/UserSearch.php',
            type: 'POST',
            data: {nombre : nombre},
            success: function(response){
                let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
                if (Object.keys(data).length === 0) { // Verificamos si el objeto está vacío
                    console.log('no existe');
                } else {
                    $('#grupo__nombre').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
                    $('#grupo__nombre i').addClass("fa-times-circle").removeClass("fa-check-circle");
                    $(`#grupo__nombre .formulario__input-error`).addClass('formulario__input-error-activo');
                    $('#grupo__nombre p').text("esta carrera ya existe");
                    errores = true
                }
            },
            error: function(error) {
                console.log(error);
            } 
        })
    })
    $('#codigo').change(function(e){
        let codigo = $('#codigo').val();
        $.ajax({
            url: '../controllers/carrera/UserSearch.php',
            type: 'POST',
            data: {codigo : codigo},
            success: function(response){
                let data = JSON.parse(response); // Convertimos la respuesta en un objeto JSON
                if (Object.keys(data).length === 0) { // Verificamos si el objeto está vacío
                    console.log('no existe');
                } else {
                    $('#grupo__codigo').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
                    $('#grupo__codigo i').addClass("fa-times-circle").removeClass("fa-check-circle");
                    $(`#grupo__codigo .formulario__input-error`).addClass('formulario__input-error-activo');
                    $('#grupo__codigo p').text("este codigo ya existe");
                    errores = true
                }
            },
            error: function(error) {
                console.log(error);
            } 
        })
    })

    $('#formulario').submit(function(e){
        const id = $('#id').val();
        const codigo = $('#codigo').val();
        const nombre = $('#nombre').val();

        
        
        if (!/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]+$/.test(nombre)) { // Validating "nombre" field
            alert("El campo de nombre solo puede contener letras");
            errores = true; // Se marca que hay errores
        }
        
        if (errores) { // Se comprueba si hay errores
            e.preventDefault(); // Cancela el envío del formulario si hay errores
            alert("debe llenar correctamente el formulario");
            return false;
        }
        
        // Agregamos la alerta de confirmación
        if (confirm('¿Quieres proceder con el registro?')) {
            const postData = {
                id: id,
                codigo: codigo,
                nombre: nombre
            };
            if (errores) { // Se comprueba si hay errores
                e.preventDefault(); // Cancela el envío del formulario si hay errores
                alert("debe llenar correctamente el formulario");
                return false;
            }
            let url = edit === false ? '../controllers/carrera/UserAdd.php' : '../controllers/carrera/UserEdit.php';
            $.post(url,postData, function (response) {
                console.log(response)
                fetchTask();
                $('#formulario').trigger('reset');
            });
        } else {
            // Si el usuario hace clic en "Cancelar", no se envía el formulario
            return false;
        }
        
        e.preventDefault();
    });

    function fetchTask(){//esta funcion es la que se encarga de traer todos los datos de la base de datos y los imprime en el html
        $.ajax({//realizo una peticion ajax
            url: '../controllers/carrera/UserList.php',//al url que trae la lista
            type: 'GET',//le pido una peticion GET
            success: function (response){// si tengo una respuesta ejecuta la funcion
                let task = JSON.parse(response);// convierto el json en string
                let template = '';//creo la plantilla donde imprimire los datos
                task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                    template +=`<tr taskid="${task.id}">
                        <td>${task.codigo}</td>
                        <td>${task.nombre}</td>
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
        if (confirm('¿Está seguro de eliminar este registro?')) {
            $.post('../controllers/carrera/UserDelete.php',{id}, function (response) {//mando los datos al controlador
                alert("usuario eliminado")
                fetchTask();//vuelvo a llamar a la funcion de la tabla para que actualize los datos
            });
        } else {
            // Si el usuario hace clic en "Cancelar", no se envía el formulario
            return false;
        }
    });

$(document).on('click','.task-edit',function(){//escucho un click del boton task-edit que es una clase
        let element = $(this)[0].parentElement.parentElement;// accedo al elemento padre de este hasta conseguir el ID de la fila
        let id = $(element).attr('taskid');//accedo al tributo que cree que contiene la cedula que busco
        $.post('../controllers/carrera/UserEditSearch.php', {id}, function(response){//mando los datos al controlador
            const task = JSON.parse(response)[0]; // accede al primer objeto en el array
            $('#codigo').val(task.codigo).prop('readonly', true);//añado los elementos al formulario y lo hago de solo lectura
            $('#nombre').val(task.nombre);
            edit = true;//valido la variable que esta por encima de todo para que en vez de guardar un nuevo usuario lo edite
        });

        
        
    })
})

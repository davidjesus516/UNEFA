$(document).ready(function() {
    let edit = false;
    console.log("jQuery is working");
    console.log(edit);
    
    fetchLists();
    fetchValueLists();
    
    function modalClose() {
        $('#close').on('click', function(e) {
            $('#respuesta')[0].close();
            $("#respuesta").html('');
        });
    }
    
    function modalOpen(response) {
        
        $('#respuesta').html(response);
        $('#respuesta')[0].showModal();
    }
    
    let errores = false;
    
    // Expresiones regulares para validación
    const expresiones = {
        nombre: /^[a-zA-ZÁ-ÿ\s]{3,40}$/, // Nombres de 3 a 40 caracteres
        abreviatura: /^[A-Z]{2,8}$/ // Abreviatura de 2 a 8 letras mayúsculas
    }
    
    // Validación del campo nombre
    $('#list_name').keyup(function(e) {
        if (expresiones.nombre.test($('#list_name').val())) {
            $('#grupo__nombre').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__nombre i').addClass("fa-check-circle").removeClass("fa-times-circle");
            $('#grupo__nombre .formulario__input-error').removeClass('formulario__input-error-activo');
            errores = false;
        } else {
            $('#grupo__nombre').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $('#grupo__nombre i').addClass("fa-times-circle").removeClass("fa-check-circle");
            $('#grupo__nombre .formulario__input-error').addClass('formulario__input-error-activo');
            $('#grupo__nombre p').text("El nombre debe tener entre 3 y 40 caracteres.");
            errores = true;
        }
    });
    
    // Validación del campo abreviatura (para value lists)
    $('#value_abbreviation').keyup(function(e) {
        if (expresiones.abreviatura.test($('#value_abbreviation').val())) {
            $('#grupo__abreviatura').addClass("formulario__grupo-correcto").removeClass("formulario__grupo-incorrecto");
            $('#grupo__abreviatura i').addClass("fa-check-circle").removeClass("fa-times-circle");
            $('#grupo__abreviatura .formulario__input-error').removeClass('formulario__input-error-activo');
            errores = false;
        } else {
            $('#grupo__abreviatura').addClass("formulario__grupo-incorrecto").removeClass("formulario__grupo-correcto");
            $('#grupo__abreviatura i').addClass("fa-times-circle").removeClass("fa-check-circle");
            $('#grupo__abreviatura .formulario__input-error').addClass('formulario__input-error-activo');
            $('#grupo__abreviatura p').text("La abreviatura debe tener entre 2 y 8 letras mayúsculas.");
            errores = true;
        }
    });
    
    // Función para cargar todas las listas
    function fetchLists() {
        $.ajax({
            url: '../controllers/value_list/UserList.php',
            type: 'GET',
            success: function(response) {

          
                let lists = response.lists;
              
                

                let template = '<option value="" disabled selected>Seleccione una lista</option>';
                
                lists.forEach(list => {
                    template += `<option value="${list.LIST_ID}">${list.NAME}</option>`;
                });
                
                $('#list_select').html(template);
                
                // También llenamos la tabla de listas
                let tableTemplate = '';
                lists.forEach(list => {
                    tableTemplate += `
                    <tr listid="${list.LIST_ID}">
                        <td>${list.NAME}</td>
                        <td>${new Date(list.CREATION_DATE).toLocaleDateString()}</td>
                        <td>${list.STATUS ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <button class="task-delete list-delete"><span class="texto">Borrar</span><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button>
                        </td>
                        <td>
                            <button class="task-edit list-edit" onclick="document.getElementById('list-dialog').showModal();"><span class="texto">Editar</span><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
                        </td>
                    </tr>`;
                });
                
                $('#list_table').html(tableTemplate);
            }
        });
    }
    
    // Función para cargar todos los valores de lista
    function fetchValueLists() {
        $.ajax({
            url: '../controllers/value_list/UserList.php',
            type: 'GET',
            success: function(response) {
                let valueLists = response.value_lists;
                let tableTemplate = '';
                

                console.log(valueLists);

                valueLists.forEach(valueList => {
                    tableTemplate += `
                    <tr valuelistid="${valueList.VALUE_LIST_ID}">
                        <td>${valueList.NAME}</td>
                        <td>${valueList.ABBREVIATION || 'N/A'}</td>
                        <td>${valueList.LIST_NAME} (${valueList.LIST_ID}) </td>
                        <td>${new Date(valueList.CREATION_DATE).toLocaleDateString()}</td>
                        <td>${valueList.STATUS ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <button class="task-delete value-delete"><span class="texto">Borrar</span><span class="icon"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></span></button>
                        </td>
                        <td>
                            <button class="task-edit value-edit " onclick="document.getElementById('value-list-dialog').showModal();"><span class="texto">Editar</span><span class="icon"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></span></button>
                        </td>
                    </tr>`;
                });
                
                $('#value_list_table').html(tableTemplate);
            }
        });
    }
    
    // Formulario para Listas
    $('#list_form').submit(function(e) {
        if (!confirm('¿Desea proceder con el registro?')) {
            e.preventDefault();
            return false;
        }
        
        if (errores) {
            e.preventDefault();
            alert("Debe llenar correctamente el formulario");
            return false;
        }
        
        const id = $('#list_id').val();
        const name = $('#list_name').val();
        const modif_user_id = $('#user_id').val(); // Asumimos que tenemos un campo oculto con el ID del usuario
        
        const postData = {
            id: id,
            name: name,
            modif_user_id: modif_user_id,
            type: 'list'
        };
        
        if (edit === false) {
            let url = '../controllers/value_list/UserAdd.php';
            $.post(url, postData, function(response) {
                console.log(response);
                if(response.success) {
                    alert(response.message);
                    document.getElementById('list-dialog').close();
                } else {
                    alert(response.message);
                }
                fetchLists();
                $('#list_form').trigger('reset');
            }).fail(function() {
                alert("Error en el servidor. Por favor, intente nuevamente.");
            });
        } else {
            let url = '../controllers/value_list/UserEdit.php';
            $.post(url, postData, function(response) {
   
                fetchLists();
                $('#list_form').trigger('reset');
                edit = false;
                
                if(response.success) {
                    alert(response.message);
                    document.getElementById('list-dialog').close();
                } else {
                    alert(response.message);
                }
            });
        }
        
        e.preventDefault();
    });
    
    // Formulario para Value Lists
    $('#value_list_form').submit(function(e) {
        if (!confirm('¿Desea proceder con el registro?')) {
            e.preventDefault();
            return false;
        }
        
        if (errores) {
            e.preventDefault();
            alert("Debe llenar correctamente el formulario");
            return false;
        }
        
        const id = $('#value_list_id').val();
        const name = $('#value_name').val();
        const abbreviation = $('#value_abbreviation').val();
        const list_id = $('#list_select').val();
        const modif_user_id = $('#user_id').val();
        
        const postData = {
            id: id,
            value_name: name,
            abbreviation: abbreviation,
            list_id: list_id,
            modif_user_id: modif_user_id,
            type: 'value'
        };
        
        if (edit === false) {
            let url = '../controllers/value_list/UserAdd.php';
            $.post(url, postData, function(response) {
                console.log(response);
                if(response.success) {
                    alert(response.message);
                    document.getElementById('value-list-dialog').close();
                }  else {
                    alert(response.message);
                }
                fetchValueLists();
                $('#value_list_form').trigger('reset');
            }).fail(function() {
                alert("Error en el servidor. Por favor, intente nuevamente.");
            });
        } else {
            let url = '../controllers/value_list/UserEdit.php';
            $.post(url, postData, function(response) {
                console.log(response);
                fetchValueLists();
                $('#value_list_form').trigger('reset');
                edit = false;
                alert(response);
            });
        }
        
        e.preventDefault();
    });
    
    // Eliminar lista
    $(document).on('click', '.list-delete', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('listid');
        
        if (confirm('¿Está seguro de que desea eliminar esta lista?')) {
            $.post('../controllers/value_list/UserDelete.php', {id , type: 'list'}, function(response) {
                modalOpen(response);
                modalClose();
                fetchLists();
            });
        } else {
            return false;
        }
    });
    
    // Editar lista
    $(document).on('click', '.list-edit', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('listid');
        
        $.post('../controllers/value_list/UserEditSearch.php', {id , type: 'list' }, function(response) {

            console.log(response)
            const list = response;


            $('#list_id').val(list.LIST_ID).prop('readonly', true);
            $('#list_name').val(list.NAME);
            edit = true;

            $("#list-modal").show()
        });
    });
    
    // Eliminar value list
    $(document).on('click', '.value-delete', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('valuelistid');
        
        if (confirm('¿Está seguro de que desea eliminar este valor de lista?')) {
            $.post('../controllers/value_list/UserDelete.php', {id , type: 'list' }, function(response) {
                modalOpen(response);
                modalClose();
                fetchValueLists();
            });
        } else {
            return false;
        }
    });
    
    // Editar value list
    $(document).on('click', '.value-edit', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('valuelistid');
        
        $.post('../controllers/value_list/UserEditSearch.php', {id}, function(response) {
            const valueList = JSON.parse(response)[0];
            $('#value_list_id').val(valueList.VALUE_LIST_ID).prop('readonly', true);
            $('#value_name').val(valueList.NAME);
            $('#value_abbreviation').val(valueList.ABBREVIATION);
            $('#list_select').val(valueList.LIST_ID);
            edit = true;
        });
    });
    
    // Cuando se selecciona una lista, cargar sus valores
    $('#list_select').change(function() {
        const listId = $(this).val();
        if (listId) {
            $.post('../controllers/value_list/UserList.php', {list_id: listId}, function(response) {
                let valueLists = JSON.parse(response);
                let template = '';
                
                valueLists.forEach(valueList => {
                    template += `<option value="${valueList.VALUE_LIST_ID}">${valueList.NAME} (${valueList.ABBREVIATION || 'N/A'})</option>`;
                });
                
                $('#value_list_select').html(template);
            });
        }
    });
});
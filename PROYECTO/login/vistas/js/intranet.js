$(document).ready(function(){
    console.log("jquery is working");// para saber que jquery este funcionando
    $.ajax({//realizo una peticion ajax
        url: '../controllers/periodo/UserList.php',//al url que trae la lista
        type: 'GET',//le pido una peticion GET
        success: function (response){// si tengo una respuesta ejecuta la funcion
            let task = JSON.parse(response);// convierto el json en string
            let template = "";//creo la plantilla donde imprimire los datos
            task.forEach(task =>{//hago un array que me recorra el json y me lo imprima en el tbody
                template +=`<H1>${task.PERIODO}</H1>
                <p>Inicio ${task.FECHA_INICIO}</p>
                <p>Fin ${task.FECHA_FIN}</p>
                `
            })
            $('.name').html(template);//los imprimo en el html
        }
    })
})
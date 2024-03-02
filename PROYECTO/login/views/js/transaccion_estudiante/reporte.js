$(document).ready(function(){
    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);
    var id = urlParams.get('id');
    $.post('../../../controllers/controllers_transaccion_estudiante/UserEditSearch.php', {id}, function(response){
        let datasearch = JSON.parse(response);//primero convierte el json q recibi de php en un string 
            let lapso = ''; 
            let cedulaE = ''; 
            let nombreE = ''; 
            let apellidoE = ''; 
            let nombreC = '';
            let empresaN = ''; 
            let cedulaD = '';
            let nombreD = '';
            let apellidoD = '';
            let cedulaT = '';
            let nombreT = '';
            let apellidoT = '';

            datasearch.forEach(task =>{//itero el codigo con un foreach para que me traiga lo que encontro en el array
                lapso +=`<span>${task.lapso_academico}<span>`
                cedulaE +=`<span>${task.id_persona}<span>`
                nombreE +=`<span>${task.estudiante_nombre}<span>`  
                apellidoE +=`<span>${task.estudiante_apellido}<span>`
                nombreC +=`<span>${task.carrera_nombre}<span>` 
                empresaN +=`<span>${task.empresa_nombre}<span>` 
                cedulaD +=`<span>${task.doncente_id_persona}<span>`    
                nombreD +=`<span>${task.docente_nombre}<span>`    
                apellidoD +=`<span>${task.docente_apellido}<span>` 
                cedulaT +=`<span>${task.tutor_empresarial_id_persona}<span>` 
                nombreT +=`<span>${task.tutor_empresarial_nombre}<span>` 
                apellidoT +=`<span>${task.tutor_empresarial_apellido}<span>`    

            })
            $('#dato1').html(lapso);
            $('#dato2').html(cedulaE);
            $('#dato3').html(nombreE);
            $('#dato4').html(apellidoE);
            $('#dato5').html(nombreC);
            $('#dato6').html(empresaN);
            $('#dato7').html(cedulaD);
            $('#dato8').html(nombreD);
            $('#dato9').html(apellidoD);
            $('#dato10').html(cedulaT);
            $('#dato11').html(nombreT);
            $('#dato12').html(apellidoT);
    })
    setTimeout(function(){
        window.print();
    }, 2000);
});
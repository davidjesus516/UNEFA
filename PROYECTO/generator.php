<?php

$m="Aarón, Abel, Abraham, Adrián, Alejandro, Alex, Álvaro, Andrés, Ángel, Antonio
Aquiles, Arturo, Axel, Bruno, Bryan, Caleb, Carlos, Carmelo, César, Christian
Claudio, Daniel, David, Diego, Diego, Eduardo, Elías, Emiliano, Enrique, Enzo
Eduardo, Enzo, Esteban, Ezequiel, Felipe, Fernando, Francisco, Gabriel, Gael, Gonzalo
Guillermo, Hugo, Ian, Iván, Javier, Jesús, Joaquín, Jorge, José, José Antonio
Juan, Juan Manuel, Julián, Kevin, Lautaro, Leonardo, Luis, Lucas, Manuel, Mateo
Mauricio, Miguel, Nicolás, Noah, Pablo, Pedro, Rafael, Raúl, Roberto, Rodrigo
Roque, Santiago, Sebastián, Sergio, Simón, Tomás, Valentín, Vicente, Víctor, William";
$f="Aitana, Alejandra, Alicia, Alma, Amelia, Andrea, Ángela, Antonia, Arianna, Ariadna
Aurora, Beatriz, Blanca, Camila, Carla, Carolina, Catalina, Celia, Claudia, Constanza
Daniela, Delfina, Diana, Elena, Elisa, Emma, Emilia, Erica, Eva, Gabriela
Gala, Gemma, Helena, Inés, Irene, Isabella, Julia, Julieta, Laura, Lucía
Lola, Lorena, Martina, María, Marina, Marta, Martina, Natalia, Nerea, Nora
Olivia, Paula, Pilar, Raquel, Rebeca, Regina, Renata, Rita, Rosa, Sofía
Susana, Tatiana, Valeria, Valentina, Victoria, Violeta, Wendy, Ximena, Yolanda, Yara";
$apellidos="García, Rodríguez, González, Fernández, López, Martínez, Sánchez, Pérez, Hernández, Gómez";
$tlf = array("0412", "0426","0416","0414","0424");
$turno = array("D","N");
$f_r=explode(",", mb_strtoupper($f));
$m_r=explode(",", mb_strtoupper($m));
$a_r=explode(",", mb_strtoupper($apellidos));

// for ($i=0; $i <10 ; $i++) {
//     $t = $tlf[rand(0,4)].rand(1000000,9999999);
//     // Crear una instancia de la clase Usuario
//     $usuario = new Usuario();
//         $rn=random_int(0,1);
//     if ($rn===1) {
//     // llamar al método insertarUsuario() para insertar un nuevo Usuario
//     $result = $usuario->insertarUsuario(random_int(10000000,30000000),"V",
//     $m_r[random_int(0,72)]."_".
//     $m_r[random_int(0,72)],$a_r[random_int(0,9)]."_".$a_r[random_int(0,9)],
//     "M",$t,"profesor@unefa.com",1);

//     }
//     else {
//     // llamar al método insertarUsuario() para insertar un nuevo Usuario
//     $result = $usuario->insertarUsuario(random_int(10000000,30000000),"V",
//     $f_r[random_int(0,63)]."_".
//     $f_r[random_int(0,63)],$a_r[random_int(0,9)]."_".$a_r[random_int(0,9)],
//     "F",$t,"profesor@unefa.com",1);
    
//     }
// }

// $t = $tlf[rand(0,4)].rand(1000000,9999999);
//     // Crear una instancia de la clase Usuario
//     $usuario = new Usuario();
//     // llamar al método insertarUsuario() para insertar un nuevo Usuario
// $usuario->insertarUsuario(10315646,"V",
//     $m_r[random_int(0,72)]."_".
//     $m_r[random_int(0,72)],$a_r[random_int(0,9)]."_".$a_r[random_int(0,9)],
//     "M",$t,"estudiante@unefa.com"," ",1,"D",1);
    
for ($i=0; $i <1000 ; $i++) {
    require_once "login/model/pasantia.php";
    $t = $tlf[rand(0,4)].rand(1000000,9999999);
    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();
        $rn=random_int(0,1);
    if ($rn===1) {
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->inscribirNuevo(random_int(10000000,30000000),"V",
    $m_r[random_int(0,72)]." ".
    $m_r[random_int(0,72)],$a_r[random_int(0,9)]." ".$a_r[random_int(0,9)],
    "M",$t,"estudiante@unefa.com"," ",1,"D",1,1,1,1,1,1);

    }
    else {
    // llamar al método insertarUsuario() para insertar un nuevo Usuario
    $result = $usuario->inscribirNuevo(random_int(10000000,30000000),"V",
    $f_r[random_int(0,63)]." ".
    $f_r[random_int(0,63)],$a_r[random_int(0,9)]." ".$a_r[random_int(0,9)],
    "F",$t,"estudiante@unefa.com"," ",1,"D",1,1,1,1,1,1);
    
    }
}
 ?>
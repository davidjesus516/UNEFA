<?php
require('fpdf/fpdf.php');
class PDF extends FPDF{

    function Header(){
    	$this->SetY(10);
        $this->Image('../images/images.jpg',20,null,-300);
        $this->Image('../images/Nuevo_Escudo_de_la_UNEFA_(Desde_1999).jpg',180,10,15);
        $this->SetY(10);
        $this->SetFont('Arial', '', 11);
        $this->multicell(0,5,utf8_decode("REPÚBLICA BOLIVARIANA DE VENEZUELA \nMINISTERIO DEL PODER POPULAR PARA LA DEFENSA \nUNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA\nDE LA FUERZA ARMADA NACIONAL BOLIVARIANA \nVICERRECTORADO REGIÓN LOS LLANOS\n NÚCLEO PORTUGUESA EXTENSIÓN ACARIGUA
"),0,"C");
        $this->Ln();
    }
    function Footer(){
        
        $this->SetY(-22.5);
        
        $this->SetFont('Arial', 'I', 8);
        
        $this->Cell(0, 10, utf8_decode('Página '.$this->PageNo()), 0, 0, 'C');
        $this->ln();    
    }
}
$pdf = new PDF('P', 'mm', 'LETTER');
$pdf->AddPage();
$pdf->SetMargins(30, 25 , 30);
$pdf->SetAutoPageBreak(true,25); 
$pdf->SetFont('Arial','',11);
$pdf->cell(0,6.5,utf8_decode("Guanare, 15 de Marzo del 2023
"),0,1,"R");
$pdf->SetFont('Arial','B',11);
$pdf->multicell(0,6.5,utf8_decode("Señores:
".$nombre."
Presente"),0,"L");
$pdf->multicell(0,6.5,utf8_decode("Atte: LCDA ".$nombre."
JEFA DE TALENTO HUMANO
"),0,"L");
$pdf->SetFont('Arial','',11);
$pdf->multicell(0,6.5,utf8_decode('
        Tengo el agrado de dirigirme a usted, en la oportunidad de presentarle a la Bachiller '.$nombre.', titular de la cédula de identidad '.$nombre.',  estudiante de la carrera '.$nombre.', la mencionada Bachiller está autorizada para realizar trámites en la Organización que usted representa, relacionados con la posibilidad de desarrollar en su práctica profesional un proyecto con un mínimo de 480 horas laborales, comprendidas desde 20 de MARZO del 2023 hasta  el 23 de JUNIO del 2023.
    Es necesario señalar que la estudiante que obtenga de usted la autorización para realizar la práctica profesional, reciba de la organización la carta de aceptación, plan de trabajo, resumen curricular del tutor institucional, los recursos y el asesoramiento requerido para el cumplimiento de las actividades asignadas. Así mismo, es importante destacar que la Organización se comprometa a entregar la evaluación realizada por el tutor institucional y el certificado de culminación el último día de las prácticas.
    Por otra parte, la bachiller será supervisada durante dos (2) oportunidades por un docente, debidamente autorizado por la UNEFA, Anexo a esta carta, se facilita el perfil del egresado del estudiante.
    Agradeciendo la atención sobre este particular, quedo de usted.
'),0,1);
$pdf->ln();
$pdf->multicell(0,6.5,utf8_decode("Atentamente,
    
MSC. MARBELYS DEL VALLE RIVERO
DECANA DEL NÚCLEO PORTUGUESA
Según Orden administrativa N° 0005 de fecha 18 de Marzo 2022"),0,"C");

$pdf->Output();
/*
Header para carta horizontal
function Header(){
        $this->SetY(10);
        $this->Image('../images/images.jpg',20,null,-300);
        $this->Image('../images/Nuevo_Escudo_de_la_UNEFA_(Desde_1999).jpg',240,10,15);
        $this->SetY(10);
        $this->SetFont('Arial', '', 11);
        $this->multicell(0,5,utf8_decode("REPÚBLICA BOLIVARIANA DE VENEZUELA \nMINISTERIO DEL PODER POPULAR PARA LA DEFENSA \nUNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA\nDE LA FUERZA ARMADA NACIONAL BOLIVARIANA \nVICERRECTORADO REGIÓN LOS LLANOS\n NÚCLEO PORTUGUESA EXTENSIÓN ACARIGUA
"),0,"C");
        $this->Ln();

        Header para A3 Horizontal
function Header(){
        $this->SetY(10);
        $this->Image('../images/images.jpg',20,null,-300);
        $this->Image('../images/Nuevo_Escudo_de_la_UNEFA_(Desde_1999).jpg',380,10,15);
        $this->SetY(10);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 14);
        $this->multicell(0,5,utf8_decode("REPÚBLICA BOLIVARIANA DE VENEZUELA \nUNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA\nDE LA FUERZA ARMADA NACIONAL BOLIVARIANA \nVICERRECTORADO ACADÉMICO\n COORDINACIÓN DE PLANIFICACIÓN ACADÉMICA
"),0,"C");
        $this->Ln();
*/
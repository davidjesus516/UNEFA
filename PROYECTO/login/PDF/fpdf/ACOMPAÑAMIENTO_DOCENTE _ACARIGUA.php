<?php  
require('fpdf/fpdf.php');
class PDF extends FPDF{
function Header(){
        $this->SetY(10);
        $this->Image('../images/images.jpg',20,null,-300);
        $this->Image('../images/Nuevo_Escudo_de_la_UNEFA_(Desde_1999).jpg',240,10,15);
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
$pdf = new PDF('L', 'mm', 'LETTER');
$pdf->AddPage();
$pdf->SetMargins(30, 25 , 30);
$pdf->SetAutoPageBreak(true,25); 
$pdf->SetFont('Arial','',11);
$pdf->multicell(0,10,"
ACOMPAÑAMIENTO DEL (DE LA) TUTOR(A) AL (A LA) ESTUDIANTE EN EL CENTRO DE PRÁCTICA PROFESIONAL



NOMBRES Y APELLIDOS DEL (DE LA) TUTOR(A) ACADÉMICO(A)



NOMBRES Y APELLIDOS DEL (DE LA) TUTOR(A) INSTITUCIONAL


NOMBRES Y APELLIDOS DEL (DE LA) ESTUDIANTE   

NOMBRE DE LA INSTITUCIÓN

FECHA DE LA VISITA




OBSERVACIONES: 


 


 


 


 





     
 
FIRMA TUTOR(A) ACADÉMICO(A)
 
FIRMA TUTOR(A) INSTITUCIONAL



SELLO DE LA INSTITUCIÓN
 ");
$pdf->Output();

?>
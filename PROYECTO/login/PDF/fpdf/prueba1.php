<?php
require('fpdf/fpdf.php');
class PDF extends FPDF{

    function Header(){
    	$this->SetY(10);
        $this->Image('../images/images.jpg',20,null,-300);
        $this->Image('../images/Nuevo_Escudo_de_la_UNEFA_(Desde_1999).jpg',380,10,15);
        $this->SetY(10);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->multicell(0,5,utf8_decode("REPÚBLICA BOLIVARIANA DE VENEZUELA \nUNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA\nDE LA FUERZA ARMADA NACIONAL BOLIVARIANA \nVICERRECTORADO ACADÉMICO\n COORDINACIÓN DE PLANIFICACIÓN ACADÉMICA
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
$pdf = new PDF();
$pdf->AddPage("Landscape","letter");//agrega paginas al pdf recibe de parametros(orientacion que puede ser PORTRAIT=Vertical o Landscape=Horizontal, tamaño de pagina)
$pdf->SetFont('Arial','',16);
$pdf->multicell(0,10,utf8_decode('¡Hola, Mundo!'),0,1);


$pdf->Output();


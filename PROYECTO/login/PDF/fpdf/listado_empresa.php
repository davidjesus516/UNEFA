<?php  
require('fpdf/fpdf.php');
require_once("../../meastro_empresa/model/UserModel.php");
// crear una instancia de la clase Usuario
$usuario = new Usuario();

// llamar al método listarUsuario() para que me retorne todo lo que tiene la bd
$json = $usuario->listarUsuarios();
class PDF extends FPDF{
    // 
// Tabla coloreada
function FancyTable($header, $data)
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(14,64,158);
    $this->SetTextColor(255);
    $this->SetDrawColor(14,64,158);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','B',11);;
    // Cabecera
    $w = array(25, 45, 45, 45, 40,0);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row["rif"],'LB',0,'C',$fill);
        $this->Cell($w[1],6,$row["nombre"],'LB',0,'C',$fill);
        $this->Cell($w[2],6,$row["nombre_contacto"],'LB',0,'C',$fill);
        $this->Cell($w[3],6,$row["telefono_contacto"],'LB',0,'C',$fill);
        $this->Cell($w[4],6,$row["telefono_empresa"],'LB',0,'C',$fill);
        $this->Cell($w[5],6,$row["direccion"],'LRB',0,'C',$fill);
        $this->Ln();
      $fill=!$fill;
    }
}
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

$pdf->SetAutoPageBreak(true,25); 
$pdf->SetFont('Arial','B',16);
$pdf->cell(0,10,"Listado De Empresas",0,1,"C");
$pdf->ln();
// Títulos de las columnas
$header = array("RIF", "Nombre De Empresa", "Nombre De Contacto","Telefono De Contacto","Telefono De Empresa","Direccion Empresa");
$pdf->FancyTable($header,$json);
$pdf->Output();

?>

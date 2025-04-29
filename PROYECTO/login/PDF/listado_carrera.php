<?php
require('fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        if(file_exists('img/Escudo.png')) {
            $this->Image('img/Escudo.png', 10, 6, 25, 20); // Tamaño ajustado
        }
        // Fuente del título
        $this->SetFont('Arial','B',16);
        $this->Cell(80); // Mover al centro
        $this->Cell(30,10,'Listado de Carreras',0,0,'C');
        // Fecha a la derecha
        $this->SetFont('Arial','',10);
        $this->Cell(70,10,date('d/m/Y'),0,0,'R');
        // Salto de línea
        $this->Ln(25); // Más espacio para que no quede apretado
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        // Fecha en el centro
        $this->Cell(0,10,date('d/m/Y'),0,0,'C');
        // Número de página a la derecha
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
    }
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "mydb");

// Verificar conexión
if ($conexion->connect_error) {
    generarErrorPDF('Error de conexión a la base de datos: ' . $conexion->connect_error);
    exit;
}

// Consulta SQL
$sql = "SELECT CAREER_CODE, CAREER_NAME FROM `t-career`";
$resultado = $conexion->query($sql);

// Verificar resultado
if ($resultado === false) {
    generarErrorPDF('Error en la consulta SQL: ' . $conexion->error);
    exit;
}

// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Estilo de tabla
// Cabecera
$pdf->SetFillColor(0, 102, 204); // Azul
$pdf->SetTextColor(255);         // Blanco
$pdf->SetDrawColor(0, 0, 0);     // Bordes negros
$pdf->SetLineWidth(0.3);         // Bordes finos
$pdf->SetFont('Arial','B',12);

// Ancho de columnas
$w = array(60, 120); // 60mm y 120mm

$pdf->Cell($w[0],10,'Codigo Carrera',1,0,'C',true);
$pdf->Cell($w[1],10,'Nombre Carrera',1,1,'C',true);

// Restaurar colores
$pdf->SetFillColor(224, 235, 255); // Azul claro
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',11);

$fill = false;

// Datos
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $pdf->Cell($w[0],8,utf8_decode($fila['CAREER_CODE']),'LR',0,'C',$fill);
        $pdf->Cell($w[1],8,utf8_decode($fila['CAREER_NAME']),'LR',1,'C',$fill);
        $fill = !$fill; // Alternar colores
    }
    // Línea final
    $pdf->Cell(array_sum($w),0,'','T');
} else {
    $pdf->Cell(array_sum($w),10,'No hay datos disponibles',1,1,'C');
}

$pdf->Output('I', 'Listado_Carreras.pdf');
$conexion->close();

// Función para mostrar errores en PDF
function generarErrorPDF($mensaje)
{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'Error',0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(0,10,utf8_decode($mensaje));
    $pdf->Output('I', 'Error.pdf');
}
?>

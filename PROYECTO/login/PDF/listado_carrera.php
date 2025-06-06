<?php
// Incluir librerías necesarias
require('fpdf186/fpdf.php');          // Librería FPDF para generar PDF
require('phpqrcode/qrlib.php');       // Librería para generación de códigos QR

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo institucional
        if(file_exists('img/logo_unefa.png')) {
            $this->Image('img/logo_unefa.png', 10, 6, 25); // Posición X=10mm, Y=6mm, ancho 25mm
        }
        
        // Configuración del título principal
        $this->SetFont('Arial','B',16);
        $this->Cell(80); // Margen izquierdo para centrar
        $this->Cell(30,10,'Listado de Carreras',0,0,'C');
        
        // Fecha actual alineada a la derecha
        $this->SetFont('Arial','',10);
        $this->Cell(70,10,date('d/m/Y'),0,0,'R');
        
        // Espaciado después del encabezado
        $this->Ln(25);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        
        // Fecha en el centro
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,date('d/m/Y'),0,0,'C');
        
        // Número de página a la derecha
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
        
        // Insertar QR 3 cm desde el borde inferior
        $this->SetY(-40); // Ajusta este valor para cambiar la posición vertical
        $this->QRCode('https://m.youtube.com/watch?v=a40r8AhnPm8'); // URL personalizada aquí!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    }

    // Función personalizada para generar QR
    function QRCode($url = 'https://default.com')
    {
        // 1. Crear archivo temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'qr') . '.png';
        
        // 2. Generar QR con parámetros:
        //    - Tamaño: 10 (1-10, siendo 10 el más grande)
        //    - Margen: 2 (espacio alrededor del QR)
        QRcode::png($url, $tempFile, QR_ECLEVEL_H, 10, 2);
        
        // 3. Insertar QR en PDF
        //    Posición X=10mm, Y=actual, Ancho=30mm, Alto=30mm
        $this->Image($tempFile, 10, $this->GetY(), 30, 30);
        
        // 4. Eliminar archivo temporal
        unlink($tempFile);
    }
}

// --- Conexión a Base de Datos ---
$conexion = new mysqli("localhost", "root", "", "mydb");

// Manejo de errores de conexión
if ($conexion->connect_error) {
    generarErrorPDF('Error de conexión: ' . $conexion->connect_error);
    exit;
}

// Consulta SQL para obtener carreras activas
$sql = "SELECT CAREER_CODE, CAREER_NAME FROM `t-career` WHERE STATUS = 1";
$resultado = $conexion->query($sql);

// Verificar resultados de consulta
if ($resultado === false) {
    generarErrorPDF('Error en consulta: ' . $conexion->error);
    exit;
}

// --- Generación del PDF ---
$pdf = new PDF();
$pdf->AliasNbPages(); // Habilitar número de páginas
$pdf->AddPage();      // Crear primera página

// Configurar fuente y colores para la tabla
$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(0, 102, 204);  // Azul para encabezado
$pdf->SetTextColor(255);           // Texto blanco

// Dimensiones de columnas
$ancho_columnas = [60, 120]; // [Código, Nombre]

// Encabezados de tabla
$pdf->Cell($ancho_columnas[0],10,'Codigo',1,0,'C',true);
$pdf->Cell($ancho_columnas[1],10,'Nombre',1,1,'C',true);

// Restaurar colores para filas
$pdf->SetFillColor(224, 235, 255); // Azul claro
$pdf->SetTextColor(0);              // Texto negro
$pdf->SetFont('Arial','',11);

// Llenar tabla con datos
if ($resultado->num_rows > 0) {
    $alternarColor = false;
    while($fila = $resultado->fetch_assoc()) {
        $pdf->Cell($ancho_columnas[0],8,utf8_decode($fila['CAREER_CODE']),'LR',0,'C',$alternarColor);
        $pdf->Cell($ancho_columnas[1],8,utf8_decode($fila['CAREER_NAME']),'LR',1,'C',$alternarColor);
        $alternarColor = !$alternarColor; // Alternar colores
    }
    // Línea de cierre de tabla
    $pdf->Cell(array_sum($ancho_columnas),0,'','T');
} else {
    $pdf->Cell(array_sum($ancho_columnas),10,'No hay datos disponibles',1,1,'C');
}

// Salida final del PDF
$pdf->Output('I', 'Listado_Carreras.pdf');
$conexion->close();

// --- Función para errores ---
function generarErrorPDF($mensaje)
{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'Error',0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(0,10,utf8_decode($mensaje));
    $pdf->Output('I', 'Error.pdf');
    exit;
}
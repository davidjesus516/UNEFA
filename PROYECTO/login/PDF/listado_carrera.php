<?php
// Incluir librerías necesarias
require('fpdf186/fpdf.php');          // Librería FPDF para generar PDF
require('phpqrcode/qrlib.php');       // Librería para generación de códigos QR

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo institucional (escudo)
        if(file_exists('img/escudo.png')) {
            $this->Image('img/escudo.png', 10, 20, 25); // Posición X=10mm, Y=4mm, ancho 20mm
        }

        // Logo adicional (logo-nuevo) a la derecha
        if(file_exists('img/logo-nuevo.png')) {
            $this->Image('img/logo-nuevo.png', 180, 20, 18); // Posición X=170mm, Y=4mm, ancho 20mm
        }

        // Configuración del título principal
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(5); // Espaciado inicial
        $this->MultiCell(0, 6, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',
            "REPÚBLICA BOLIVARIANA DE VENEZUELA\n" .
            "MINISTERIO DEL PODER POPULAR PARA LA DEFENSA\n" .
            "UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA\n" .
            "DE LA FUERZA ARMADA NACIONAL BOLIVARIANA\n" .
            "VICERRECTORADO REGIÓN LOS LLANOS\n" .
            "NÚCLEO PORTUGUESA - EXTENSIÓN ACARIGUA"
        ), 0, 'C');

        // Generar y colocar el QR a la derecha, debajo del título
        $this->QRCode(' ', 177, $this->GetY() + 5); //aqui va el link del QR

        // Espaciado después del QR
        $this->Ln(35);

        // Nombre del reporte
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('Listado de Carreras'), 0, 1, 'C');

        // Espaciado después del nombre del reporte
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);

        // Fecha en el centro
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, date('d/m/Y'), 0, 0, 'C');

        // Número de página a la derecha
        $this->Cell(0, 10, ' ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    // Función personalizada para generar QR
    function QRCode($url = 'https://default.com', $x = 10, $y = 10)
    {
        // 1. Crear archivo temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'qr') . '.png';

        // 2. Generar QR con parámetros:
        //    - Tamaño: 10 (1-10, siendo 10 el más grande)
        //    - Margen: 2 (espacio alrededor del QR)
        QRcode::png($url, $tempFile, QR_ECLEVEL_H, 10, 2);

        // 3. Insertar QR en PDF
        $this->Image($tempFile, $x, $y, 23, 23);

        // 4. Eliminar archivo temporal
        unlink($tempFile);
    }
}

// --- Conexión a Base de Datos ---
$conexion = new mysqli("localhost", "root", "", "mydb2");

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
$pdf->Cell($ancho_columnas[0],10,'CODIGO',1,0,'C',true);
$pdf->Cell($ancho_columnas[1],10,'NOMBRE',1,1,'C',true);

// Restaurar colores para filas
$pdf->SetFillColor(224, 235, 255); // Azul claro
$pdf->SetTextColor(0);              // Texto negro
$pdf->SetFont('Arial','',11);

// Llenar tabla con datos
if ($resultado->num_rows > 0) {
    $alternarColor = false;
    while($fila = $resultado->fetch_assoc()) {
        $pdf->Cell($ancho_columnas[0], 8, mb_convert_encoding($fila['CAREER_CODE'], 'ISO-8859-1', 'UTF-8'), 'LR', 0, 'C', $alternarColor);
        $pdf->Cell($ancho_columnas[1], 8, mb_convert_encoding($fila['CAREER_NAME'], 'ISO-8859-1', 'UTF-8'), 'LR', 1, 'C', $alternarColor);
        $alternarColor = !$alternarColor; // Alternar colores
    }
    // Línea de cierre de tabla
    $pdf->Cell(array_sum($ancho_columnas), 0, '', 'T');
} else {
    $pdf->Cell(array_sum($ancho_columnas), 10, mb_convert_encoding('No hay datos disponibles', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');
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
    $pdf->MultiCell(0,10,mb_convert_encoding($mensaje, 'ISO-8859-1', 'UTF-8'));
    $pdf->Output('I', 'Error.pdf');
    exit;
}
?>
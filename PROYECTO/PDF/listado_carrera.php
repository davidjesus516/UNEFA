<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

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

// --- Generación del HTML para el PDF ---
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            height: 150px;
        }
        .escudo {
            position: absolute;
            left: 10px;
            top: 20px;
            width: 25mm;
        }
        .logo-nuevo {
            position: absolute;
            right: 10px;
            top: 20px;
            width: 18mm;
        }
        .qr-code {
            position: absolute;
            right: 10px;
            top: 90px;
            width: 23mm;
            height: 23mm;
        }
        .titulo-principal {
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.5;
            margin-top: 20px;
        }
        .titulo-reporte {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #0066cc;
            color: white;
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
        }
        td {
            padding: 8px;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            text-align: center;
        }
        .fila-par {
            background-color: #e0ebff;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Logos institucionales -->
        '.(file_exists('img/escudo.png') ? '<img class="escudo" src="img/escudo.png">' : '').'
        '.(file_exists('img/logo-nuevo.png') ? '<img class="logo-nuevo" src="img/logo-nuevo.png">' : '').'
        
        <!-- Título principal -->
        <div class="titulo-principal">
            REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
            MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>
            UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA<br>
            DE LA FUERZA ARMADA NACIONAL BOLIVARIANA<br>
            VICERRECTORADO REGIÓN LOS LLANOS<br>
            NÚCLEO PORTUGUESA - EXTENSIÓN ACARIGUA
        </div>
        
        <!-- Código QR -->';

// Generar código QR con Endroid
$qrCode = new QrCode('https://default.com');
$qrCode->setSize(300);
$qrCode->setMargin(10);
$qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

$writer = new PngWriter();
$result = $writer->write($qrCode);
$qrImage = base64_encode($result->getString());

$html .= '<div class="qr-code"><img src="data:image/png;base64,'.$qrImage.'" width="23" height="23"></div>
    </div>
    
    <!-- Título del reporte -->
    <div class="titulo-reporte">Listado de Carreras</div>
    
    <!-- Tabla de datos -->
    <table>
        <thead>
            <tr>
                <th style="width: 60mm;">CODIGO</th>
                <th style="width: 120mm;">NOMBRE</th>
            </tr>
        </thead>
        <tbody>';

// Llenar tabla con datos
if ($resultado->num_rows > 0) {
    $alternarColor = false;
    while($fila = $resultado->fetch_assoc()) {
        $claseFila = $alternarColor ? 'class="fila-par"' : '';
        $html .= '
            <tr '.$claseFila.'>
                <td>'.htmlspecialchars($fila['CAREER_CODE']).'</td>
                <td>'.htmlspecialchars($fila['CAREER_NAME']).'</td>
            </tr>';
        $alternarColor = !$alternarColor;
    }
} else {
    $html .= '
            <tr>
                <td colspan="2">No hay datos disponibles</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>
    
    <!-- Pie de página -->
    <div class="footer">'.date('d/m/Y').'</div>
</body>
</html>';

// --- Generación del PDF ---
$dompdf = new Dompdf();

// Configuraciones importantes
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->set_option('defaultFont', 'Arial');
$dompdf->set_option('isHtml5ParserEnabled', true);

// Cargar el HTML
$dompdf->loadHtml($html, 'UTF-8');

// Configurar papel y orientación
$dompdf->setPaper('A4', 'portrait');

// Renderizar PDF
$dompdf->render();

// Numeración de páginas (Página X de Y)
$canvas = $dompdf->getCanvas();
$font = "helvetica";
$size = 8;
$pageCount = $canvas->get_page_count();
for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
    $canvas->page_script('
        if ($PAGE_NUM == '.$pageNumber.') {
            $currentPage = "'.$pageNumber.'";
            $totalPages = "'.$pageCount.'";
            $text = "Página " . $currentPage . " de " . $totalPages;
            $font = $fontMetrics->getFont("'.$font.'", "normal");
            $size = '.$size.';
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $x = $pdf->get_width() - $width - 20;
            $y = $pdf->get_height() - 18;
            $pdf->text($x, $y, $text, $font, $size);
        }
    ');
}

// Salida final del PDF
$dompdf->stream('Listado_Carreras.pdf', ['Attachment' => false]);
$conexion->close();

// --- Función para errores ---
function generarErrorPDF($mensaje) {
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial; }
            h1 { text-align: center; font-size: 16pt; font-weight: bold; }
            p { font-size: 12pt; margin: 20px; }
        </style>
    </head>
    <body>
        <h1>Error</h1>
        <p>'.htmlspecialchars($mensaje).'</p>
    </body>
    </html>';
    
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream('Error.pdf', ['Attachment' => false]);
    exit;
}
?>
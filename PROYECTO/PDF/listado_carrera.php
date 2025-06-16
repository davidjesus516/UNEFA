<?php
// ===============================
//  REPORTE DE LISTADO DE CARRERAS
//  Estructura modular y comentada
// ===============================

require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

// --- CONEXIÓN A BASE DE DATOS ---
$conexion = new mysqli("localhost", "root", "", "mydb2");
if ($conexion->connect_error) {
    generarErrorPDF('Error de conexión: ' . $conexion->connect_error);
    exit;
}

// --- CONSULTA DE DATOS ---
$sql = "SELECT CAREER_CODE, CAREER_NAME FROM `t-career` WHERE STATUS = 1";
$resultado = $conexion->query($sql);
if ($resultado === false) {
    generarErrorPDF('Error en consulta: ' . $conexion->error);
    exit;
}

// --- GENERACIÓN DEL QR ---
$qrContent = 'https://www.unefa.edu.ve';
$qrCode = new QrCode($qrContent);
$qrCode->setSize(400); // Tamaño del QR
$qrCode->setMargin(0);
$qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh());
$writer = new SvgWriter();
$result = $writer->write($qrCode);
$qrImage = 'data:image/svg+xml;base64,' . base64_encode($result->getString());

// --- INICIO DEL HTML ---
$html = '<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
$html .= '<style>
    /* ====== ESTILOS GENERALES ====== */
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    .header { text-align: center; margin-bottom: 30px; position: relative; height: 150px; }
    /* Imágenes institucionales */
    .escudo { position: absolute; left: 10px; top: 20px; width: 25mm; }
    .logo-nuevo { position: absolute; right: 10px; top: 20px; width: 18mm; }
    /* Títulos */
    .titulo-principal { font-size: 12pt; font-weight: bold; line-height: 1.5; margin-top: 20px; }
    .titulo-reporte { font-size: 14pt; font-weight: bold; text-align: center; margin: 20px 0; }
    /* Tabla de datos */
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th { background-color: #0066cc; color: white; padding: 10px; text-align: center; border: 1px solid #000; }
    td { padding: 8px; border-left: 1px solid #000; border-right: 1px solid #000; text-align: center; }
    .fila-par { background-color: #e0ebff; }
    /* QR fijo en la esquina inferior izquierda */
    .qr-code { position: fixed; left: 10px; bottom: 0; width: 60mm; height: 35mm; z-index: 1000; }
    /* Pie de página */
    .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; font-style: italic; padding-bottom: 10px; }
</style>';
$html .= '</head><body>';

// --- HEADER CON IMÁGENES Y TÍTULOS ---
$html .= '<div class="header">';
$html .= '<table width="100%" style="margin-bottom:10px; border:none;">
<tr>
    <td style="width:80px; text-align:left; vertical-align:middle; border:none;">
        <img src="../img/Escudo.png" alt="Escudo" style="height:60px;">
    </td>
    <td style="text-align:center; border:none;">
        <div class="titulo-principal" style="font-size:10pt; line-height:1.2;">REPÚBLICA BOLIVARIANA DE VENEZUELA<br>MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA<br>DE LA FUERZA ARMADA NACIONAL BOLIVARIANA<br>VICERRECTORADO REGIÓN LOS LLANOS<br>NÚCLEO PORTUGUESA - EXTENSIÓN ACARIGUA</div>
    </td>
    <td style="width:80px; text-align:right; vertical-align:middle; border:none;">
        <img src="../img/logo-nuevo.png" alt="Logo" style="height:50px;">
    </td>
</tr>
</table>';
$html .= '</div>';

// --- TÍTULO DEL REPORTE ---
$html .= '<div class="titulo-reporte">Listado de Carreras</div>';

// --- TABLA DE DATOS ---
$html .= '<table><thead><tr><th style="width: 60mm;">CODIGO</th><th style="width: 120mm;">NOMBRE</th></tr></thead><tbody>';
if ($resultado->num_rows > 0) {
    $alternarColor = false;
    $rows = [];
    while ($fila = $resultado->fetch_assoc()) {
        $claseFila = $alternarColor ? 'class="fila-par"' : '';
        $rows[] = '<tr ' . $claseFila . '><td>' . htmlspecialchars($fila['CAREER_CODE']) . '</td><td>' . htmlspecialchars($fila['CAREER_NAME']) . '</td></tr>';
        $alternarColor = !$alternarColor;
    }
    // Agregar borde inferior a la última fila
    if (count($rows) > 0) {
        $lastRow = array_pop($rows);
        // Insertar estilo de borde inferior en los <td> de la última fila
        $lastRow = preg_replace('/<td>/', '<td style="border-bottom:1px solid #000;">', $lastRow);
        $lastRow = preg_replace('/<td style=/', '<td style="border-bottom:1px solid #000; ', $lastRow, 1); // Si ya tiene style
        $rows[] = $lastRow;
    }
    $html .= implode("", $rows);
} else {
    $html .= '<tr><td colspan="2">No hay datos disponibles</td></tr>';
}
$html .= '</tbody></table>';

// --- QR EN LA ESQUINA INFERIOR IZQUIERDA ---
$html .= '<div class="qr-code"><img src="' . $qrImage . '" width="110" height="110"></div>';

// --- PIE DE PÁGINA ---
$html .= '<div class="footer">' . date('d/m/Y') . '</div>';

$html .= '</body></html>';

// --- CONFIGURACIÓN Y RENDERIZADO DOMPDF ---
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(['isRemoteEnabled' => true]);
$options->set(['defaultFont' => 'Arial']);
$options->set(['isHtml5ParserEnabled' => true]);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// --- NUMERACIÓN DE PÁGINAS ---
$canvas = $dompdf->getCanvas();
$font = "helvetica";
$size = 8;
$pageCount = $canvas->get_page_count();
for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
    $canvas->page_script('
        if ($PAGE_NUM == ' . $pageNumber . ') {
            $currentPage = "' . $pageNumber . '";
            $totalPages = "' . $pageCount . '";
            $text = "Página " . $currentPage . " de " . $totalPages;
            $font = $fontMetrics->getFont("' . $font . '", "normal");
            $size = ' . $size . ';
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $x = $pdf->get_width() - $width - 20;
            $y = $pdf->get_height() - 18;
            $pdf->text($x, $y, $text, $font, $size);
        }
    ');
}

$dompdf->stream('Listado_Carreras.pdf', ['Attachment' => false]);
$conexion->close();

// --- FUNCIÓN PARA ERRORES ---
function generarErrorPDF($mensaje)
{
    $html = '<!DOCTYPE html><html><head><style>body { font-family: Arial; } h1 { text-align: center; font-size: 16pt; font-weight: bold; } p { font-size: 12pt; margin: 20px; }</style></head><body><h1>Error</h1><p>' . htmlspecialchars($mensaje) . '</p></body></html>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream('Error.pdf', ['Attachment' => false]);
    exit;
}

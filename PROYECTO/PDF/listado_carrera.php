<?php

require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

// --- Función para convertir imágenes a base64 ---
/**
 * Convierte una imagen a una cadena base64 para su uso en HTML.
 * @param string $path Ruta de la imagen.
 * @return string Cadena base64 de la imagen o cadena vacía si no existe.
 */
function imageToBase64($path)
{
    if (!file_exists($path)) {
        return ''; // Evita error si la imagen no existe
    }
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

try {
    // Conexión a la base de datos
    // Establece la conexión con la base de datos MySQL
    $conexion = new mysqli("localhost", "root", "", "mydb2");
    if ($conexion->connect_error) {
        throw new Exception('Error de conexión: ' . $conexion->connect_error);
    }

    // Consulta de datos
    // Realiza la consulta para obtener las carreras activas
    $sql = "SELECT CAREER_CODE, CAREER_NAME FROM `t-career` WHERE STATUS = 1";
    $resultado = $conexion->query($sql);
    if ($resultado === false) {
        throw new Exception('Error en consulta: ' . $conexion->error);
    }

    // Obtiene los resultados en un array asociativo
    $carreras = $resultado->fetch_all(MYSQLI_ASSOC);

    // Generar código QR
    // Crea un código QR para la URL de la UNEFA
    $qr = new QrCode('https://www.unefa.edu.ve');
    $qr->setSize(400)->setMargin(0)->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh());
    $writer = new SvgWriter();
    $qrImage = 'data:image/svg+xml;base64,' . base64_encode($writer->write($qr)->getString());

    // Embeder imágenes como base64
    // Convierte las imágenes del escudo y logo a base64
    $escudoBase64 = imageToBase64(__DIR__ . '/../img/Escudo.png');
    $logoBase64 = imageToBase64(__DIR__ . '/../img/logo-nuevo.png');

    // Generar HTML
    // Inicia el almacenamiento en buffer de salida para el HTML
    ob_start();
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 30px; position: relative; height: 150px; }
        .titulo-principal { font-size: 12pt; font-weight: bold; line-height: 1.2; }
        .titulo-reporte { font-size: 14pt; font-weight: bold; text-align: center; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #000; }
        th { background-color: #0066cc; color: white; padding: 5px; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-top: none; border-bottom: none; }
        td { padding: 8px; border-left: 1px solid #000; border-right: 1px solid #000; border-top: none; border-bottom: none; text-align: center; }
        .fila-par { background-color: #e0ebff; }
        .qr-code { position: fixed; left: 10px; bottom: 0; width: 60mm; height: 15mm; z-index: 1000; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; font-style: italic;}
    </style>
</head>
<body>

<div class="header">
    <table width="100%" style="border:none;">
        <tr>
            <td style="width:80px; text-align:left; border:none; ">
                <img src="<?= $escudoBase64 ?>" style="height:110px; left:0;">
            </td>
            <td style="text-align:center; border:none; min-width: 500px;">
                <div class="titulo-principal">
                    REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                    MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>
                    UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA<br>
                    DE LA FUERZA ARMADA NACIONAL BOLIVARIANA<br>
                    VICERRECTORADO REGIÓN LOS LLANOS<br>
                    NÚCLEO PORTUGUESA - EXTENSIÓN ACARIGUA
                    <br>
                </div>
            </td>
            <td style="width:80px; text-align:right; border:none;">
                <img src="<?= $logoBase64 ?>" style="height:120px;">
            </td>
        </tr>
    </table>
</div>

<div class="titulo-reporte"><br>Listado de Carreras</div>

<table>
    <thead>
        <tr>
            <th style="width: 60mm;">CÓDIGO</th>
            <th style="width: 120mm;">NOMBRE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($carreras)) {
            $alternar = false;
            foreach ($carreras as $fila) {
                $clase = $alternar ? ' class="fila-par"' : '';
                echo "<tr$clase><td>" . htmlspecialchars($fila['CAREER_CODE']) . "</td><td>" . htmlspecialchars($fila['CAREER_NAME']) . "</td></tr>";
                $alternar = !$alternar;
            }
        } else {
            echo '<tr><td colspan="2">No hay datos disponibles</td></tr>';
        }
        ?>
    </tbody>
</table>

<div class="qr-code">
    <img src="<?= $qrImage ?>" width="80" height="80">
</div>

<div class="footer" style="bottom: 0;"><?= date('d/m/Y') ?></div>

</body>
</html>
<?php
    $html = ob_get_clean();

    // Renderizar PDF
    // Configura y renderiza el PDF usando Dompdf
    $options = new Options();
    $options->setIsRemoteEnabled(true)->setDefaultFont('Arial')->setIsHtml5ParserEnabled(true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Número de páginas
    // Agrega numeración de páginas al PDF
    $canvas = $dompdf->getCanvas();
    $font = 'helvetica';
    $size = 8;
    $totalPages = $canvas->get_page_count();

    for ($page = 1; $page <= $totalPages; $page++) {
        $canvas->page_script('
            if ($PAGE_NUM == ' . $page . ') {
                $text = "Página ' . $page . ' de ' . $totalPages . '";
                $font = $fontMetrics->getFont("' . $font . '", "normal");
                $width = $fontMetrics->getTextWidth($text, $font, ' . $size . ');
                $pdf->text($pdf->get_width() - $width - 20, $pdf->get_height() - 18, $text, $font, ' . $size . ');
            }
        ');
    }

    $dompdf->stream('Listado_Carreras.pdf', ['Attachment' => false]);
    $conexion->close();

} catch (Exception $e) {
    // PDF de error
    // Si ocurre una excepción, genera un PDF mostrando el mensaje de error
    $html = '<!DOCTYPE html><html><head><style>body { font-family: Arial; } h1 { text-align: center; font-size: 16pt; font-weight: bold; } p { font-size: 12pt; margin: 20px; }</style></head><body><h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p></body></html>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream('Error.pdf', ['Attachment' => false]);
}

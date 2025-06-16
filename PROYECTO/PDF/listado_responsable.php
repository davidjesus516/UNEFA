<?php

require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
// Se requiere el archivo de conexión a la base de datos
require_once __DIR__ . '/../login/model/conexion.php';

function imageToBase64($path)
{
    if (!file_exists($path)) {
        return '';
    }
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

try {
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "mydb2");
    if ($conexion->connect_error) {
        throw new Exception('Error de conexión: ' . $conexion->connect_error);
    }

    // Consulta SQL para obtener los datos de los responsables institucionales
    $sql = "SELECT 
                im.MANAGER_ID,
                im.MANAGER_CI,
                im.NAME AS MANAGER_NAME,
                im.SECOND_NAME AS MANAGER_SECOND_NAME,
                im.SURNAME AS MANAGER_SURNAME,
                im.SECOND_SURNAME AS MANAGER_SECOND_SURNAME,
                im.CONTACT_PHONE,
                im.EMAIL,
                i.INSTITUTION_NAME
            FROM `t-institution_manager` im
            LEFT JOIN `t-institution` i ON im.INSTITUTION_ID = i.INSTITUTION_ID
            WHERE 1";
    $resultado = $conexion->query($sql);
    if ($resultado === false) {
        throw new Exception('Error en consulta: ' . $conexion->error);
    }

    // Obtener resultados
    $responsables = $resultado->fetch_all(MYSQLI_ASSOC);

    $qr = new QrCode('https://www.unefa.edu.ve');
    $qr->setSize(400)->setMargin(0)->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh());
    $writer = new SvgWriter();
    $qrImage = 'data:image/svg+xml;base64,' . base64_encode($writer->write($qr)->getString());

    $escudoBase64 = imageToBase64(__DIR__ . '/../img/Escudo.png');
    $logoBase64 = imageToBase64(__DIR__ . '/../img/logo-nuevo.png');

    ob_start();
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 5mm 5mm; }
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; max-width: 100%; }
        .container { width: 100%; margin: 0 auto; padding: 0 15px; box-sizing: border-box; }
        .header { text-align: center; margin-bottom: 10px; position: relative; height: 150px; }
        .titulo-principal { font-size: 11pt; font-weight: bold; line-height: 1.2; width: 100% }
        .titulo-reporte { font-size: 14pt; font-weight: bold; text-align: center; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px auto; border: 1px solid #000; font-size: 9px; }
        th { background-color: #0066cc; color: white; padding: 8px; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-top: none; border-bottom: none; font-size: 11px;}
        td { padding: 7px; border-left: 1px solid #000; border-right: 1px solid #000; border-top: none; border-bottom: none; text-align: center; font-size: 10px; word-wrap: break-word; }
        td:last-child { word-break: break-all; max-width: 30mm; }
        .fila-par { background-color: #e0ebff; }
        .qr-code { position: fixed; left: 10px; bottom: 0; width: 60mm; height: 25mm; z-index: 1000; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; font-style: italic;}
    </style>
</head>
<body>

<div class="container">
    <div class="header">
    <table width="100%" style="border:none;">
        <tr>
            <td style="width:30px; text-align:left; border:none; padding-right: 20px;">
                <img src="<?= $escudoBase64 ?>" style="height:110px;">
            </td>
            <td style="text-align:center; border:none;">
                <div class="titulo-principal">
                    REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                    MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>
                    UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA<br>
                    DE LA FUERZA ARMADA NACIONAL BOLIVARIANA<br>
                    VICERRECTORADO REGIÓN LOS LLANOS<br>
                    NÚCLEO PORTUGUESA - EXTENSIÓN ACARIGUA
                </div>
            </td>
            <td style="width:50px; text-align:right; border:none; padding-left: 20px; padding-right: 30px;">
                <img src="<?= $logoBase64 ?>" style="height:120px;">
            </td>
        </tr>
    </table>
</div>

<div class="titulo-reporte">Listado de Responsables Institucionales</div>

<table style="transform: translateX(-10);">
    <thead>
        <tr>
            <th style="width: 15mm;">CÉDULA</th>
            <th style="width: 25mm;">NOMBRES</th>
            <th style="width: 25mm;">APELLIDOS</th>
            <th style="width: 25mm;">TELÉFONO</th>
            <th style="width: 35mm;">CORREO ELECTRÓNICO</th>
            <th style="width: 40mm;">INSTITUCIÓN</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($responsables)) {
            $alternar = false;
            foreach ($responsables as $responsable) {
                $clase = $alternar ? ' class="fila-par"' : '';
                echo "<tr$clase>";
                echo "<td>" . htmlspecialchars($responsable['MANAGER_CI']) . "</td>";
                echo "<td>" . htmlspecialchars($responsable['MANAGER_NAME'] . ' ' . $responsable['MANAGER_SECOND_NAME']) . "</td>";
                echo "<td>" . htmlspecialchars($responsable['MANAGER_SURNAME'] . ' ' . $responsable['MANAGER_SECOND_SURNAME']) . "</td>";
                echo "<td>" . htmlspecialchars($responsable['CONTACT_PHONE']) . "</td>";
                echo "<td>" . htmlspecialchars($responsable['EMAIL']) . "</td>";
                echo "<td>" . htmlspecialchars($responsable['INSTITUTION_NAME']) . "</td>";
                echo "</tr>";
                $alternar = !$alternar;
            }
        } else {
            echo '<tr><td colspan="6">No hay datos disponibles</td></tr>';
        }
        ?>
    </tbody>
</table>

<div class="qr-code">
    <img src="<?= $qrImage ?>" width="85" height="85">
</div>

<div class="footer" style="bottom: 0;">
    <?= date('d/m/Y') ?>
</div>
</div>
</body>
</html>
<?php
    $html = ob_get_clean();

    $options = new Options();
    $options->setIsRemoteEnabled(true)->setDefaultFont('Arial');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

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

    $dompdf->stream('Listado_Responsables.pdf', ['Attachment' => false]);

    $conexion->close();

} catch (Exception $e) {
    // PDF de error
    $html = '<!DOCTYPE html><html><head><style>body { font-family: Arial; } h1 { text-align: center; font-size: 16pt; font-weight: bold; } p { font-size: 12pt; margin: 20px; }</style></head><body><h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p></body></html>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream('Error.pdf', ['Attachment' => false]);
}
<?php

require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

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
    $conexion = new mysqli("localhost", "root", "", "mydb2");
    if ($conexion->connect_error) {
        throw new Exception('Error de conexión: ' . $conexion->connect_error);
    }

    // Consulta SQL para obtener carreras activas y cantidad de estudiantes
    $sql = "SELECT c.CAREER_CODE, c.CAREER_NAME, COUNT(s.STUDENTS_ID) AS ESTUDIANTES_REGISTRADOS
            FROM `t-career` c
            LEFT JOIN `t-students` s ON c.CAREER_ID = s.CAREER_ID AND s.STATUS = 1
            WHERE c.STATUS = 1
            GROUP BY c.CAREER_ID, c.CAREER_CODE, c.CAREER_NAME";
    $resultado = $conexion->query($sql);
    if ($resultado === false) {
        throw new Exception('Error en consulta: ' . $conexion->error);
    }

    $carreras = $resultado->fetch_all(MYSQLI_ASSOC);

    // Generar código QR
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
        /* New styles for QR code and title positioning */
        .report-title-area {
            width: 100%;
            margin-top: 20px; /* More space above */
            margin-bottom: 20px; /* More space below */
        }
        .report-title-layout {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .report-title-layout td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }
        .report-title-left-spacer { width: 33%; }
        .report-title-center { text-align: center; width: auto; }
        .report-title-right-qr { text-align: right; width: 35%; }
        .titulo-reporte { margin: 0; } /* Remove existing margin, handled by .report-title-area */
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

<div class="report-title-area">
    <table class="report-title-layout">
        <tr>
            <td class="report-title-left-spacer"></td>
            <td class="report-title-center">
                <div class="titulo-reporte">Listado de Carreras</div>
            </td>
            <td class="report-title-right-qr">
                <img src="<?= $qrImage ?>" width="85" height="85" style="transform: translateX(-15px);">
            </td>
        </tr>
    </table>
</div>


<table style="transform: translateX(-10);">
    <thead>
        <tr>
            <th style="width: 20mm;">CÓDIGO</th>
            <th style="width: 120mm;">NOMBRE</th>
            <th style="width: 20mm;">ESTUDIANTES REGISTRADOS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($carreras)) {
            $alternar = false;
            foreach ($carreras as $carrera) {
                $clase = $alternar ? ' class="fila-par"' : '';
                echo "<tr$clase>";
                echo "<td>" . htmlspecialchars($carrera['CAREER_CODE']) . "</td>";
                echo "<td>" . htmlspecialchars($carrera['CAREER_NAME']) . "</td>";
                echo "<td>" . htmlspecialchars($carrera['ESTUDIANTES_REGISTRADOS']) . "</td>";
                echo "</tr>";
                $alternar = !$alternar;
            }
        } else {
            echo '<tr><td colspan="3">No hay datos disponibles</td></tr>';
        }
        ?>
    </tbody>
</table>

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

    $dompdf->stream('Listado_Carreras.pdf', ['Attachment' => false]);
    $conexion->close();

} catch (Exception $e) {
    $html = '<!DOCTYPE html><html><head><style>body { font-family: Arial; } h1 { text-align: center; font-size: 16pt; font-weight: bold; } p { font-size: 12pt; margin: 20px; }</style></head><body><h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p></body></html>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream('Error.pdf', ['Attachment' => false]);
}

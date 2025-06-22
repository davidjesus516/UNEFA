<?php

require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

function imageToBase64($path) {
    if (!file_exists($path)) return '';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

try {
    $conexion = new mysqli("localhost", "root", "", "mydb2");
    if ($conexion->connect_error) throw new Exception('Error de conexión: ' . $conexion->connect_error);

    $sql = "SELECT `PERIOD_ID`, `START_DATE`, `END_DATE`, `DESCRIPTION`, `PERIOD_STATUS`
            FROM `t-internships_period` ORDER BY START_DATE DESC";
    $resultado = $conexion->query($sql);
    if ($resultado === false) throw new Exception('Error en consulta: ' . $conexion->error);

    $periodos = $resultado->fetch_all(MYSQLI_ASSOC);

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
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 10px; }
        .titulo-principal { font-size: 11pt; font-weight: bold; line-height: 1.2; }
        .titulo-reporte { font-size: 14pt; font-weight: bold; text-align: center; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px auto; border: 1px solid #000; font-size: 9pt; }
        th { background-color: #0066cc; color: white; padding: 5px; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000; border-top: none; border-bottom: none; font-size: 13px;}
        td { padding: 8px; border-left: 1px solid #000; border-right: 1px solid #000; border-top: none; border-bottom: none; text-align: center; font-size: 12px; }
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
        .report-title-left-spacer { width: 33%; } /* Keeping this as is from previous diff for balance */
        .report-title-center { text-align: center; width: 100%; } /* User requested: width auto for centering */
        .report-title-right-qr { text-align: right; width: 30%; } /* User requested: width 10%, aligned right */
        .titulo-reporte { margin: 0; } /* Remove existing margin, handled by .report-title-area */
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; font-style: italic; }
    </style>
</head>
<body>

<div class="header">
    <table width="100%" style="border:none;">
        <tr>
            <td style="width:30px; text-align:left; border:none;">
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
            <td style="width:30px; text-align:right; border:none;">
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
                <div class="titulo-reporte">Listado de Períodos</div>
            </td>
            <td class="report-title-right-qr">
                <img src="<?= $qrImage ?>" width="85" height="85">
            </td>
        </tr>
    </table>
</div>


<table>
    <thead>
        <tr>
            <th style="width: 30mm;">DESCRIPCIÓN</th>
            <th style="width: 30mm;">FECHA DE INICIO</th>
            <th style="width: 30mm;">FECHA DE CULMINACIÓN</th>
            <th style="width: 30mm;">STATUS</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($periodos)) {
        $alternar = false;
        foreach ($periodos as $p) {
            $clase = $alternar ? ' class="fila-par"' : '';
            $estatus = ($p['PERIOD_STATUS'] == 1) ? 'PENDIENTE' : (($p['PERIOD_STATUS'] == 2) ? 'EN CURSO' : 'CULMINADO');
            echo "<tr$clase>";
            echo "<td>" . htmlspecialchars($p['DESCRIPTION']) . "</td>";
            echo "<td>" . date("d/m/Y", strtotime($p['START_DATE'])) . "</td>";
            echo "<td>" . date("d/m/Y", strtotime($p['END_DATE'])) . "</td>";
            echo "<td>" . $estatus . "</td>";
            echo "</tr>";
            $alternar = !$alternar;
        }
    } else {
        echo '<tr><td colspan="4">No hay períodos registrados</td></tr>';
    }
    ?>
    </tbody>
</table>

<div class="footer"><?= date('d/m/Y') ?></div>

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

    // Paginación
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

    $dompdf->stream('Listado_Periodos.pdf', ['Attachment' => false]);
    $conexion->close();

} catch (Exception $e) {
    $html = '<html><body><h1>Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p></body></html>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream('Error.pdf', ['Attachment' => false]);
}

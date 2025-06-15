<?php
require('fpdf186/fpdf.php');
require('phpqrcode/qrlib.php');
require_once('../model/periodo.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        if (file_exists('img/escudo.png')) {
            $this->Image('img/escudo.png', 10, 20, 25);
        }
        if (file_exists('img/logo-nuevo.png')) {
            $this->Image('img/logo-nuevo.png', 180, 20, 18);
        }
        $this->SetFont('Arial', 'B', 12);
        $this->Ln(5);
        $this->MultiCell(0, 6, mb_convert_encoding(
            "REPÚBLICA BOLIVARIANA DE VENEZUELA\n" .
            "MINISTERIO DEL PODER POPULAR PARA LA DEFENSA\n" .
            "UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA\n" .
            "DE LA FUERZA ARMADA NACIONAL BOLIVARIANA\n" .
            "VICERRECTORADO REGIÓN LOS LLANOS\n" .
            "NÚCLEO PORTUGUESA - EXTENSIÓN ACARIGUA",
            'ISO-8859-1', 'UTF-8'
        ), 0, 'C');
        // QR
        $this->QRCode('https://example.com', 177, $this->GetY() + 5);
        $this->Ln(35);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 12, mb_convert_encoding('Listado de Períodos Académicos', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, date('d/m/Y'), 0, 0, 'C');
        $this->Cell(0, 10, ' ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    // QR
    function QRCode($url = 'https://default.com', $x = 10, $y = 10)
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'qr') . '.png';
        QRcode::png($url, $tempFile, QR_ECLEVEL_H, 10, 2);
        $this->Image($tempFile, $x, $y, 23, 23);
        unlink($tempFile);
    }

    // Calcular número de líneas para cada celda
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}

// --- Obtener datos dinámicos ---
$periodoModel = new Periodo();
$periodos = $periodoModel->listar();

// --- Configuración de la tabla ---
$pdf = new PDF();
$pdf->SetLeftMargin(10);
// Aumenta el ancho de las columnas
$ancho_columnas = [50, 45, 45, 45]; // Lapso, Inicio, Fin, Estatus
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);


// Encabezado de tabla
$pdf->SetFillColor(0, 102, 204);
$pdf->SetTextColor(255);
$pdf->SetFont('Arial', 'B', 11);

$headers = [
    "LAPSO ACADÉMICO",
    "FECHA INICIO",
    "FECHA FIN",
    "ESTATUS"
];

// Calcular el número de líneas de cada encabezado
$line_counts = [];
for ($i = 0; $i < count($headers); $i++) {
    $line_counts[$i] = $pdf->NbLines($ancho_columnas[$i], $headers[$i]);
}
$max_lines = max($line_counts);

// Normalizar los encabezados para que todos tengan el mismo número de líneas
for ($i = 0; $i < count($headers); $i++) {
    $faltan = $max_lines - $line_counts[$i];
    if ($faltan > 0) {
        $headers[$i] .= str_repeat("\n", $faltan);
    }
}

// Altura de cada línea del encabezado
$line_height = 10;
$altura_encabezado = $line_height * $max_lines;

// Guardar posición inicial
$x = $pdf->GetX();
$y = $pdf->GetY();

for ($i = 0; $i < count($headers); $i++) {
    $pdf->SetXY($x, $y);
    $cell_lines = $line_counts[$i];
    $cell_height = $cell_lines * $line_height;
    $offsetY = ($altura_encabezado - $cell_height) / 2;
    $pdf->Rect($x, $y, $ancho_columnas[$i], $altura_encabezado, 'DF');
    $pdf->SetXY($x, $y + $offsetY);
    $pdf->MultiCell($ancho_columnas[$i], $line_height, mb_convert_encoding($headers[$i], 'ISO-8859-1', 'UTF-8'), 0, 'C', true);
    $x += $ancho_columnas[$i];
}
$pdf->SetXY($pdf->GetX(), $y + $altura_encabezado);

// Colores para filas
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 9);

// Función para traducir el estatus
function traducirEstatus($status) {
    switch ($status) {
        case 1: return 'PENDIENTE';
        case 2: return 'EN CURSO';
        case 3: return 'CULMINADO';
        default: return 'DESCONOCIDO';
    }
}

foreach ($periodos as $i => $periodo) {
    // Alternar color de fondo: blanco y azul claro
    if ($i % 2 == 0) {
        $pdf->SetFillColor(255, 255, 255); // Blanco
    } else {
        $pdf->SetFillColor(224, 235, 255); // Azul claro
    }
    $pdf->SetTextColor(0);

    $data = [
        mb_convert_encoding($periodo['DESCRIPTION'], 'ISO-8859-1', 'UTF-8'),
        date('d/m/Y', strtotime($periodo['START_DATE'])),
        date('d/m/Y', strtotime($periodo['END_DATE'])),
        mb_convert_encoding(traducirEstatus($periodo['PERIOD_STATUS']), 'ISO-8859-1', 'UTF-8')
    ];

    $num_lines = [];
    for ($j = 0; $j < count($data); $j++) {
        $num_lines[$j] = $pdf->NbLines($ancho_columnas[$j], $data[$j]);
    }
    $max_lines = max($num_lines);
    $altura = $line_height * $max_lines;

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    for ($j = 0; $j < count($data); $j++) {
        $pdf->SetXY($x, $y);
        $cell_lines = $num_lines[$j];
        $cell_height = $cell_lines * $line_height;
        $offsetY = ($altura - $cell_height) / 2;
        // Usar el color de fondo alternado
        $pdf->Rect($x, $y, $ancho_columnas[$j], $altura, 'DF');
        $pdf->SetXY($x, $y + $offsetY);
        $pdf->MultiCell($ancho_columnas[$j], $line_height, $data[$j], 0, 'C', false);
        $x += $ancho_columnas[$j];
    }
    $pdf->SetXY($pdf->GetX(), $y + $altura);
}

$pdf->Output('I', 'Listado_Periodos.pdf');
?>
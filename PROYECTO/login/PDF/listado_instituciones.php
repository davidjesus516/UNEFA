<?php
require('fpdf186/fpdf.php');
require('phpqrcode/qrlib.php');
require_once('../model/institucion_m.php'); // Ajusta la ruta si es necesario

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo institucional
        if (file_exists('img/escudo.png')) {
            $this->Image('img/escudo.png', 10, 20, 25);
        }

        // Logo adicional
        if (file_exists('img/logo-nuevo.png')) {
            $this->Image('img/logo-nuevo.png', 180, 20, 18);
        }

        // Título principal
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

        // Generar QR
        $this->QRCode('https://example.com', 177, $this->GetY() + 5);

        $this->Ln(35);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, mb_convert_encoding('Listado de Instituciones', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
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

    // Generar QR
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

// --- Obtener datos del modelo ---
$institucionModel = new Institucion();
$instituciones = $institucionModel->listarActivas();

// --- Configuración de la tabla ---
$pdf = new PDF();
// Reduce el margen izquierdo de la tabla
$pdf->SetLeftMargin(2); // Antes era 5, ahora es 2 (puedes ajustar a tu gusto)
$ancho_columnas = [20, 30, 65, 38, 30, 20]; // [Rif, Nombre, Dirección, Carrera, Tipo, Asignados]
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

// Encabezado de tabla con saltos de línea
$pdf->SetFillColor(0, 102, 204);
$pdf->SetTextColor(255);
// Cambia el tamaño de fuente a más pequeño
$pdf->SetFont('Arial', 'B', 6);

// Textos de los encabezados (puedes ajustar los saltos de línea)
$headers = [
    "RIF",
    "NOMBRE",
    "DIRECCIÓN\nFISCAL",
    "CARRERA",
    "TIPO DE\nPRÁCTICA",
    "ESTUDIANTES\nASIGNADOS"
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
        // Añadir saltos de línea al final
        $headers[$i] .= str_repeat("\n", $faltan);
    }
}

// Altura de cada línea del encabezado
$line_height = 7;
$altura_encabezado = $line_height * $max_lines;

// Guardar posición inicial
$x = $pdf->GetX();
$y = $pdf->GetY();

for ($i = 0; $i < count($headers); $i++) {
    $pdf->SetXY($x, $y);
    $startY = $pdf->GetY();
    // Calcular el alto real del texto en la celda
    $cell_lines = $line_counts[$i];
    $cell_height = $cell_lines * $line_height;
    // Centrado vertical: calcular espacio arriba
    $offsetY = ($altura_encabezado - $cell_height) / 2;
    // Dibujar el borde de la celda con fondo
    $pdf->Rect($x, $y, $ancho_columnas[$i], $altura_encabezado, 'DF');
    // Imprimir el texto centrado vertical y horizontalmente
    $pdf->SetXY($x, $y + $offsetY);
    $pdf->MultiCell($ancho_columnas[$i], $line_height, mb_convert_encoding($headers[$i], 'ISO-8859-1', 'UTF-8'), 0, 'C', true);
    $x += $ancho_columnas[$i];
}
$pdf->SetXY($pdf->GetX(), $y + $altura_encabezado);

// Colores para filas
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 8);

foreach ($instituciones as $i => $inst) {
    // Alternar color de fondo: blanco y azul claro
    if ($i % 2 == 0) {
        $pdf->SetFillColor(255, 255, 255); // Blanco
    } else {
        $pdf->SetFillColor(224, 235, 255); // Azul claro
    }
    $pdf->SetTextColor(0);

    // Datos de la institución
    $data = [
        mb_convert_encoding($inst['RIF'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($inst['INSTITUTION_NAME'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($inst['INSTITUTION_ADDRESS'], 'ISO-8859-1', 'UTF-8'),
        isset($inst['CAREER']) ? mb_convert_encoding($inst['CAREER'], 'ISO-8859-1', 'UTF-8') : '',
        mb_convert_encoding($inst['PRACTICE_TYPE'], 'ISO-8859-1', 'UTF-8'),
        isset($inst['ASIGNADOS']) ? mb_convert_encoding($inst['ASIGNADOS'], 'ISO-8859-1', 'UTF-8') : ''
    ];

    // Calcular el número de líneas necesarias para cada celda
    $num_lines = [];
    for ($j = 0; $j < count($data); $j++) {
        $num_lines[$j] = $pdf->NbLines($ancho_columnas[$j], $data[$j]);
    }
    $max_lines = max($num_lines);
    $altura = $line_height * $max_lines;

    // Guardar posición inicial de la fila
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Imprimir cada celda de la fila, alineando el texto vertical y horizontalmente
    for ($j = 0; $j < count($data); $j++) {
        $pdf->SetXY($x, $y);

        // Calcular el alto real del texto en la celda
        $cell_lines = $num_lines[$j];
        $cell_height = $cell_lines * $line_height;

        // Centrado vertical: calcular espacio arriba
        $offsetY = ($altura - $cell_height) / 2;

        // Dibujar el borde de la celda con fondo alterno
        $pdf->Rect($x, $y, $ancho_columnas[$j], $altura, 'DF');

        // Imprimir el texto centrado vertical y horizontalmente
        $pdf->SetXY($x, $y + $offsetY);
        $pdf->MultiCell($ancho_columnas[$j], $line_height, $data[$j], 0, 'C', false);

        $x += $ancho_columnas[$j];
    }
    // Mover a la siguiente fila
    $pdf->SetXY($pdf->GetX(), $y + $altura);
}

$pdf->Output('I', 'Listado_Instituciones.pdf');
?>
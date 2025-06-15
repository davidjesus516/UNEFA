<?php
// Incluir librerías necesarias
require('fpdf186/fpdf.php');
require('phpqrcode/qrlib.php');

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
        $this->Cell(0, 10, mb_convert_encoding('Listado de Estudiantes', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
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

// --- Conexión a Base de Datos ---
$conexion = new mysqli("localhost", "root", "", "mydb2");

// Manejo de errores de conexión
if ($conexion->connect_error) {
    generarErrorPDF('Error de conexión: ' . $conexion->connect_error);
    exit;
}

// Consulta SQL para obtener estudiantes activos
$sql = "SELECT s.STUDENTS_CI, s.NAME, s.SECOND_NAME, s.SURNAME, s.SECOND_SURNAME, s.GENDER, c.CAREER_NAME, s.CONTACT_PHONE, s.EMAIL 
        FROM `t-students` s
        LEFT JOIN `t-career` c ON s.CAREER_ID = c.CAREER_ID
        WHERE s.STATUS = 1";
$resultado = $conexion->query($sql);

// Verificar resultados de consulta
if ($resultado === false) {
    generarErrorPDF('Error en consulta: ' . $conexion->error);
    exit;
}

// --- Generación del PDF ---
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Configurar margen izquierdo reducido
$pdf->SetLeftMargin(5); // Reducir el margen izquierdo a 5 mm
$pdf->SetX(5); // Establecer la posición inicial en el margen izquierdo reducido
// Comentario: Aquí se ajusta el margen izquierdo para que las celdas comiencen más cerca del borde.

$pdf->SetFont('Arial', '', 7); // Reducir el tamaño de la fuente

// Dimensiones de columnas (ajustar anchos para reducir la tabla)
$ancho_columnas = [18, 30, 30, 8, 45, 23, 48]; // [Cédula, Nombres, Apellidos, Sexo, Carrera, Teléfono, Correo]
$line_height = 6; // <--- AGREGA ESTA LÍNEA

// Encabezados de tabla
$headers = [
    "CÉDULA",
    "NOMBRES",
    "APELLIDOS",
    "SEXO",
    "CARRERA",
    "TELÉFONO",
    "CORREO\nELECTRÓNICO"
];

// Calcular el número de líneas de cada encabezado
$pdf->SetFont('Arial', 'B', 6);
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
$altura_encabezado = $line_height * $max_lines;

// Guardar posición inicial
$x = $pdf->GetX();
$y = $pdf->GetY();

for ($i = 0; $i < count($headers); $i++) {
    $pdf->SetXY($x, $y);
    $cell_lines = $line_counts[$i];
    $cell_height = $cell_lines * $line_height;
    $offsetY = ($altura_encabezado - $cell_height) / 2;
    $pdf->SetFillColor(0, 102, 204);
    $pdf->SetTextColor(255);
    $pdf->Rect($x, $y, $ancho_columnas[$i], $altura_encabezado, 'DF');
    $pdf->SetXY($x, $y + $offsetY);
    $pdf->MultiCell($ancho_columnas[$i], $line_height, mb_convert_encoding($headers[$i], 'ISO-8859-1', 'UTF-8'), 0, 'C', true);
    $x += $ancho_columnas[$i];
}
$pdf->SetXY($pdf->GetX(), $y + $altura_encabezado);

// Colores para filas
$pdf->SetFont('Arial', '', 7);

$estudiantes = [];
while ($fila = $resultado->fetch_assoc()) {
    $estudiantes[] = $fila;
}

foreach ($estudiantes as $i => $fila) {
    // Alternar color de fondo: blanco y azul claro
    if ($i % 2 == 0) {
        $pdf->SetFillColor(255, 255, 255); // Blanco
    } else {
        $pdf->SetFillColor(224, 235, 255); // Azul claro
    }
    $pdf->SetTextColor(0);

    // Datos del estudiante
    $data = [
        mb_convert_encoding($fila['STUDENTS_CI'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($fila['NAME'] . ' ' . $fila['SECOND_NAME'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($fila['SURNAME'] . ' ' . $fila['SECOND_SURNAME'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($fila['GENDER'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($fila['CAREER_NAME'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($fila['CONTACT_PHONE'], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($fila['EMAIL'], 'ISO-8859-1', 'UTF-8')
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
        $cell_lines = $num_lines[$j];
        $cell_height = $cell_lines * $line_height;
        $offsetY = ($altura - $cell_height) / 2;
        $pdf->Rect($x, $y, $ancho_columnas[$j], $altura, 'DF');
        $pdf->SetXY($x, $y + $offsetY);
        $pdf->MultiCell($ancho_columnas[$j], $line_height, $data[$j], 0, 'C', false);
        $x += $ancho_columnas[$j];
    }
    $pdf->SetXY($pdf->GetX(), $y + $altura);
}

// Salida final del PDF
$pdf->Output('I', 'Listado_Estudiantes.pdf');
$conexion->close();

// --- Función para errores ---
function generarErrorPDF($mensaje)
{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Error', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, utf8_decode($mensaje));
    $pdf->Output('I', 'Error.pdf');
    exit;
}
?>
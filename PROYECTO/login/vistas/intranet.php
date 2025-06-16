<?php
require 'header.php';
require_once '../model/periodo.php'; // Modelo de períodos
require_once '../model/carrera_m.php'; // Modelo de carreras
require_once '../model/estudiante.php'; // Modelo de estudiantes

// Obtener el número de carreras activas
$carreraModel = new Carrera();
$carrerasActivas = $carreraModel->listarActivas();
$totalCarrerasActivas = count($carrerasActivas);

// Obtener el número de estudiantes activos por carrera
$studentModel = new Student();
$estudiantesPorCarrera = [];
$totalEstudiantesActivos = 0; // Variable para almacenar el total de estudiantes activos
foreach ($carrerasActivas as $carrera) {
    $estudiantes = $studentModel->getStudentByCareer($carrera['CAREER_ID']);
    $estudiantesPorCarrera[] = [
        'carrera' => $carrera['CAREER_NAME'],
        'total' => count($estudiantes)
    ];
    $totalEstudiantesActivos += count($estudiantes); // Sumar el número de estudiantes activos
}

$periodoModel = new Periodo();
$periodoEnCurso = $periodoModel->listarActivos();

$periodoActual = null;
$estadoPeriodo = null;

// Buscar el período EN CURSO
foreach ($periodoEnCurso as $periodo) {
    if ($periodo['PERIOD_STATUS'] == 2) { // Estado "EN CURSO"
        $periodoActual = $periodo;
        $estadoPeriodo = "EN CURSO";
        break;
    }
}

// Si no hay período EN CURSO, buscar el período PENDIENTE más reciente
if (!$periodoActual) {
    $periodosPendientes = array_filter($periodoEnCurso, function ($periodo) {
        return $periodo['PERIOD_STATUS'] == 1; // Estado "PENDIENTE"
    });

    if (!empty($periodosPendientes)) {
        // Ordenar los períodos pendientes por la fecha de creación en orden descendente
        usort($periodosPendientes, function ($a, $b) {
            return strtotime($b['CREATION_DATE']) - strtotime($a['CREATION_DATE']);
        });

        // Tomar el período pendiente más reciente
        $periodoActual = $periodosPendientes[0];
        $estadoPeriodo = "PENDIENTE";
    }
}

// Si no hay período PENDIENTE, buscar el período CULMINADO más antiguo
if (!$periodoActual) {
    $periodosCulminados = array_filter($periodoEnCurso, function ($periodo) {
        return $periodo['PERIOD_STATUS'] == 3; // Estado "CULMINADO"
    });

    if (!empty($periodosCulminados)) {
        // Ordenar los períodos culminados por la fecha de creación en orden ascendente
        usort($periodosCulminados, function ($a, $b) {
            return strtotime($a['CREATION_DATE']) - strtotime($b['CREATION_DATE']);
        });

        // Tomar el período culminado más antiguo
        $periodoActual = $periodosCulminados[0];
        $estadoPeriodo = "CULMINADO";
    }
}

// Si no hay períodos disponibles, mostrar un mensaje de que no hay períodos disponibles
if (!$periodoActual) {
    $estadoPeriodo = "N/A";
}
?>

<style>

  .main-content {
    /* background: #f8f8fc; */
    min-height: 100vh;
    padding: 0 2rem;
  }

  .dashboard-header {
    background: #bac9ff;
    border-radius: 18px;
    padding: 2rem;
    margin-bottom: 2rem;
    margin-top: 2rem;
    display: flex;
    align-items: center;
    gap: 2rem;
  }

  .dashboard-header h2 {
    font-size: 2rem;
    font-weight: 600;
    color: #272346;
    margin-bottom: 0.5rem;
  }

  .dashboard-header .subtitle {
    color: #666;
    font-size: 1.1rem;
  }

  .dashboard-header img {
    width: 110px;
    border-radius: 16px;
  }

  .metrics-row {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }

  .metric-card {
    border-radius: 12px;
    padding: 1.2rem 2rem;
    min-width: 140px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .metric-open {
    background:rgb(255, 213, 45);
    color: #272346;
  }

  .metric-complete {
    background:rgb(193, 152, 255);
    color: #5e35b1;
  }

  .metric-unique {
    /* background: #f8bbd0; */
    color: #c2185b;
  }

  .metric-total {
    background: #e1bee7;
    color: #7e57c2;
  }

  .metric-card .value {
    font-size: 1.3rem;
    font-weight: 700;
  }

  .metric-card .label {
    font-size: 1rem;
  }

  .projects-section {
    margin-bottom: 2rem;
  }

  .projects-section .section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #272346;
    margin-bottom: 1rem;
  }

  .project-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    padding: 1.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
  }

  .project-card img {
    width: 60px;
    border-radius: 10px;
  }

  .project-info {
    flex: 1;
  }

  .project-info .title {
    font-weight: 600;
    color: #192dd4;
  }

  .project-info .desc {
    color: #666;
    font-size: 0.95rem;
  }

  .project-info .slides {
    font-size: 0.9rem;
    color: #888;
  }

  .project-privacy {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
  }

  .project-privacy span {
    font-size: 0.9rem;
    color: #666;
  }

  .project-actions {
    display: flex;
    gap: 0.5rem;
  }

  button.task-edit,
  button.task-delete {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.7rem;
    border-radius: 6px;
    transition: background 0.2s;
  }

  button.task-edit:hover {
    background: #ede7f6;
  }

  button.task-delete:hover {
    background: #f8bbd0;
  }

  button .icon i {
    margin-left: 0.2rem;
  }

  input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #192dd4;
  }

  /* Estilo para la tabla */
  .styled-table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 1em;
    font-family: 'Arial', sans-serif;
    text-align: left;
    background-color: #e3e7fc;
    border-radius: 10px;
    overflow: hidden;
  }

  .styled-table thead tr {
    background-color: #6c63ff;
    color: #ffffff;
    text-align: left;
  }

  .styled-table th,
  .styled-table td {
    padding: 12px 15px;
  }

  .styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
  }

  .styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
  }

  .styled-table tbody tr:hover {
    background-color: #d6d9f5;
  }

  /* Animación para los elementos dentro de main-content */
  .main-content {
    opacity: 0;
    transform: translateY(-50px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
  }

  .main-content.visible {
    opacity: 1;
    transform: translateY(0);
  }

  @media (max-width: 900px) {

    .dashboard-header,
    .metrics-row,
    .project-card {
      flex-direction: column;
      align-items: flex-start;
      gap: 1rem;
    }

    .main-content {
      padding: 0 0.5rem;
    }
  }
</style>

<script>
  // Esperar a que el DOM esté completamente cargado
  document.addEventListener("DOMContentLoaded", function () {
    const mainContent = document.querySelector(".main-content");
    if (mainContent) {
      // Agregar la clase visible para activar la animación
      setTimeout(() => {
        mainContent.classList.add("visible");
      }, 100); // Retraso opcional para un efecto más suave
    }
  });
</script>

<div class="main-content">
  <!-- Encabezado de bienvenida -->
  <div class="dashboard-header">
    <div style="flex:1;">
      <h2>Hola, <?php echo ucfirst($_SESSION["NAME"]); ?></h2>
      <div class="subtitle">¿Lista para comenzar tu día laboral?</div>
    </div>
    <div style="flex-shrink:0;">
      <img src="https://img.icons8.com/color/96/000000/laptop.png" alt="Ilustración">
    </div>
  </div>

  <!-- Métricas resumen -->
  <div class="metrics-row">
    <div class="metric-card metric-open">
      <?php if ($periodoActual): ?>
        <div class="value">Período: <?php echo htmlspecialchars($periodoActual['DESCRIPTION']); ?></div>
        <div class="label">
          Estado: <?php echo $estadoPeriodo; ?><br>
          Desde: <?php echo date('d/m/Y', strtotime($periodoActual['START_DATE'])); ?><br>
          Hasta: <?php echo date('d/m/Y', strtotime($periodoActual['END_DATE'])); ?>
        </div>
      <?php else: ?>
        <div class="value">N/A</div>
        <div class="label">No hay períodos disponibles</div>
      <?php endif; ?>
    </div>
    <div class="metric-card metric-complete">
      <div class="value"><?php echo $totalCarrerasActivas; ?></div>
      <div class="label">Carreras activas</div>
    </div>
    <div class="metric-card metric-total">
      <div class="value"><?php echo $totalEstudiantesActivos; ?></div>
      <div class="label">Estudiantes activos</div>
    </div>
  </div>

  <!-- Tabla de estudiantes por carrera -->
  <table class="styled-table">
    <thead>
      <tr>
        <th>Carrera</th>
        <th>Número de Estudiantes</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($estudiantesPorCarrera as $item): ?>
        <tr>
          <td><?php echo htmlspecialchars($item['carrera']); ?></td>
          <td style="text-align: center;"><?php echo $item['total']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php
require 'footer.php';
?>
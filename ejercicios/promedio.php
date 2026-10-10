<?php
require_once __DIR__ . '/../clases/PromedioModa.php';

$resEstadistica = null;
$cadenaIngresada = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numeros'])) {
    $cadenaIngresada = $_POST['numeros'];
    $objEstadistica = new PromedioModa($cadenaIngresada);
    $resEstadistica = $objEstadistica->calcular();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 3 - Promedio, Media y Moda</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
  <link rel="stylesheet" href="../css/promedio.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 03</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Promedio, Mediana y Moda</h1>
      <p class="descripcion-ejercicio">
        Ingrese números reales separados por comas. El sistema ordenará mediante Bubble Sort y calculará los parámetros estadísticos.
      </p>

      <form action="promedio.php" method="POST">
        <div class="grupo-campo">
          <label for="numeros">Valores Reales (separados por coma):</label>
          <input 
            type="text" 
            id="numeros" 
            name="numeros" 
            class="input-control" 
            placeholder="Ej: 12.5, 45, 8, 12.5, 90, 33" 
            value="<?php echo htmlspecialchars($cadenaIngresada); ?>" 
            required
          >
        </div>

        <button type="submit" class="btn-submit">Calcular Parámetros</button>
      </form>

      <?php if ($resEstadistica !== null && $resEstadistica['valido']): ?>
        <div class="stats-kpi-grid">
          <article class="kpi-card">
            <span class="kpi-title">Promedio (Media)</span>
            <div class="kpi-value"><?php echo $resEstadistica['promedio']; ?></div>
          </article>

          <article class="kpi-card">
            <span class="kpi-title">Mediana</span>
            <div class="kpi-value accent"><?php echo $resEstadistica['mediana']; ?></div>
          </article>

          <article class="kpi-card">
            <span class="kpi-title">Moda</span>
            <div class="kpi-value success" style="font-size: 1.2rem;"><?php echo htmlspecialchars($resEstadistica['moda']); ?></div>
          </article>
        </div>

        <div class="sorted-array-box">
          <strong>Arreglo Ordenado (Bubble Sort):</strong>
          [<?php echo implode(', ', $resEstadistica['ordenados']); ?>]
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
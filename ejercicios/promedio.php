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
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 03 / 04</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Promedio, Mediana y Moda</h1>
      <p class="descripcion-ejercicio">
        Ingrese una serie de números separados por comas. El sistema ordenará la lista manualmente (Bubble Sort) para calcular la mediana, media y moda.
      </p>

      <form action="promedio.php" method="POST">
        <div class="grupo-campo">
          <label for="numeros">Serie de Números Reales:</label>
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

        <button type="submit" class="btn-submit">Calcular Estadísticas</button>
      </form>

      <?php if ($resEstadistica !== null): ?>
        <article class="box-resultado" aria-live="polite">
          <?php if ($resEstadistica['valido']): ?>
            <h3>&check; Resultados Estadísticos</h3>
            <div class="resultado-item">
              <strong>Total de Datos:</strong> <?php echo $resEstadistica['cantidad']; ?>
            </div>
            <div class="resultado-item">
              <strong>Datos Ordenados (Bubble Sort):</strong> [<?php echo implode(', ', $resEstadistica['ordenados']); ?>]
            </div>
            <div class="resultado-item" style="margin-top: 1rem;">
              <strong>1. Promedio (Media Aritmética):</strong> <?php echo $resEstadistica['promedio']; ?>
            </div>
            <div class="resultado-item">
              <strong>2. Mediana:</strong> <?php echo $resEstadistica['mediana']; ?>
            </div>
            <div class="resultado-item">
              <strong>3. Moda:</strong> <?php echo htmlspecialchars($resEstadistica['moda']); ?>
            </div>
          <?php else: ?>
            <h3 style="color: #ef4444;">&cross; Error de Entrada</h3>
            <p><?php echo htmlspecialchars($resEstadistica['mensaje']); ?></p>
          <?php endif; ?>
        </article>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
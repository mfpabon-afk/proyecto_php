<?php
session_start();
require_once __DIR__ . '/../clases/Calculadora.php';

if (!isset($_SESSION['historial_calc'])) {
    $_SESSION['historial_calc'] = [];
}

// Borrar historial
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear') {
    $_SESSION['historial_calc'] = [];
    header('Location: calculadora.php');
    exit;
}

$num1 = $_POST['num1'] ?? '';
$num2 = $_POST['num2'] ?? '';
$operacion = $_POST['operacion'] ?? '+';
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_numeric($num1) && is_numeric($num2)) {
    $calc = new Calculadora((float)$num1, (float)$num2, $operacion);
    $resultado = $calc->calcular();
    $_SESSION['historial_calc'][] = $calc->getExpresionFormat();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 4 - Calculadora con Historial</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
  <link rel="stylesheet" href="../css/calculadora.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 04 / 04</span>
  </header>

  <main class="container-ejercicio">
    <h1 class="titulo-ejercicio-page">Calculadora Flotante con Historial</h1>
    <p class="descripcion-ejercicio">Realice operaciones aritméticas básicas y consulte el registro de operaciones anteriores.</p>

    <div class="calc-floating-wrapper">
      <!-- WIDGET FLOTANTE -->
      <article class="calc-widget">
        <form action="calculadora.php" method="POST">
          <div class="calc-display">
            <div class="calc-display-prev">
              <?php echo $resultado !== null ? htmlspecialchars("{$num1} {$operacion} {$num2}") : '0'; ?>
            </div>
            <div class="calc-display-main">
              <?php echo $resultado !== null ? htmlspecialchars((string)$resultado) : '0'; ?>
            </div>
          </div>

          <div class="grupo-campo">
            <label for="num1">Primer Número:</label>
            <input type="number" step="any" id="num1" name="num1" class="input-control" value="<?php echo htmlspecialchars((string)$num1); ?>" required placeholder="0">
          </div>

          <div class="grupo-campo">
            <label for="operacion">Operación:</label>
            <select id="operacion" name="operacion" class="select-control" required>
              <option value="+" <?php echo $operacion === '+' ? 'selected' : ''; ?>>+ Suma</option>
              <option value="-" <?php echo $operacion === '-' ? 'selected' : ''; ?>>- Resta</option>
              <option value="*" <?php echo $operacion === '*' ? 'selected' : ''; ?>>* Multiplicación</option>
              <option value="/" <?php echo $operacion === '/' ? 'selected' : ''; ?>>/ División</option>
              <option value="%" <?php echo $operacion === '%' ? 'selected' : ''; ?>>% Porcentaje</option>
            </select>
          </div>

          <div class="grupo-campo">
            <label for="num2">Segundo Número:</label>
            <input type="number" step="any" id="num2" name="num2" class="input-control" value="<?php echo htmlspecialchars((string)$num2); ?>" required placeholder="0">
          </div>

          <button type="submit" class="btn-submit">Calcular Operación</button>
        </form>
      </article>

      <!-- HISTORIAL FLOTANTE -->
      <aside class="calc-history-panel">
        <div class="calc-history-header">
          <h3>Historial</h3>
          <?php if (!empty($_SESSION['historial_calc'])): ?>
            <form action="calculadora.php" method="POST" style="margin:0;">
              <input type="hidden" name="action" value="clear">
              <button type="submit" class="btn-clear-history">Borrar</button>
            </form>
          <?php endif; ?>
        </div>

        <ul class="calc-history-list">
          <?php if (empty($_SESSION['historial_calc'])): ?>
            <li style="color: var(--color-text-muted); font-size: 0.85rem;">No hay operaciones registradas.</li>
          <?php else: ?>
            <?php foreach (array_reverse($_SESSION['historial_calc']) as $item): ?>
              <li class="calc-history-item"><?php echo htmlspecialchars($item); ?></li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </aside>
    </div>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
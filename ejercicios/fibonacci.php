<?php
require_once __DIR__ . '/../clases/Fibonacci.php';

$resCalculo = null;
$numeroIngresado = 10;
$operacionSeleccionada = 'fibonacci';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero'])) {
    $numeroIngresado = (int)$_POST['numero'];
    $operacionSeleccionada = $_POST['operacion'] ?? 'fibonacci';
    $objFibonacci = new Fibonacci($numeroIngresado, $operacionSeleccionada);
    $resCalculo = $objFibonacci->calcular();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 2 - Fibonacci o Factorial</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
  <link rel="stylesheet" href="../css/fibonacci.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 02</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Fibonacci & Factorial</h1>
      <p class="descripcion-ejercicio">
        Ingrese un entero $n$ y seleccione la función matemática a evaluar.
      </p>

      <form action="fibonacci.php" method="POST">
        <div class="grupo-campo">
          <label for="numero">Número Entero (n):</label>
          <input 
            type="number" 
            id="numero" 
            name="numero" 
            class="input-control" 
            min="0" 
            max="50" 
            value="<?php echo htmlspecialchars((string)$numeroIngresado); ?>" 
            required
          >
        </div>

        <div class="grupo-campo">
          <label for="operacion">Operación:</label>
          <select id="operacion" name="operacion" class="select-control" required>
            <option value="fibonacci" <?php echo $operacionSeleccionada === 'fibonacci' ? 'selected' : ''; ?>>Sucesión de Fibonacci</option>
            <option value="factorial" <?php echo $operacionSeleccionada === 'factorial' ? 'selected' : ''; ?>>Factorial (n!)</option>
          </select>
        </div>

        <button type="submit" class="btn-submit">Generar Resultado</button>
      </form>

      <?php if ($resCalculo !== null): ?>
        <div style="margin-top: 2rem;">
          <h3>Resultado (n = <?php echo $numeroIngresado; ?>)</h3>
          
          <?php if ($operacionSeleccionada === 'fibonacci'): ?>
            <div class="fib-sequence-grid">
              <?php foreach ($resCalculo['serie'] as $i => $val): ?>
                <div class="fib-term-card">
                  <span class="fib-term-index">f(<?php echo $i; ?>)</span>
                  <span class="fib-term-value"><?php echo $val; ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="fact-step-box" style="margin-top:1rem;">
              <?php echo htmlspecialchars($resCalculo['resultado']); ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
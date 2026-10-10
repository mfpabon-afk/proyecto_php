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
  <title>Ejercicio 2 - Sucesión de Fibonacci o Factorial</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 02 / 04</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Sucesión de Fibonacci / Factorial</h1>
      <p class="descripcion-ejercicio">
        Seleccione la operación e ingrese un entero positivo para generar la serie matemática iterativa.
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
            <option value="fibonacci" <?php echo $operacionSeleccionada === 'fibonacci' ? 'selected' : ''; ?>>Sucesión de Fibonacci (Primeros n términos)</option>
            <option value="factorial" <?php echo $operacionSeleccionada === 'factorial' ? 'selected' : ''; ?>>Cálculo Factorial (n!)</option>
          </select>
        </div>

        <button type="submit" class="btn-submit">Calcular Serie</button>
      </form>

      <?php if ($resCalculo !== null): ?>
        <article class="box-resultado" aria-live="polite">
          <h3>&check; Resultado Obtenido</h3>
          <div class="resultado-item">
            <strong>Operación Ejecutada:</strong> <?php echo ucfirst($operacionSeleccionada); ?> (n = <?php echo $numeroIngresado; ?>)
          </div>
          <div class="resultado-item">
            <strong>Resultado / Serie:</strong><br>
            <div style="background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px; margin-top: 0.5rem; word-break: break-all; font-family: monospace;">
              <?php echo htmlspecialchars($resCalculo['resultado']); ?>
            </div>
          </div>
        </article>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
<?php
require_once __DIR__ . '/../clases/Binario.php';

$resBinario = null;
$numInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero'])) {
    $numInput = (int)$_POST['numero'];
    $objBin = new Binario($numInput);
    $resBinario = $objBin->convertir();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Conversor a Binario</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
  <link rel="stylesheet" href="../css/binario.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Conversor Digital</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Conversor Entero a Binario</h1>
      <p class="descripcion-ejercicio">Ingrese un entero base 10 para transformarlo en representación binaria.</p>

      <form action="binario.php" method="POST">
        <div class="grupo-campo">
          <label for="numero">Número Entero Decimal:</label>
          <input type="number" id="numero" name="numero" min="0" class="input-control" value="<?php echo htmlspecialchars((string)$numInput); ?>" required placeholder="Ej: 42">
        </div>
        <button type="submit" class="btn-submit">Convertir a Binario</button>
      </form>

      <?php if ($resBinario !== null): ?>
        <div class="bit-display-grid">
          <?php foreach ($resBinario['bits'] as $bit): ?>
            <div class="bit-box <?php echo $bit === '1' ? 'active' : ''; ?>">
              <?php echo $bit; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="binary-steps-list">
          <strong>Pasos de la División por 2:</strong>
          <ul style="margin-top:0.5rem; padding-left:1.2rem;">
            <?php foreach ($resBinario['pasos'] as $paso): ?>
              <li><?php echo htmlspecialchars($paso); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
<?php
require_once __DIR__ . '/../clases/Acronimo.php';

$resultado = null;
$fraseOriginal = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['frase'])) {
    $fraseOriginal = $_POST['frase'];
    $objAcronimo = new Acronimo($fraseOriginal);
    $resultado = $objAcronimo->calcular();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 1 - Convertir Frase en Acrónimo</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
  <link rel="stylesheet" href="../css/acronimo.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 01</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Generador de Acrónimos</h1>
      <p class="descripcion-ejercicio">
        Ingrese una frase o término largo. El algoritmo extraerá la inicial de cada palabra ignorando signos y puntuación.
      </p>

      <form action="acronimo.php" method="POST">
        <div class="grupo-campo">
          <label for="frase">Frase o Término Completo:</label>
          <input 
            type="text" 
            id="frase" 
            name="frase" 
            class="input-control" 
            placeholder="Ej: Portable Network Graphics" 
            value="<?php echo htmlspecialchars($fraseOriginal); ?>" 
            required 
            autofocus
          >
        </div>

        <button type="submit" class="btn-submit">Generar Acrónimo</button>
      </form>

      <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="acronimo-card-wrapper" style="margin-top: 2rem;">
          <article class="acronimo-result-card" aria-live="polite">
            <span style="color: var(--color-text-muted); font-size: 0.9rem;">Acrónimo Generado:</span>
            <div class="acronimo-display-main"><?php echo htmlspecialchars($resultado ?: 'N/A'); ?></div>

            <div class="acronimo-letters-grid">
              <?php 
                $palabras = preg_split('/[\s\-_]+/', trim($fraseOriginal));
                foreach ($palabras as $p):
                  $pLimpia = preg_replace('/[^\p{L}\p{N}]/u', '', $p);
                  if (!empty($pLimpia)):
                    $primera = mb_strtoupper(mb_substr($pLimpia, 0, 1, 'UTF-8'), 'UTF-8');
              ?>
                <div class="acronimo-letter-pill">
                  <strong><?php echo htmlspecialchars($primera); ?></strong>
                  <span><?php echo htmlspecialchars($pLimpia); ?></span>
                </div>
              <?php 
                  endif;
                endforeach; 
              ?>
            </div>
          </article>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
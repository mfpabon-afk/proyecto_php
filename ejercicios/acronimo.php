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
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 01 / 04</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Generador de Acrónimos</h1>
      <p class="descripcion-ejercicio">
        Ingrese una frase o nombre largo. El algoritmo procesará la cadena carácter por carácter para extraer las iniciales.
      </p>

      <form action="acronimo.php" method="POST">
        <div class="grupo-campo">
          <label for="frase">Frase o Nombre Completo:</label>
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
        <article class="box-resultado" aria-live="polite">
          <h3>&check; Resultado Obtenido</h3>
          <div class="resultado-item">
            <strong>Frase Ingresada:</strong> <?php echo htmlspecialchars($fraseOriginal); ?>
          </div>
          <div class="resultado-item">
            <strong>Acrónimo Generado:</strong><br>
            <span class="badge-res"><?php echo htmlspecialchars($resultado ?: 'N/A'); ?></span>
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
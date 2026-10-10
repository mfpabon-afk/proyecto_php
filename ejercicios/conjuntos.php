<?php
require_once __DIR__ . '/../clases/Conjuntos.php';

$resConjuntos = null;
$entradaA = '';
$entradaB = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entradaA = $_POST['conjunto_a'] ?? '';
    $entradaB = $_POST['conjunto_b'] ?? '';
    $objConjuntos = new Conjuntos($entradaA, $entradaB);
    $resConjuntos = $objConjuntos->calcular();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 4 - Operaciones con Conjuntos</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
  <link rel="stylesheet" href="../css/conjuntos.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 04</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Teoría de Conjuntos</h1>
      <p class="descripcion-ejercicio">
        Ingrese enteros para los conjuntos A y B.
      </p>

      <form action="conjuntos.php" method="POST">
        <div class="grupo-campo">
          <label for="conjunto_a">Conjunto A (enteros):</label>
          <input type="text" id="conjunto_a" name="conjunto_a" class="input-control" placeholder="1, 2, 3, 4" value="<?php echo htmlspecialchars($entradaA); ?>" required>
        </div>

        <div class="grupo-campo">
          <label for="conjunto_b">Conjunto B (enteros):</label>
          <input type="text" id="conjunto_b" name="conjunto_b" class="input-control" placeholder="3, 4, 5, 6" value="<?php echo htmlspecialchars($entradaB); ?>" required>
        </div>

        <button type="submit" class="btn-submit">Calcular Operaciones</button>
      </form>

      <?php if ($resConjuntos !== null): ?>
        <div class="set-results-grid">
          <article class="set-card">
            <div class="set-title" style="color:var(--color-primary);">Unión (A &cup; B)</div>
            <div class="set-elements-badge">{ <?php echo implode(', ', $resConjuntos['union']); ?> }</div>
          </article>

          <article class="set-card">
            <div class="set-title" style="color:var(--color-accent);">Intersección (A &cap; B)</div>
            <div class="set-elements-badge">{ <?php echo implode(', ', $resConjuntos['interseccion']) ?: 'ø'; ?> }</div>
          </article>

          <article class="set-card">
            <div class="set-title" style="color:#f59e0b;">Diferencia (A &minus; B)</div>
            <div class="set-elements-badge">{ <?php echo implode(', ', $resConjuntos['diferencia_a_b']) ?: 'ø'; ?> }</div>
          </article>

          <article class="set-card">
            <div class="set-title" style="color:#10b981;">Diferencia (B &minus; A)</div>
            <div class="set-elements-badge">{ <?php echo implode(', ', $resConjuntos['diferencia_b_a']) ?: 'ø'; ?> }</div>
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
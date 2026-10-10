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
  <title>Ejercicio 4 - Operaciones de Conjuntos</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Ejercicio 04 / 04</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Operaciones con Conjuntos</h1>
      <p class="descripcion-ejercicio">
        Ingrese dos conjuntos de números enteros A y B. La aplicación evaluará la pertenencia mediante búsqueda lineal para obtener unión, intersección y diferencias.
      </p>

      <form action="conjuntos.php" method="POST">
        <div class="grupo-campo">
          <label for="conjunto_a">Conjunto A (enteros):</label>
          <input 
            type="text" 
            id="conjunto_a" 
            name="conjunto_a" 
            class="input-control" 
            placeholder="Ej: 1, 2, 3, 4, 5" 
            value="<?php echo htmlspecialchars($entradaA); ?>" 
            required
          >
        </div>

        <div class="grupo-campo">
          <label for="conjunto_b">Conjunto B (enteros):</label>
          <input 
            type="text" 
            id="conjunto_b" 
            name="conjunto_b" 
            class="input-control" 
            placeholder="Ej: 3, 4, 5, 6, 7" 
            value="<?php echo htmlspecialchars($entradaB); ?>" 
            required
          >
        </div>

        <button type="submit" class="btn-submit">Calcular Operaciones de Conjuntos</button>
      </form>

      <?php if ($resConjuntos !== null): ?>
        <article class="box-resultado" aria-live="polite">
          <h3>&check; Resultados de las Operaciones</h3>

          <div class="resultado-item">
            <strong>Conjunto A:</strong> { <?php echo implode(', ', $resConjuntos['conjunto_a']); ?> }
          </div>
          <div class="resultado-item">
            <strong>Conjunto B:</strong> { <?php echo implode(', ', $resConjuntos['conjunto_b']); ?> }
          </div>

          <hr style="border: 0; border-top: 1px solid var(--color-border); margin: 1rem 0;">

          <div class="resultado-item">
            <strong>1. Unión (A &cup; B):</strong><br>
            <span style="color: var(--color-success); font-weight: bold;">{ <?php echo implode(', ', $resConjuntos['union']); ?> }</span>
          </div>

          <div class="resultado-item">
            <strong>2. Intersección (A &cap; B):</strong><br>
            <span style="color: var(--color-primary); font-weight: bold;">{ <?php echo implode(', ', $resConjuntos['interseccion']) ?: 'ø (Conjunto Vacío)'; ?> }</span>
          </div>

          <div class="resultado-item">
            <strong>3. Diferencia (A &minus; B):</strong><br>
            <span style="color: var(--color-accent); font-weight: bold;">{ <?php echo implode(', ', $resConjuntos['diferencia_a_b']) ?: 'ø (Conjunto Vacío)'; ?> }</span>
          </div>

          <div class="resultado-item">
            <strong>4. Diferencia (B &minus; A):</strong><br>
            <span style="color: #f59e0b; font-weight: bold;">{ <?php echo implode(', ', $resConjuntos['diferencia_b_a']) ?: 'ø (Conjunto Vacío)'; ?> }</span>
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

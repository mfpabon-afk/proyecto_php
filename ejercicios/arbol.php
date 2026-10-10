<?php
require_once __DIR__ . '/../clases/ArbolBinario.php';

$treeHTML = null;
$preInput = $_POST['preorden'] ?? 'A, B, D, E, C';
$inInput = $_POST['inorden'] ?? 'D, B, E, A, C';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arbol = new ArbolBinario($preInput, $inInput);
    $raiz = $arbol->construir();
    $treeHTML = $arbol->renderHTML($raiz);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Construcción de Árbol Binario</title>
  <link rel="stylesheet" href="../css/ejercicios.css">
  <link rel="stylesheet" href="../css/arbol.css">
</head>
<body>

  <header class="header-ejercicio">
    <a href="../index.php" class="btn-volver">&larr; Volver al Menú Principal</a>
    <span>Visualizador de Árboles</span>
  </header>

  <main class="container-ejercicio">
    <section class="card-form">
      <h1 class="titulo-ejercicio-page">Árbol Binario desde Recorridos</h1>
      <p class="descripcion-ejercicio">Ingrese los recorridos Preorden e Inorden separados por comas.</p>

      <form action="arbol.php" method="POST">
        <div class="grupo-campo">
          <label for="preorden">Recorrido Preorden:</label>
          <input type="text" id="preorden" name="preorden" class="input-control" value="<?php echo htmlspecialchars($preInput); ?>" required>
        </div>

        <div class="grupo-campo">
          <label for="inorden">Recorrido Inorden:</label>
          <input type="text" id="inorden" name="inorden" class="input-control" value="<?php echo htmlspecialchars($inInput); ?>" required>
        </div>

        <button type="submit" class="btn-submit">Construir y Renderizar Árbol</button>
      </form>

      <?php if ($treeHTML !== null): ?>
        <div class="tree-visual-container">
          <?php echo $treeHTML; ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer class="footer-ejercicio">
    <p>Taller Académico PHP &bull; POO &bull; Sin JavaScript</p>
  </footer>

</body>
</html>
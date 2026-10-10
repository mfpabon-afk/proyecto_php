<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taller PHP - Menú de Aplicaciones Web</title>
  <link rel="stylesheet" href="css/menu.css">
</head>
<body>

  <!-- Checkbox oculto para la interacción del menú (Sin JavaScript) -->
  <input type="checkbox" id="menu-toggle" class="menu-checkbox" aria-hidden="true">

  <!-- Capa de fondo para cerrar el menú al hacer clic fuera -->
  <label for="menu-toggle" class="menu-overlay" aria-label="Cerrar menú"></label>

  <!-- Encabezado principal -->
  <header class="header-principal">
    <div class="logo-taller">
      <h1>TALLER ACADÉMICO</h1>
      <p>Aplicaciones Web en PHP Nativo & POO</p>
    </div>

    <!-- Botón visible que activa el checkbox -->
    <label for="menu-toggle" class="menu-trigger-btn" aria-label="Abrir panel de ejercicios">
      <span>Ver Ejercicios</span>
      <div class="menu-icon-dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </label>
  </header>

  <!-- Panel lateral deslizable (Transición de derecha a izquierda) -->
  <aside class="panel-menu" aria-label="Menú lateral de ejercicios">
    <div class="panel-header">
      <h2>Ejercicios Disponibles</h2>
      <label for="menu-toggle" class="panel-close-btn" aria-label="Cerrar panel">&times;</label>
    </div>

    <nav class="nav-ejercicios" aria-label="Lista de accesos a ejercicios">
      <ul class="lista-ejercicios">

        <!-- Opción 1 -->
        <li class="item-ejercicio">
          <a href="ejercicios/acronimo.php" class="link-ejercicio" aria-label="Ir al Ejercicio 1: Convertir frase en acrónimo">
            <span class="num-ejercicio">01</span>
            <span class="titulo-ejercicio">Generador de Acrónimos</span>
            <!-- Imagen de previsualización que aparece a la izquierda al hacer hover -->
            <figure class="preview-box" aria-hidden="true">
              <img src="img/acronimo.svg" alt="Previsualización Acrónimo" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 1: Frases a acrónimos (ej. PNG, LCD)</figcaption>
            </figure>
          </a>
        </li>

        <!-- Opción 2 -->
        <li class="item-ejercicio">
          <a href="ejercicios/fibonacci.php" class="link-ejercicio" aria-label="Ir al Ejercicio 2: Fibonacci o Factorial">
            <span class="num-ejercicio">02</span>
            <span class="titulo-ejercicio">Fibonacci / Factorial</span>
            <figure class="preview-box" aria-hidden="true">
              <img src="img/fibonacci.svg" alt="Previsualización Fibonacci" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 2: Sucesión de Fibonacci o cálculo Factorial</figcaption>
            </figure>
          </a>
        </li>

        <!-- Opción 3 -->
        <li class="item-ejercicio">
          <a href="ejercicios/promedio.php" class="link-ejercicio" aria-label="Ir al Ejercicio 3: Promedio, Media y Moda">
            <span class="num-ejercicio">03</span>
            <span class="titulo-ejercicio">Promedio, Media y Moda</span>
            <figure class="preview-box" aria-hidden="true">
              <img src="img/promedio.svg" alt="Previsualización Estadística" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 3: Promedio, mediana y moda de números reales</figcaption>
            </figure>
          </a>
        </li>

        <!-- Opción 4 -->
        <li class="item-ejercicio">
          <a href="ejercicios/conjuntos.php" class="link-ejercicio" aria-label="Ir al Ejercicio 4: Operaciones con Conjuntos">
            <span class="num-ejercicio">04</span>
            <span class="titulo-ejercicio">Operaciones de Conjuntos</span>
            <figure class="preview-box" aria-hidden="true">
              <img src="img/conjuntos.svg" alt="Previsualización Conjuntos" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 4: Unión, intersección y diferencias (A-B, B-A)</figcaption>
            </figure>
          </a>
        </li>

      </ul>
    </nav>
  </aside>

  <!-- Contenido principal de bienvenida -->
  <main class="main-content">
    <section class="hero-section">
      <span class="hero-badge">Desarrollo Web Nativo</span>
      <h2 class="hero-title">Taller Académico de Programación PHP</h2>
      <p class="hero-subtitle">
        Plataforma modular estructurada bajo el patrón de Programación Orientada a Objetos (POO), HTML5 semántico y CSS3 puro sin el uso de JavaScript.
      </p>

      <div class="grid-cards">
        <article class="card-ejercicio">
          <div class="card-icon">01</div>
          <h3>Acrónimos</h3>
          <p>Transforma frases en acrónimos limpios respetando reglas ortográficas.</p>
          <a href="ejercicios/acronimo.php" class="card-link">Iniciar Ejercicio &rarr;</a>
        </article>

        <article class="card-ejercicio">
          <div class="card-icon">02</div>
          <h3>Fibonacci & Factorial</h3>
          <p>Genera series numéricas iterativas y sucesiones matemáticas precisas.</p>
          <a href="ejercicios/fibonacci.php" class="card-link">Iniciar Ejercicio &rarr;</a>
        </article>

        <article class="card-ejercicio">
          <div class="card-icon">03</div>
          <h3>Estadística Descriptiva</h3>
          <p>Calcula media aritmética, mediana y moda con algoritmos manuales.</p>
          <a href="ejercicios/promedio.php" class="card-link">Iniciar Ejercicio &rarr;</a>
        </article>

        <article class="card-ejercicio">
          <div class="card-icon">04</div>
          <h3>Teoría de Conjuntos</h3>
          <p>Ejecuta operaciones lógicas entre dos conjuntos numéricos A y B.</p>
          <a href="ejercicios/conjuntos.php" class="card-link">Iniciar Ejercicio &rarr;</a>
        </article>
      </div>
    </section>
  </main>

  <!-- Pie de página semántico -->
  <footer class="footer-principal">
    <p>&copy; <?php echo date('Y'); ?> Taller Académico PHP. Trabajo Individual.</p>
  </footer>

</body>
</html>
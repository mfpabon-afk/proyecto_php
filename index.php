<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taller Académico - Menú de Aplicaciones Web</title>
  <link rel="stylesheet" href="css/menu.css">
</head>
<body>

  <!-- CHECKBOX OCULTO (CHECKBOX HACK SIN JAVASCRIPT) -->
  <input type="checkbox" id="menu-toggle" class="menu-checkbox" aria-hidden="true">

  <!-- OVERLAY OSCURO -->
  <label for="menu-toggle" class="menu-overlay" aria-label="Cerrar menú"></label>

  <!-- HEADER CON BOTÓN REVELADOR -->
  <header class="header-principal">
    <div class="logo-taller">
      <h1>TALLER ACADÉMICO</h1>
      <p>Aplicaciones Web en PHP Nativo & POO</p>
    </div>

    <label for="menu-toggle" class="menu-trigger-btn" aria-label="Abrir panel de ejercicios">
      <span>Ver Ejercicios</span>
      <div class="menu-icon-dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </label>
  </header>

  <!-- PANEL LATERAL DESPLEGABLE (TRANSICIÓN DERECHA A IZQUIERDA) -->
  <aside class="panel-menu" aria-label="Menú lateral de ejercicios">
    <div class="panel-header">
      <h2>Ejercicios Disponibles</h2>
      <label for="menu-toggle" class="panel-close-btn" aria-label="Cerrar panel">&times;</label>
    </div>

    <nav class="nav-ejercicios" aria-label="Lista de accesos a ejercicios">
      <ul class="lista-ejercicios">

        <!-- EJERCICIO 1 -->
        <li class="item-ejercicio">
          <a href="ejercicios/acronimo.php" class="link-ejercicio">
            <span class="num-ejercicio">01</span>
            <span class="titulo-ejercicio">Generador de Acrónimos</span>
            <figure class="preview-box">
              <img src="img/acronimo.svg" alt="Previsualización Acrónimo" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 1: Frases a acrónimos (ej. PNG, TGIF)</figcaption>
            </figure>
          </a>
        </li>

        <!-- EJERCICIO 2 -->
        <li class="item-ejercicio">
          <a href="ejercicios/fibonacci.php" class="link-ejercicio">
            <span class="num-ejercicio">02</span>
            <span class="titulo-ejercicio">Fibonacci / Factorial</span>
            <figure class="preview-box">
              <img src="img/fibonacci.svg" alt="Previsualización Fibonacci" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 2: Sucesión de Fibonacci o cálculo Factorial</figcaption>
            </figure>
          </a>
        </li>

        <!-- EJERCICIO 3 -->
        <li class="item-ejercicio">
          <a href="ejercicios/promedio.php" class="link-ejercicio">
            <span class="num-ejercicio">03</span>
            <span class="titulo-ejercicio">Promedio, Media y Moda</span>
            <figure class="preview-box">
              <img src="img/promedio.svg" alt="Previsualización Estadística" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 3: Promedio, mediana y moda de números reales</figcaption>
            </figure>
          </a>
        </li>

        <!-- EJERCICIO 4 -->
        <li class="item-ejercicio">
          <a href="ejercicios/calculadora.php" class="link-ejercicio">
            <span class="num-ejercicio">04</span>
            <span class="titulo-ejercicio">Calculadora con Historial</span>
            <figure class="preview-box">
              <img src="img/conjuntos.svg" alt="Previsualización Calculadora" class="preview-img">
              <figcaption class="preview-caption">Ejercicio 4: Calculadora flotante con historial de operaciones</figcaption>
            </figure>
          </a>
        </li>

      </ul>
    </nav>
  </aside>

  <!-- CONTENIDO CENTRAL -->
  <main class="main-content">
    <section class="hero-section">
      <span class="hero-badge">Desarrollo Web Nativo</span>
      <h2 class="hero-title">Taller Académico de Programación PHP</h2>
      <p class="hero-subtitle">
        Plataforma modular estructurada bajo el patrón de Programación Orientada a Objetos (POO), HTML5 semántico y CSS3 puro sin JavaScript.
      </p>

      <div class="grid-cards">
        <article class="card-ejercicio">
          <div class="card-icon">01</div>
          <h3>Acrónimos</h3>
          <p>Transforma frases complejas en acrónimos limpios.</p>
          <a href="ejercicios/acronimo.php" class="card-link">Iniciar Ejercicio &rarr;</a>
        </article>

        <article class="card-ejercicio">
          <div class="card-icon">02</div>
          <h3>Fibonacci & Factorial</h3>
          <p>Genera series numéricas iterativas y sucesiones matemáticas.</p>
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
          <h3>Calculadora Flotante</h3>
          <p>Calculadora visual con persistencia de historial de operaciones.</p>
          <a href="ejercicios/calculadora.php" class="card-link">Iniciar Ejercicio &rarr;</a>
        </article>
      </div>
    </section>
  </main>

  <footer class="footer-principal">
    <p>&copy; <?php echo date('Y'); ?> Taller Académico PHP. Trabajo Individual.</p>
  </footer>

</body>
</html>
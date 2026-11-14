<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Layout {
    public static function getEjercicios(): array {
        return [
            'ejercicio1' => ['num' => '01', 'nombre' => 'Acrónimo',        'url' => 'ejercicios/ejercicio1.php'],
            'ejercicio2' => ['num' => '02', 'nombre' => 'Fibonacci/Fact.', 'url' => 'ejercicios/ejercicio2.php'],
            'ejercicio3' => ['num' => '03', 'nombre' => 'Estadística',     'url' => 'ejercicios/ejercicio3.php'],
            'ejercicio4' => ['num' => '04', 'nombre' => 'Conjuntos',       'url' => 'ejercicios/ejercicio4.php'],
            'ejercicio5' => ['num' => '05', 'nombre' => 'Binario',         'url' => 'ejercicios/ejercicio5.php'],
            'ejercicio6' => ['num' => '06', 'nombre' => 'Árbol Binario',   'url' => 'ejercicios/ejercicio6.php'],
            'ejercicio7' => ['num' => '07', 'nombre' => 'Calculadora',     'url' => 'ejercicios/ejercicio7.php'],
        ];
    }

    public static function header(string $tituloPagina, string $paginaActiva, string $basePath = ''): void {
        $ejercicios = self::getEjercicios();
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina) ?> | Macintosh PHP </title>
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath) ?>css/style.css">
</head>
<body>
    <nav class="mac-menubar">
        <div class="mac-menubar-left">
            <a href="<?= htmlspecialchars($basePath) ?>index.php" class="mac-apple-logo" title="Ir al Escritorio / Menú Principal"></a>
            <a href="<?= htmlspecialchars($basePath) ?>index.php" class="mac-menu-item <?= $paginaActiva === 'inicio' ? 'active' : '' ?>">Archivo</a>

            <div class="mac-menu-item <?= $paginaActiva !== 'inicio' ? 'active' : '' ?>">
                Ejercicios ▾
                <div class="mac-dropdown">
                    <?php foreach ($ejercicios as $key => $ej): ?>
                        <a href="<?= htmlspecialchars($basePath . $ej['url']) ?>" class="<?= $paginaActiva === $key ? 'current' : '' ?>">
                            <?= $ej['num'] ?>. <?= htmlspecialchars($ej['nombre']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <a href="<?= htmlspecialchars($basePath) ?>ejercicios/ejercicio6.php" class="mac-menu-item">Árbol</a>
            <a href="<?= htmlspecialchars($basePath) ?>ejercicios/ejercicio7.php" class="mac-menu-item">Calculadora</a>
        </div>

        <div class="mac-menubar-right">
            <span><?= htmlspecialchars($tituloPagina) ?></span>
            <span>|</span>
            <span>PHP POO </span>
        </div>
    </nav>

    <div class="mac-desktop">
        <main class="desktop-stage">
        <?php
    }

    public static function footer(string $paginaActiva = 'inicio', string $basePath = ''): void {
        ?>
        </main>

        <aside class="desktop-icons-col">
            <a href="<?= htmlspecialchars($basePath) ?>index.php" class="desktop-icon-link <?= $paginaActiva === 'inicio' ? 'active' : '' ?>">
                <span class="icon-disquete"></span>
                <span>System Disk</span>
            </a>
            <a href="<?= htmlspecialchars($basePath) ?>ejercicios/ejercicio6.php" class="desktop-icon-link <?= $paginaActiva === 'ejercicio6' ? 'active' : '' ?>">
                <span class="icon-mac"></span>
                <span>Árbol.app</span>
            </a>
            <a href="<?= htmlspecialchars($basePath) ?>ejercicios/ejercicio7.php" class="desktop-icon-link <?= $paginaActiva === 'ejercicio7' ? 'active' : '' ?>">
                <span class="icon-doc"></span>
                <span>Calc.txt</span>
            </a>
            <a href="<?= htmlspecialchars($basePath) ?>index.php" class="desktop-icon-link">
                <span class="icon-trash"></span>
                <span>Trash</span>
            </a>
        </aside>
    </div>
</body>
</html>
        <?php
    }

    /* Ícono de carpeta dinámico (conservado en PHP porque recibe color por parámetro) */
    public static function svgCarpetaMac(string $colorCarpeta = '#9EB8D9'): string {
        return "
        <svg width='54' height='46' viewBox='0 0 27 23' shape-rendering='crispEdges'>
            <rect x='2' y='1' width='8' height='2' fill='#000'/>
            <rect x='1' y='3' width='25' height='18' fill='#000'/>
            <rect x='2' y='2' width='8' height='2' fill='{$colorCarpeta}'/>
            <rect x='2' y='4' width='23' height='16' fill='{$colorCarpeta}'/>
            <rect x='2' y='4' width='23' height='1' fill='#FFF'/>
            <rect x='8' y='7' width='11' height='10' fill='#FFF' stroke='#000' stroke-width='1'/>
            <rect x='13' y='7' width='5' height='9' fill='#B8D0EB'/>
            <rect x='10' y='9' width='1' height='2' fill='#000'/>
            <rect x='15' y='9' width='1' height='2' fill='#000'/>
            <rect x='13' y='10' width='1' height='3' fill='#000'/>
            <rect x='11' y='14' width='4' height='1' fill='#000'/>
        </svg>";
    }

    /* Ilustración 1-bit estilo Scrapbook cargada desde CSS (.scrapbook-art) */
    public static function svgIlustracionScrapbook(string $titulo = 'Ready'): string {
        return "
        <div style='border:2px solid #000; background:#000; padding:4px;'>
            <div class='scrapbook-art'></div>
        </div>
        <p style='margin-top:10px; font-size:1.15rem;'>
            Completa los datos en la ventana de la izquierda y presiona <strong>OK</strong> para procesar <strong>" . htmlspecialchars($titulo) . "</strong>.
        </p>";
    }
}

function renderHeader(string $tituloPagina, string $paginaActiva, string $basePath = ''): void {
    Layout::header($tituloPagina, $paginaActiva, $basePath);
}

function renderFooter(string $paginaActiva = 'inicio', string $basePath = ''): void {
    Layout::footer($paginaActiva, $basePath);
}
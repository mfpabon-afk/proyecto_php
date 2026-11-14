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
    <title><?= htmlspecialchars($tituloPagina) ?> | Macintosh PHP OS</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath) ?>css/style.css">
</head>
<body>
    <!-- Barra superior estilo Classic Mac OS (Imagen 1) -->
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
            <span>PHP POO OS</span>
        </div>
    </nav>

    <!-- Escritorio con área de trabajo y columna de íconos a la derecha -->
    <div class="mac-desktop">
        <main class="desktop-stage">
        <?php
    }

    public static function footer(string $paginaActiva = 'inicio', string $basePath = ''): void {
        ?>
        </main>

        <!-- Íconos del escritorio a la derecha como en la Imagen 1 -->
        <aside class="desktop-icons-col">
            <a href="<?= htmlspecialchars($basePath) ?>index.php" class="desktop-icon-link <?= $paginaActiva === 'inicio' ? 'active' : '' ?>">
                <?= self::svgDisquete() ?>
                <span>System Disk</span>
            </a>

            <a href="<?= htmlspecialchars($basePath) ?>ejercicios/ejercicio6.php" class="desktop-icon-link <?= $paginaActiva === 'ejercicio6' ? 'active' : '' ?>">
                <?= self::svgMacClasico() ?>
                <span>Árbol.app</span>
            </a>

            <a href="<?= htmlspecialchars($basePath) ?>ejercicios/ejercicio7.php" class="desktop-icon-link <?= $paginaActiva === 'ejercicio7' ? 'active' : '' ?>">
                <?= self::svgDocumento() ?>
                <span>Calc.txt</span>
            </a>

            <a href="<?= htmlspecialchars($basePath) ?>index.php" class="desktop-icon-link">
                <?= self::svgPapelera() ?>
                <span>Trash</span>
            </a>
        </aside>
    </div>
</body>
</html>
        <?php
    }

    /* Íconos Pixel Art en SVG */
    public static function svgCarpetaMac(string $colorCarpeta = '#9EB8D9'): string {
        return "
        <svg width='54' height='46' viewBox='0 0 27 23' shape-rendering='crispEdges'>
            <rect x='2' y='1' width='8' height='2' fill='#000'/>
            <rect x='1' y='3' width='25' height='18' fill='#000'/>
            <rect x='2' y='2' width='8' height='2' fill='{$colorCarpeta}'/>
            <rect x='2' y='4' width='23' height='16' fill='{$colorCarpeta}'/>
            <rect x='2' y='4' width='23' height='1' fill='#FFF'/>
            <!-- Carita Happy Mac dentro de la carpeta como en la Imagen 2 -->
            <rect x='8' y='7' width='11' height='10' fill='#FFF' stroke='#000' stroke-width='1'/>
            <rect x='13' y='7' width='5' height='9' fill='#B8D0EB'/>
            <rect x='10' y='9' width='1' height='2' fill='#000'/>
            <rect x='15' y='9' width='1' height='2' fill='#000'/>
            <rect x='13' y='10' width='1' height='3' fill='#000'/>
            <rect x='11' y='14' width='4' height='1' fill='#000'/>
        </svg>";
    }

    public static function svgDisquete(): string {
        return "
        <svg width='44' height='44' viewBox='0 0 22 22' shape-rendering='crispEdges'>
            <rect x='2' y='1' width='17' height='20' fill='#FFF' stroke='#000' stroke-width='1'/>
            <rect x='5' y='1' width='11' height='7' fill='#D0D0D0' stroke='#000' stroke-width='1'/>
            <rect x='12' y='2' width='2' height='5' fill='#000'/>
            <rect x='5' y='11' width='12' height='9' fill='#FFF' stroke='#000' stroke-width='1'/>
            <line x1='7' y1='14' x2='15' y2='14' stroke='#000' stroke-width='1'/>
            <line x1='7' y1='17' x2='15' y2='17' stroke='#000' stroke-width='1'/>
        </svg>";
    }

    public static function svgMacClasico(): string {
        return "
        <svg width='44' height='46' viewBox='0 0 22 23' shape-rendering='crispEdges'>
            <rect x='3' y='1' width='16' height='18' fill='#FFF' stroke='#000' stroke-width='1'/>
            <rect x='5' y='3' width='12' height='9' fill='#000'/>
            <rect x='6' y='4' width='10' height='7' fill='#FFF'/>
            <rect x='8' y='6' width='1' height='2' fill='#000'/>
            <rect x='13' y='6' width='1' height='2' fill='#000'/>
            <rect x='9' y='9' width='4' height='1' fill='#000'/>
            <rect x='12' y='15' width='5' height='1' fill='#000'/>
            <rect x='4' y='19' width='14' height='3' fill='#D0D0D0' stroke='#000' stroke-width='1'/>
        </svg>";
    }

    public static function svgDocumento(): string {
        return "
        <svg width='42' height='46' viewBox='0 0 21 23' shape-rendering='crispEdges'>
            <polygon points='2,1 14,1 19,6 19,22 2,22' fill='#FFF' stroke='#000' stroke-width='1'/>
            <polyline points='14,1 14,6 19,6' fill='none' stroke='#000' stroke-width='1'/>
            <line x1='5' y1='9' x2='16' y2='9' stroke='#000' stroke-width='1'/>
            <line x1='5' y1='12' x2='16' y2='12' stroke='#000' stroke-width='1'/>
            <line x1='5' y1='15' x2='16' y2='15' stroke='#000' stroke-width='1'/>
            <line x1='5' y1='18' x2='12' y2='18' stroke='#000' stroke-width='1'/>
        </svg>";
    }

    public static function svgPapelera(): string {
        return "
        <svg width='42' height='46' viewBox='0 0 21 23' shape-rendering='crispEdges'>
            <rect x='8' y='1' width='5' height='2' fill='#FFF' stroke='#000' stroke-width='1'/>
            <rect x='3' y='3' width='15' height='2' fill='#FFF' stroke='#000' stroke-width='1'/>
            <rect x='5' y='5' width='11' height='17' fill='#FFF' stroke='#000' stroke-width='1'/>
            <line x1='8' y1='7' x2='8' y2='20' stroke='#000' stroke-width='1'/>
            <line x1='10' y1='7' x2='10' y2='20' stroke='#000' stroke-width='1'/>
            <line x1='13' y1='7' x2='13' y2='20' stroke='#000' stroke-width='1'/>
        </svg>";
    }

    /**
     * Ilustración 1-bit estilo Scrapbook (Imagen 1) para la ventana derecha cuando aún no se ejecuta el cálculo.
     */
    public static function svgIlustracionScrapbook(string $titulo = 'Ready'): string {
        return "
        <div style='border:2px solid #000; background:#000; padding:4px;'>
            <svg width='100%' viewBox='0 0 260 150' shape-rendering='crispEdges' style='display:block; background:#111;'>
                <!-- Cielo nocturno punteado 1-bit -->
                <rect x='0' y='0' width='260' height='110' fill='#181818'/>
                <rect x='25' y='18' width='2' height='2' fill='#FFF'/>
                <rect x='62' y='12' width='2' height='2' fill='#FFF'/>
                <rect x='110' y='24' width='2' height='2' fill='#FFF'/>
                <rect x='155' y='14' width='2' height='2' fill='#FFF'/>
                <rect x='215' y='22' width='2' height='2' fill='#FFF'/>
                <rect x='235' y='40' width='2' height='2' fill='#FFF'/>
                <!-- Luna pixelada -->
                <rect x='205' y='25' width='18' height='18' fill='#FFF'/>
                <rect x='201' y='29' width='14' height='14' fill='#181818'/>
                <!-- Suelo nevado / tramado -->
                <rect x='0' y='110' width='260' height='40' fill='#FFF'/>
                <line x1='0' y1='110' x2='260' y2='110' stroke='#000' stroke-width='2'/>
                <!-- Cabaña pixelada estilo Imagen 1 -->
                <polygon points='125,75 165,50 205,75' fill='#FFF' stroke='#000' stroke-width='2'/>
                <rect x='132' y='75' width='66' height='35' fill='#FFF' stroke='#000' stroke-width='2'/>
                <rect x='145' y='88' width='14' height='22' fill='#000'/>
                <rect x='172' y='84' width='14' height='12' fill='#000'/>
                <rect x='174' y='86' width='10' height='8' fill='#FFF'/>
                <!-- Árbol seco -->
                <rect x='225' y='60' width='4' height='50' fill='#FFF'/>
                <line x1='227' y1='75' x2='212' y2='58' stroke='#FFF' stroke-width='2'/>
                <line x1='227' y1='68' x2='242' y2='52' stroke='#FFF' stroke-width='2'/>
                <!-- Silueta lobo/guardián 1-bit con ojos blancos -->
                <rect x='45' y='52' width='48' height='34' fill='#000' stroke='#FFF' stroke-width='1'/>
                <rect x='38' y='42' width='24' height='22' fill='#000' stroke='#FFF' stroke-width='1'/>
                <polygon points='40,42 44,32 48,42' fill='#000' stroke='#FFF' stroke-width='1'/>
                <polygon points='52,42 56,32 60,42' fill='#000' stroke='#FFF' stroke-width='1'/>
                <rect x='44' y='49' width='3' height='3' fill='#FFF'/>
                <rect x='53' y='49' width='3' height='3' fill='#FFF'/>
                <rect x='48' y='86' width='8' height='24' fill='#000' stroke='#FFF' stroke-width='1'/>
                <rect x='78' y='86' width='8' height='24' fill='#000' stroke='#FFF' stroke-width='1'/>
            </svg>
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
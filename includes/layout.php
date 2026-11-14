<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Layout {
    private static function getMenuItems(string $basePath): array {
        return [
            'inicio'     => ['label' => 'INICIO // HUB',          'url' => $basePath . 'index.php',                 'code' => '00'],
            'ejercicio1' => ['label' => '01. ACRÓNIMO',           'url' => $basePath . 'ejercicios/ejercicio1.php', 'code' => '01'],
            'ejercicio2' => ['label' => '02. FIBONACCI / FACT.',  'url' => $basePath . 'ejercicios/ejercicio2.php', 'code' => '02'],
            'ejercicio3' => ['label' => '03. ESTADÍSTICA',        'url' => $basePath . 'ejercicios/ejercicio3.php', 'code' => '03'],
            'ejercicio4' => ['label' => '04. CONJUNTOS',          'url' => $basePath . 'ejercicios/ejercicio4.php', 'code' => '04'],
            'ejercicio5' => ['label' => '05. BINARIO',            'url' => $basePath . 'ejercicios/ejercicio5.php', 'code' => '05'],
            'ejercicio6' => ['label' => '06. ÁRBOL BINARIO',      'url' => $basePath . 'ejercicios/ejercicio6.php', 'code' => '06'],
            'ejercicio7' => ['label' => '07. CALCULADORA',        'url' => $basePath . 'ejercicios/ejercicio7.php', 'code' => '07'],
        ];
    }

    public static function header(string $tituloPagina, string $subtitulo, string $paginaActiva, string $basePath = ''): void {
        $menuItems = self::getMenuItems($basePath);
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina) ?> | Taller PHP POO</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath) ?>css/style.css">
</head>
<body>
    <div class="watermark-bg">PHP<br>POO</div>
    <div class="app-shell">
        <!-- Menú Vertical Izquierdo -->
        <aside class="sidebar">
            <div class="brand-header">
                <div class="brand-emblem"></div>
                <div class="brand-bars">
                    <span></span>
                    <span></span>
                </div>
            </div>

            <ul class="tactical-nav">
                <?php foreach ($menuItems as $key => $item): ?>
                    <li>
                        <a href="<?= htmlspecialchars($item['url']) ?>" class="<?= $paginaActiva === $key ? 'active' : '' ?>">
                            <span class="nav-dash"></span>
                            <?= htmlspecialchars($item['label']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="sidebar-footer">
                <span>SISTEMA: PHP POO</span>
                <span class="status-dot"></span>
            </div>
        </aside>

        <!-- Área Principal -->
        <main class="main-content">
            <div>
                <header class="hero-header">
                    <div>
                        <div class="hero-kicker"><?= htmlspecialchars($subtitulo) ?></div>
                        <h1 class="hero-title"><?= htmlspecialchars($tituloPagina) ?></h1>
                        <div class="keybind-strip">
                            <?php foreach ($menuItems as $key => $item): ?>
                                <a href="<?= htmlspecialchars($item['url']) ?>" 
                                   class="key-box <?= $paginaActiva === $key ? 'active' : '' ?>" 
                                   title="<?= htmlspecialchars($item['label']) ?>">
                                    <?= htmlspecialchars($item['code']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="roster-badges" title="Módulos Activos">
                        <div class="roster-item">P1</div>
                        <div class="roster-item">O2</div>
                        <div class="roster-item">O3</div>
                    </div>
                </header>
        <?php
    }

    public static function footer(string $basePath = ''): void {
        ?>
            </div>
            <footer class="bottom-bar">
                <span>TALLER PRÁCTICO // ARQUITECTURA PHP ORIENTADA A OBJETOS</span>
                <a href="<?= htmlspecialchars($basePath) ?>index.php" class="btn-outline">VOLVER AL MENÚ</a>
            </footer>
        </main>
    </div>
</body>
</html>
        <?php
    }
}

function renderHeader(string $tituloPagina, string $subtitulo, string $paginaActiva, string $basePath = ''): void {
    Layout::header($tituloPagina, $subtitulo, $paginaActiva, $basePath);
}

function renderFooter(string $basePath = ''): void {
    Layout::footer($basePath);
}
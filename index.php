<?php
require_once __DIR__ . '/includes/layout.php';

class MenuPrincipal {
    private array $modulos;

    public function __construct() {
        $this->modulos = [
            [
                'num'    => '01',
                'tema'   => 'Scherzo!',
                'clase'  => 'theme-scherzo',
                'folder' => '#66B2A0',
                'titulo' => 'Acrónimo',
                'desc'   => 'Convierte frases largas y términos con guiones en su acrónimo oficial.',
                'link'   => 'ejercicios/ejercicio1.php'
            ],
            [
                'num'    => '02',
                'tema'   => 'Antique',
                'clase'  => 'theme-antique',
                'folder' => '#B87A56',
                'titulo' => 'Fibonacci / Fact.',
                'desc'   => 'Calcula la sucesión de Fibonacci o la serie factorial de un número N.',
                'link'   => 'ejercicios/ejercicio2.php'
            ],
            [
                'num'    => '03',
                'tema'   => 'Ice',
                'clase'  => 'theme-ice',
                'folder' => '#8FB8DE',
                'titulo' => 'Estadística',
                'desc'   => 'Calcula promedio, mediana y moda de N números reales ingresados.',
                'link'   => 'ejercicios/ejercicio3.php'
            ],
            [
                'num'    => '04',
                'tema'   => 'Onyx',
                'clase'  => 'theme-onyx',
                'folder' => '#E6C229',
                'titulo' => 'Conjuntos A y B',
                'desc'   => 'Determina unión, intersección y diferencias (A-B y B-A) de enteros.',
                'link'   => 'ejercicios/ejercicio4.php'
            ],
            [
                'num'    => '05',
                'tema'   => 'BeBox',
                'clase'  => 'theme-bebox',
                'folder' => '#F2B84B',
                'titulo' => 'Conversor Binario',
                'desc'   => 'Transforma cualquier número entero decimal a sistema binario.',
                'link'   => 'ejercicios/ejercicio5.php'
            ],
            [
                'num'    => '06',
                'tema'   => 'System 7',
                'clase'  => 'theme-system7',
                'folder' => '#B5C2E8',
                'titulo' => 'Árbol Binario',
                'desc'   => 'Construye y dibuja un árbol binario desde sus recorridos.',
                'link'   => 'ejercicios/ejercicio6.php'
            ],
            [
                'num'    => '07',
                'tema'   => 'Scrapbook',
                'clase'  => 'theme-scrapbook',
                'folder' => '#C8C8C8',
                'titulo' => 'Calculadora',
                'desc'   => 'Operaciones básicas, porcentaje e historial con botón de borrado.',
                'link'   => 'ejercicios/ejercicio7.php'
            ]
        ];
    }

    public function obtenerModulos(): array {
        return $this->modulos;
    }
}

$menu = new MenuPrincipal();
$ejercicios = $menu->obtenerModulos();

renderHeader('Menú Principal', 'inicio', '');
?>

<div class="kaleido-header-banner">
    <h1> TALLER PHP POO // SELECTOR DE MÓDULOS</h1>
    <span>Selecciona un ejercicio presionando <strong>OK</strong></span>
</div>

<div class="kaleido-grid">
    <?php foreach ($ejercicios as $ej): ?>
        <article class="kaleido-card <?= htmlspecialchars($ej['clase']) ?>">
            <!-- Barra superior de la ventana temática -->
            <div class="kaleido-titlebar">
                <span>Ejercicio <?= htmlspecialchars($ej['num']) ?> — <?= htmlspecialchars($ej['tema']) ?></span>
                <div class="kaleido-titlebar-boxes">
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="kaleido-body">
                <div class="kaleido-subtitle">
                    <span># <?= htmlspecialchars($ej['titulo']) ?></span>
                </div>

                <!-- Fotico de carpeta/archivo a la izquierda y descripción al ladito -->
                <div class="kaleido-content-row">
                    <div class="kaleido-folder-box">
                        <?= Layout::svgCarpetaMac($ej['folder']) ?>
                        <div class="kaleido-widgets-row">
                            <span class="pixel-radio"></span>
                            <span class="pixel-radio on"></span>
                            <span class="pixel-check">✓</span>
                        </div>
                    </div>

                    <p class="kaleido-desc">
                        <?= htmlspecialchars($ej['desc']) ?>
                    </p>
                </div>
            </div>

            <!-- Subventana superpuesta On / Off + Slider + Botón OK (Imagen 2) -->
            <div class="kaleido-subwin">
                <div class="kaleido-subwin-bar"></div>
                <div class="kaleido-tabs">
                    <span>On</span>
                    <span>Off</span>
                </div>
                <div class="kaleido-slider-box">
                    <div class="kaleido-slider-track">
                        <div class="kaleido-slider-fill"></div>
                    </div>
                    <a href="<?= htmlspecialchars($ej['link']) ?>" class="btn-kaleido-ok">OK</a>
                </div>
            </div>

            <!-- Barra inferior con flechas clásicas -->
            <div class="kaleido-bottom-scroll">
                <span>◀</span>
                <span>▶</span>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php
renderFooter('inicio', '');
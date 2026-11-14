<?php
require_once __DIR__ . '/includes/layout.php';

class MenuPrincipal {
    private array $modulos;

    public function __construct() {
        $this->modulos = [
            [
                'num'   => '01',
                'title' => 'Generador de Acrónimos',
                'desc'  => 'Convierte frases largas y términos separados por guiones en su acrónimo oficial eliminando signos de puntuación.',
                'link'  => 'ejercicios/ejercicio1.php'
            ],
            [
                'num'   => '02',
                'title' => 'Fibonacci y Factorial',
                'desc'  => 'Genera la sucesión de Fibonacci o la serie factorial a partir de un número entero ingresado.',
                'link'  => 'ejercicios/ejercicio2.php'
            ],
            [
                'num'   => '03',
                'title' => 'Estadística Descriptiva',
                'desc'  => 'Calcula el promedio, la mediana y la moda de una cantidad dinámica de números reales.',
                'link'  => 'ejercicios/ejercicio3.php'
            ],
            [
                'num'   => '04',
                'title' => 'Álgebra de Conjuntos',
                'desc'  => 'Calcula la unión, intersección y diferencias (A-B y B-A) entre dos conjuntos de números enteros.',
                'link'  => 'ejercicios/ejercicio4.php'
            ],
            [
                'num'   => '05',
                'title' => 'Conversor a Binario',
                'desc'  => 'Convierte cualquier número entero ingresado en su equivalente en sistema binario.',
                'link'  => 'ejercicios/ejercicio5.php'
            ],
            [
                'num'   => '06',
                'title' => 'Árbol Binario',
                'desc'  => 'Construye y grafica un árbol binario ingresando mínimo dos recorridos (preorden, inorden o postorden).',
                'link'  => 'ejercicios/ejercicio6.php'
            ],
            [
                'num'   => '07',
                'title' => 'Calculadora + Historial',
                'desc'  => 'Realiza suma, resta, multiplicación, división y porcentaje con enteros o decimales y permite borrar el historial.',
                'link'  => 'ejercicios/ejercicio7.php'
            ]
        ];
    }

    public function obtenerModulos(): array {
        return $this->modulos;
    }
}

$menu = new MenuPrincipal();
$ejercicios = $menu->obtenerModulos();

renderHeader('TALLER PHP', 'ARSENAL // PROGRAMACIÓN ORIENTADA A OBJETOS', 'inicio', '');
?>

<div class="cards-grid">
    <?php foreach ($ejercicios as $ej): ?>
        <article class="agent-card">
            <div>
                <div class="card-index"><?= htmlspecialchars($ej['num']) ?></div>
                <h2 class="card-title"><?= htmlspecialchars($ej['title']) ?></h2>
                <p class="card-desc"><?= htmlspecialchars($ej['desc']) ?></p>
            </div>
            <a href="<?= htmlspecialchars($ej['link']) ?>" class="btn-recruit">EJECUTAR MÓDULO</a>
        </article>
    <?php endforeach; ?>
</div>

<?php
renderFooter('');
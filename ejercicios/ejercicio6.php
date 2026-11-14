<?php
require_once __DIR__ . '/../includes/layout.php';

class NodoArbol {
    public string $valor;
    public ?NodoArbol $izquierda = null;
    public ?NodoArbol $derecha = null;

    public function __construct(string $valor) {
        $this->valor = $valor;
    }
}

class ArbolBinario {
    private ?NodoArbol $raiz = null;
    private string $metodoUsado = '';

    public function parsearRecorrido(string $cadena): array {
        $limpio = mb_strtoupper(trim($cadena), 'UTF-8');
        if ($limpio === '') {
            return [];
        }

        $normalizado = trim(preg_replace('/[\s,;|\-\/>→=]+/u', ' ', $limpio));

        if (strpos($normalizado, ' ') === false && mb_strlen($normalizado, 'UTF-8') > 1) {
            return preg_split('//u', $normalizado, -1, PREG_SPLIT_NO_EMPTY);
        }

        return preg_split('/\s+/u', $normalizado, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function construir(string $preStr, string $inStr, string $postStr): void {
        $pre  = $this->parsearRecorrido($preStr);
        $in   = $this->parsearRecorrido($inStr);
        $post = $this->parsearRecorrido($postStr);

        $ingresados = (!empty($pre) ? 1 : 0) + (!empty($in) ? 1 : 0) + (!empty($post) ? 1 : 0);
        if ($ingresados < 2) {
            throw new InvalidArgumentException("Debe ingresar mínimo dos recorridos para construir el árbol.");
        }

        if (!empty($pre) && !empty($in)) {
            $this->validarConsistencia($pre, $in);
            $this->metodoUsado = (!empty($post))
                ? "Preorden + Inorden (por defecto)"
                : "Preorden + Inorden";
            $this->raiz = $this->desdePreIn($pre, $in);
        } elseif (!empty($post) && !empty($in)) {
            $this->validarConsistencia($post, $in);
            $this->metodoUsado = "Postorden + Inorden";
            $this->raiz = $this->desdePostIn($post, $in);
        } else {
            $this->validarConsistencia($pre, $post);
            $this->metodoUsado = "Preorden + Postorden";
            $this->raiz = $this->desdePrePost($pre, $post);
        }
    }

    private function validarConsistencia(array $r1, array $r2): void {
        if (count($r1) !== count($r2)) {
            throw new InvalidArgumentException("Los recorridos ingresados tienen diferente cantidad de letras.");
        }
        if (count(array_unique($r1)) !== count($r1)) {
            throw new InvalidArgumentException("No repitas letras dentro del mismo recorrido.");
        }
        $s1 = $r1;
        $s2 = $r2;
        sort($s1);
        sort($s2);
        if ($s1 !== $s2) {
            throw new InvalidArgumentException("Los recorridos deben contener exactamente las mismas letras.");
        }
    }

    private function desdePreIn(array $pre, array $in): ?NodoArbol {
        if (empty($pre) || empty($in)) return null;

        $valorRaiz = $pre[0];
        $idx = array_search($valorRaiz, $in, true);
        if ($idx === false) {
            throw new InvalidArgumentException("La combinación de Preorden e Inorden no forma un árbol válido.");
        }

        $nodo = new NodoArbol($valorRaiz);
        $inIzq  = array_slice($in, 0, $idx);
        $inDer  = array_slice($in, $idx + 1);
        $preIzq = array_slice($pre, 1, count($inIzq));
        $preDer = array_slice($pre, 1 + count($inIzq));

        $nodo->izquierda = $this->desdePreIn($preIzq, $inIzq);
        $nodo->derecha   = $this->desdePreIn($preDer, $inDer);
        return $nodo;
    }

    private function desdePostIn(array $post, array $in): ?NodoArbol {
        if (empty($post) || empty($in)) return null;

        $valorRaiz = end($post);
        $idx = array_search($valorRaiz, $in, true);
        if ($idx === false) {
            throw new InvalidArgumentException("La combinación de Postorden e Inorden no forma un árbol válido.");
        }

        $nodo = new NodoArbol($valorRaiz);
        $inIzq   = array_slice($in, 0, $idx);
        $inDer   = array_slice($in, $idx + 1);
        $postIzq = array_slice($post, 0, count($inIzq));
        $postDer = array_slice($post, count($inIzq), count($inDer));

        $nodo->izquierda = $this->desdePostIn($postIzq, $inIzq);
        $nodo->derecha   = $this->desdePostIn($postDer, $inDer);
        return $nodo;
    }

    private function desdePrePost(array $pre, array $post): ?NodoArbol {
        if (empty($pre)) return null;

        $nodo = new NodoArbol($pre[0]);
        if (count($pre) === 1) return $nodo;

        $raizIzq = $pre[1];
        $idx = array_search($raizIzq, $post, true);
        if ($idx === false || $idx >= count($post) - 1) {
            throw new InvalidArgumentException("La combinación de Preorden y Postorden no forma un árbol válido.");
        }

        $tamIzq = $idx + 1;
        $preIzq  = array_slice($pre, 1, $tamIzq);
        $postIzq = array_slice($post, 0, $tamIzq);
        $preDer  = array_slice($pre, $tamIzq + 1);
        $postDer = array_slice($post, $tamIzq, -1);

        $this->validarConsistencia($preIzq, $postIzq);
        $this->validarConsistencia($preDer, $postDer);

        $nodo->izquierda = $this->desdePrePost($preIzq, $postIzq);
        $nodo->derecha   = $this->desdePrePost($preDer, $postDer);
        return $nodo;
    }

    public function getMetodoUsado(): string {
        return $this->metodoUsado;
    }

    public function obtenerRecorridosGenerados(): array {
        $pre = [];
        $in = [];
        $post = [];
        $this->recorrer($this->raiz, $pre, $in, $post);
        return [
            'preorden'  => implode(' → ', $pre),
            'inorden'   => implode(' → ', $in),
            'postorden' => implode(' → ', $post),
        ];
    }

    private function recorrer(?NodoArbol $nodo, array &$pre, array &$in, array &$post): void {
        if (!$nodo) return;
        $pre[] = $nodo->valor;
        $this->recorrer($nodo->izquierda, $pre, $in, $post);
        $in[] = $nodo->valor;
        $this->recorrer($nodo->derecha, $pre, $in, $post);
        $post[] = $nodo->valor;
    }

    public function renderizarSVG(): string {
        if (!$this->raiz) return '';

        $totalNodos = $this->contarNodos($this->raiz);
        $altura     = $this->obtenerAltura($this->raiz);

        $pasoX   = 65;
        $pasoY   = 80;
        $margenX = 45;
        $margenY = 45;

        $anchoSVG = max(420, $totalNodos * $pasoX + $margenX * 2);
        $altoSVG  = max(220, $altura * $pasoY + $margenY);

        $coords = [];
        $columnaActual = 0;
        $this->calcularCoordenadas($this->raiz, 0, $columnaActual, $pasoX, $pasoY, $margenX, $margenY, $coords);

        $lineas = '';
        $nodos  = '';
        $this->generarElementosSVG($this->raiz, $coords, $lineas, $nodos);

        return "<svg width='100%' viewBox='0 0 {$anchoSVG} {$altoSVG}' style='max-height:380px; background:#FFFFFF; border:2px solid #000000;'>
                    {$lineas}
                    {$nodos}
                </svg>";
    }

    private function contarNodos(?NodoArbol $nodo): int {
        if (!$nodo) return 0;
        return 1 + $this->contarNodos($nodo->izquierda) + $this->contarNodos($nodo->derecha);
    }

    private function obtenerAltura(?NodoArbol $nodo): int {
        if (!$nodo) return 0;
        return 1 + max($this->obtenerAltura($nodo->izquierda), $this->obtenerAltura($nodo->derecha));
    }

    private function calcularCoordenadas(
        ?NodoArbol $nodo,
        int $profundidad,
        int &$columnaActual,
        int $pasoX,
        int $pasoY,
        int $margenX,
        int $margenY,
        array &$coords
    ): void {
        if (!$nodo) return;

        $this->calcularCoordenadas($nodo->izquierda, $profundidad + 1, $columnaActual, $pasoX, $pasoY, $margenX, $margenY, $coords);

        $coords[$nodo->valor] = [
            'x' => $margenX + ($columnaActual * $pasoX) + ($pasoX / 2),
            'y' => $margenY + ($profundidad * $pasoY),
        ];
        $columnaActual++;

        $this->calcularCoordenadas($nodo->derecha, $profundidad + 1, $columnaActual, $pasoX, $pasoY, $margenX, $margenY, $coords);
    }

    private function generarElementosSVG(?NodoArbol $nodo, array $coords, string &$lineas, string &$nodos): void {
        if (!$nodo) return;

        $x = $coords[$nodo->valor]['x'];
        $y = $coords[$nodo->valor]['y'];

        if ($nodo->izquierda) {
            $izqX = $coords[$nodo->izquierda->valor]['x'];
            $izqY = $coords[$nodo->izquierda->valor]['y'];
            $lineas .= "<line x1='{$x}' y1='{$y}' x2='{$izqX}' y2='{$izqY}' stroke='#000000' stroke-width='2.5'/>";
            $this->generarElementosSVG($nodo->izquierda, $coords, $lineas, $nodos);
        }

        if ($nodo->derecha) {
            $derX = $coords[$nodo->derecha->valor]['x'];
            $derY = $coords[$nodo->derecha->valor]['y'];
            $lineas .= "<line x1='{$x}' y1='{$y}' x2='{$derX}' y2='{$derY}' stroke='#000000' stroke-width='2.5'/>";
            $this->generarElementosSVG($nodo->derecha, $coords, $lineas, $nodos);
        }

        $val = htmlspecialchars($nodo->valor);
        $nodos .= "
            <rect x='" . ($x - 19) . "' y='" . ($y - 19) . "' width='38' height='38' fill='#FFFFFF' stroke='#000000' stroke-width='2.5'/>
            <text x='{$x}' y='" . ($y + 6) . "' fill='#000000' font-family='Silkscreen, monospace' font-weight='bold' font-size='15' text-anchor='middle'>{$val}</text>
        ";
    }
}

$preorden   = $_POST['preorden'] ?? '';
$inorden    = $_POST['inorden'] ?? '';
$postorden  = $_POST['postorden'] ?? '';
$svgArbol   = null;
$metodo     = null;
$recorridos = null;
$error      = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $arbol = new ArbolBinario();
        $arbol->construir($preorden, $inorden, $postorden);
        $svgArbol   = $arbol->renderizarSVG();
        $metodo     = $arbol->getMetodoUsado();
        $recorridos = $arbol->obtenerRecorridosGenerados();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

renderHeader('06. Árbol Binario', 'ejercicio6', '../');
?>

<div class="mac-workspace-grid">
    <!-- Ventana Izquierda: Formulario de Recorridos -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Ejercicio 06 — Árbol Binario</span>
        </div>

        <div class="mac-window-body">
            <form method="POST">
                <div class="mac-form-group">
                    <label for="preorden">Recorrido Preorden:</label>
                    <input type="text" id="preorden" name="preorden" class="mac-input"
                           value="<?= htmlspecialchars($preorden) ?>" placeholder="Ej: M, K, X, Z, P">
                </div>

                <div class="mac-form-group">
                    <label for="inorden">Recorrido Inorden:</label>
                    <input type="text" id="inorden" name="inorden" class="mac-input"
                           value="<?= htmlspecialchars($inorden) ?>" placeholder="Ej: X, K, Z, M, P">
                </div>

                <div class="mac-form-group">
                    <label for="postorden">Recorrido Postorden:</label>
                    <input type="text" id="postorden" name="postorden" class="mac-input"
                           value="<?= htmlspecialchars($postorden) ?>" placeholder="Ej: X, Z, K, P, M">
                </div>

                <div class="mac-btn-group">
                    <button type="submit" class="mac-btn-primary">OK</button>
                    <button type="button" id="btn-otro-ejemplo" class="mac-btn-secondary" onclick="cargarEjemploPersonalizado()">Ejemplo otras letras</button>
                    <button type="button" class="mac-btn-secondary" onclick="cargarEjemploTaller()">Ejemplo (A-E)</button>
                </div>
            </form>

            <?php if ($error): ?>
                <div class="mac-alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">6 of 7</span>
            <span>MÍNIMO 2 RECORRIDOS</span>
            <span>TREE</span>
        </div>
    </section>

    <!-- Ventana Derecha: Scrapbook con el Árbol Generado -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Scrapbook — Árbol PICT</span>
        </div>

        <div class="mac-window-body">
            <?php if ($svgArbol): ?>
                <p style="margin-bottom:6px;"><strong>Método:</strong> <?= htmlspecialchars($metodo) ?></p>
                <p style="margin-bottom:10px; font-size:1.05rem;">
                    <strong>Pre:</strong> <?= htmlspecialchars($recorridos['preorden']) ?> |
                    <strong>In:</strong> <?= htmlspecialchars($recorridos['inorden']) ?> |
                    <strong>Post:</strong> <?= htmlspecialchars($recorridos['postorden']) ?>
                </p>
                <?= $svgArbol ?>
            <?php else: ?>
                <?= Layout::svgIlustracionScrapbook('Árbol Binario') ?>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">OUT</span>
            <span>ÁRBOL BINARIO</span>
            <span>PICT</span>
        </div>
    </section>
</div>

<script>
const ejemplosPersonalizados = [
    {
        pre:  'M, K, X, Z, P',
        ino:  'X, K, Z, M, P',
        post: 'X, Z, K, P, M'
    },
    {
        pre:  'R, G, T, W, L, Q',
        ino:  'T, G, W, R, Q, L',
        post: 'T, W, G, Q, L, R'
    },
    {
        pre:  'H, F, N, S, Y, J, V',
        ino:  'N, F, S, H, J, Y, V',
        post: 'N, S, F, J, V, Y, H'
    },
    {
        pre:  'Z, P, D, U, K, M',
        ino:  'P, U, D, Z, K, M',
        post: 'U, D, P, M, K, Z'
    }
];

let indiceEjemplo = 0;

function cargarEjemploPersonalizado() {
    const actualPre = document.getElementById('preorden').value.trim().toUpperCase();
    const idxActual = ejemplosPersonalizados.findIndex(e => e.pre.toUpperCase() === actualPre);

    if (idxActual !== -1) {
        indiceEjemplo = (idxActual + 1) % ejemplosPersonalizados.length;
    }

    const ejemplo = ejemplosPersonalizados[indiceEjemplo];
    document.getElementById('preorden').value  = ejemplo.pre;
    document.getElementById('inorden').value   = ejemplo.ino;
    document.getElementById('postorden').value = ejemplo.post;

    const btn = document.getElementById('btn-otro-ejemplo');
    btn.textContent = `Ejemplo otras letras (${indiceEjemplo + 1}/${ejemplosPersonalizados.length})`;

    indiceEjemplo = (indiceEjemplo + 1) % ejemplosPersonalizados.length;
}

function cargarEjemploTaller() {
    document.getElementById('preorden').value  = 'A -> B -> D -> E -> C';
    document.getElementById('inorden').value   = 'D -> B -> E -> A -> C';
    document.getElementById('postorden').value = 'D -> E -> B -> C -> A';
    document.getElementById('btn-otro-ejemplo').textContent = 'Ejemplo otras letras';
}
</script>

<?php renderFooter('ejercicio6', '../'); ?>
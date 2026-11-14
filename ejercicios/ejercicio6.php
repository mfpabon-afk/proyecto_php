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
        return preg_split('/[\s,\->→]+/u', trim($cadena), -1, PREG_SPLIT_NO_EMPTY);
    }

    public function construir(string $preStr, string $inStr, string $postStr): void {
        $pre  = $this->parsearRecorrido($preStr);
        $in   = $this->parsearRecorrido($inStr);
        $post = $this->parsearRecorrido($postStr);

        $ingresados = (!empty($pre) ? 1 : 0) + (!empty($in) ? 1 : 0) + (!empty($post) ? 1 : 0);
        if ($ingresados < 2) {
            throw new InvalidArgumentException("Debe ingresar mínimo dos recorridos para construir el árbol.");
        }

        // Si se ingresan los tres a la vez, por defecto se calcula con Preorden - Inorden
        if (!empty($pre) && !empty($in)) {
            $this->validarConsistencia($pre, $in);
            $this->metodoUsado = (!empty($post))
                ? "Preorden + Inorden (priorizado por defecto al ingresar los tres recorridos)"
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
            throw new InvalidArgumentException("Los recorridos ingresados tienen diferente cantidad de nodos.");
        }
        if (count(array_unique($r1)) !== count($r1)) {
            throw new InvalidArgumentException("Los nodos del árbol no deben tener valores duplicados.");
        }
        $s1 = $r1; $s2 = $r2;
        sort($s1); sort($s2);
        if ($s1 !== $s2) {
            throw new InvalidArgumentException("Los recorridos no contienen exactamente los mismos nodos.");
        }
    }

    private function desdePreIn(array $pre, array $in): ?NodoArbol {
        if (empty($pre) || empty($in)) return null;

        $valorRaiz = $pre[0];
        $nodo = new NodoArbol($valorRaiz);
        $idx = array_search($valorRaiz, $in, true);

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
        $nodo = new NodoArbol($valorRaiz);
        $idx = array_search($valorRaiz, $in, true);

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
        $tamIzq = $idx + 1;

        $nodo->izquierda = $this->desdePrePost(
            array_slice($pre, 1, $tamIzq),
            array_slice($post, 0, $tamIzq)
        );
        $nodo->derecha = $this->desdePrePost(
            array_slice($pre, $tamIzq + 1),
            array_slice($post, $tamIzq, -1)
        );
        return $nodo;
    }

    public function getMetodoUsado(): string {
        return $this->metodoUsado;
    }

    public function renderizarSVG(): string {
        if (!$this->raiz) return '';

        $altura = $this->obtenerAltura($this->raiz);
        $anchoSVG = max(500, pow(2, $altura) * 65);
        $altoSVG  = $altura * 95 + 40;

        $lineas = '';
        $nodos  = '';
        $this->dibujarNodo($this->raiz, $anchoSVG / 2, 45, $anchoSVG / 4, $lineas, $nodos);

        return "<svg width='100%' viewBox='0 0 {$anchoSVG} {$altoSVG}' style='max-height:420px; background:#15202B; border:1px solid #FF4655;'>
                    {$lineas}
                    {$nodos}
                </svg>";
    }

    private function obtenerAltura(?NodoArbol $nodo): int {
        if (!$nodo) return 0;
        return 1 + max($this->obtenerAltura($nodo->izquierda), $this->obtenerAltura($nodo->derecha));
    }

    private function dibujarNodo(?NodoArbol $nodo, float $x, float $y, float $offset, string &$lineas, string &$nodos): void {
        if (!$nodo) return;

        $sigY = $y + 85;
        if ($nodo->izquierda) {
            $izqX = $x - $offset;
            $lineas .= "<line x1='{$x}' y1='{$y}' x2='{$izqX}' y2='{$sigY}' stroke='#FF4655' stroke-width='2.5'/>";
            $this->dibujarNodo($nodo->izquierda, $izqX, $sigY, $offset / 2, $lineas, $nodos);
        }
        if ($nodo->derecha) {
            $derX = $x + $offset;
            $lineas .= "<line x1='{$x}' y1='{$y}' x2='{$derX}' y2='{$sigY}' stroke='#FF4655' stroke-width='2.5'/>";
            $this->dibujarNodo($nodo->derecha, $derX, $sigY, $offset / 2, $lineas, $nodos);
        }

        $val = htmlspecialchars($nodo->valor);
        $nodos .= "
            <circle cx='{$x}' cy='{$y}' r='21' fill='#0F1923' stroke='#FF4655' stroke-width='2.5'/>
            <text x='{$x}' y='" . ($y + 5) . "' fill='#FFFFFF' font-family='Rajdhani, sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>{$val}</text>
        ";
    }
}

$preorden  = $_POST['preorden'] ?? '';
$inorden   = $_POST['inorden'] ?? '';
$postorden = $_POST['postorden'] ?? '';
$svgArbol  = null;
$metodo    = null;
$error     = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $arbol = new ArbolBinario();
        $arbol->construir($preorden, $inorden, $postorden);
        $svgArbol = $arbol->renderizarSVG();
        $metodo   = $arbol->getMetodoUsado();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

renderHeader('06. ÁRBOL BINARIO', 'MÓDULO 06 // ESTRUCTURAS DE DATOS NO LINEALES', 'ejercicio6', '../');
?>

<section class="work-panel">
    <h2 class="section-label">Reconstrucción de Árbol Binario (Mínimo 2 Recorridos)</h2>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label for="preorden">Recorrido Preorden:</label>
                <input type="text" id="preorden" name="preorden" class="form-control" 
                       value="<?= htmlspecialchars($preorden) ?>" placeholder="Ej: A -> B -> D -> E -> C">
            </div>
            <div class="form-group">
                <label for="inorden">Recorrido Inorden:</label>
                <input type="text" id="inorden" name="inorden" class="form-control" 
                       value="<?= htmlspecialchars($inorden) ?>" placeholder="Ej: D -> B -> E -> A -> C">
            </div>
            <div class="form-group">
                <label for="postorden">Recorrido Postorden:</label>
                <input type="text" id="postorden" name="postorden" class="form-control" 
                       value="<?= htmlspecialchars($postorden) ?>" placeholder="Ej: D -> E -> B -> C -> A">
            </div>
        </div>
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
            <button type="submit" class="btn-recruit">CONSTRUIR ÁRBOL</button>
            <button type="button" class="btn-outline" onclick="cargarEjemplo()">CARGAR EJEMPLO DEL TALLER</button>
        </div>
    </form>

    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($svgArbol): ?>
        <div class="result-box">
            <h3>Árbol Binario Generado</h3>
            <p style="margin-bottom:14px;"><strong>Método aplicado:</strong> <?= htmlspecialchars($metodo) ?></p>
            <?= $svgArbol ?>
        </div>
    <?php endif; ?>
</section>

<script>
function cargarEjemplo() {
    document.getElementById('preorden').value  = 'A -> B -> D -> E -> C';
    document.getElementById('inorden').value   = 'D -> B -> E -> A -> C';
    document.getElementById('postorden').value = 'D -> E -> B -> C -> A';
}
</script>

<?php renderFooter('../'); ?>

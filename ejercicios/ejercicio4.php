<?php
require_once __DIR__ . '/../includes/layout.php';

class Conjuntos {
    /** @var int[] */
    private array $conjuntoA;
    /** @var int[] */
    private array $conjuntoB;

    public function __construct(string $entradaA, string $entradaB) {
        $this->conjuntoA = $this->parsearConjunto($entradaA);
        $this->conjuntoB = $this->parsearConjunto($entradaB);
    }

    private function parsearConjunto(string $cadena): array {
        $partes = preg_split('/[\s,;]+/', trim($cadena), -1, PREG_SPLIT_NO_EMPTY);
        $enteros = [];
        foreach ($partes as $parte) {
            if (!is_numeric($parte) || intval($parte) != $parte) {
                throw new InvalidArgumentException("El valor '{$parte}' no es un número entero válido.");
            }
            $enteros[] = intval($parte);
        }
        $unicos = array_values(array_unique($enteros));
        sort($unicos, SORT_NUMERIC);
        return $unicos;
    }

    public function getA(): array { return $this->conjuntoA; }
    public function getB(): array { return $this->conjuntoB; }

    public function union(): array {
        $res = array_values(array_unique(array_merge($this->conjuntoA, $this->conjuntoB)));
        sort($res, SORT_NUMERIC);
        return $res;
    }

    public function interseccion(): array {
        return array_values(array_intersect($this->conjuntoA, $this->conjuntoB));
    }

    public function diferenciaAB(): array {
        return array_values(array_diff($this->conjuntoA, $this->conjuntoB));
    }

    public function diferenciaBA(): array {
        return array_values(array_diff($this->conjuntoB, $this->conjuntoA));
    }
}

$entradaA = $_POST['conjunto_a'] ?? '';
$entradaB = $_POST['conjunto_b'] ?? '';
$res = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conjuntos = new Conjuntos($entradaA, $entradaB);
        $res = [
            'A'            => $conjuntos->getA(),
            'B'            => $conjuntos->getB(),
            'union'        => $conjuntos->union(),
            'interseccion' => $conjuntos->interseccion(),
            'difAB'        => $conjuntos->diferenciaAB(),
            'difBA'        => $conjuntos->diferenciaBA(),
        ];
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$formatear = fn(array $arr) => '{ ' . implode(', ', $arr) . ' }';

renderHeader('04. CONJUNTOS', 'MÓDULO 04 // TEORÍA DE CONJUNTOS', 'ejercicio4', '../');
?>

<section class="work-panel">
    <h2 class="section-label">Operaciones entre Conjuntos A y B</h2>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label for="conjunto_a">Conjunto A (enteros separados por coma o espacio):</label>
                <input type="text" id="conjunto_a" name="conjunto_a" class="form-control" 
                       value="<?= htmlspecialchars($entradaA) ?>" placeholder="Ej: 1, 2, 3, 4, 5" required>
            </div>
            <div class="form-group">
                <label for="conjunto_b">Conjunto B (enteros separados por coma o espacio):</label>
                <input type="text" id="conjunto_b" name="conjunto_b" class="form-control" 
                       value="<?= htmlspecialchars($entradaB) ?>" placeholder="Ej: 4, 5, 6, 7, 8" required>
            </div>
        </div>
        <button type="submit" class="btn-recruit">CALCULAR OPERACIONES</button>
    </form>

    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($res): ?>
        <div class="result-box">
            <h3>Resultados de Conjuntos</h3>
            <p><strong>Conjunto A:</strong> <?= $formatear($res['A']) ?></p>
            <p><strong>Conjunto B:</strong> <?= $formatear($res['B']) ?></p>
            <hr style="border-color: rgba(255,255,255,0.15); margin: 12px 0;">
            <p><strong>Unión (A ∪ B):</strong> <?= $formatear($res['union']) ?></p>
            <p><strong>Intersección (A ∩ B):</strong> <?= $formatear($res['interseccion']) ?></p>
            <p><strong>Diferencia (A - B):</strong> <?= $formatear($res['difAB']) ?></p>
            <p><strong>Diferencia (B - A):</strong> <?= $formatear($res['difBA']) ?></p>
        </div>
    <?php endif; ?>
</section>

<?php renderFooter('../'); ?>

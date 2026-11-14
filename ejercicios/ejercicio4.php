<?php
require_once __DIR__ . '/../includes/layout.php';

class Conjuntos {
    private array $conjuntoA;
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
                throw new InvalidArgumentException("El valor '{$parte}' no es un entero válido.");
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

renderHeader('04. Conjuntos', 'ejercicio4', '../');
?>

<div class="mac-workspace-grid">
    <!-- Ventana Izquierda -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Ejercicio 04 — Conjuntos</span>
        </div>

        <div class="mac-window-body">
            <form method="POST">
                <div class="mac-form-group">
                    <label for="conjunto_a">Conjunto A (enteros):</label>
                    <input type="text" id="conjunto_a" name="conjunto_a" class="mac-input"
                           value="<?= htmlspecialchars($entradaA) ?>" placeholder="Ej: 1, 2, 3, 4" required>
                </div>

                <div class="mac-form-group">
                    <label for="conjunto_b">Conjunto B (enteros):</label>
                    <input type="text" id="conjunto_b" name="conjunto_b" class="mac-input"
                           value="<?= htmlspecialchars($entradaB) ?>" placeholder="Ej: 3, 4, 5, 6" required>
                </div>

                <div class="mac-btn-group">
                    <button type="submit" class="mac-btn-primary">OK</button>
                    <a href="../index.php" class="mac-btn-secondary">Menú</a>
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
            <span class="mac-status-counter">4 of 7</span>
            <span>TEORÍA DE CONJUNTOS</span>
            <span>SETS</span>
        </div>
    </section>

    <!-- Ventana Derecha -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Scrapbook — Operaciones</span>
        </div>

        <div class="mac-window-body">
            <?php if ($res): ?>
                <div class="mac-output-frame">
                    <p><strong>A:</strong> <?= $formatear($res['A']) ?> &nbsp;|&nbsp; <strong>B:</strong> <?= $formatear($res['B']) ?></p>
                    <div class="mac-output-big" style="font-size:1.1rem;">
                        Unión (A ∪ B): <?= $formatear($res['union']) ?><br><br>
                        Intersección (A ∩ B): <?= $formatear($res['interseccion']) ?><br><br>
                        Diferencia (A - B): <?= $formatear($res['difAB']) ?><br><br>
                        Diferencia (B - A): <?= $formatear($res['difBA']) ?>
                    </div>
                </div>
            <?php else: ?>
                <?= Layout::svgIlustracionScrapbook('Conjuntos A y B') ?>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">OUT</span>
            <span>UNIÓN / INTERSECCIÓN / DIF.</span>
            <span>PICT</span>
        </div>
    </section>
</div>

<?php renderFooter('ejercicio4', '../'); ?>
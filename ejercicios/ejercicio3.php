<?php
require_once __DIR__ . '/../includes/layout.php';

class Estadistica {
    private array $numeros;

    public function __construct(array $numeros) {
        if (empty($numeros)) {
            throw new InvalidArgumentException("Debe ingresar al menos un número real.");
        }
        $this->numeros = array_map('floatval', $numeros);
    }

    public function calcularPromedio(): float {
        return array_sum($this->numeros) / count($this->numeros);
    }

    public function calcularMediana(): float {
        $ordenados = $this->numeros;
        sort($ordenados, SORT_NUMERIC);
        $n = count($ordenados);
        $mitad = intdiv($n, 2);

        return ($n % 2 === 0)
            ? ($ordenados[$mitad - 1] + $ordenados[$mitad]) / 2
            : $ordenados[$mitad];
    }

    public function calcularModa(): string {
        $frecuencias = [];
        foreach ($this->numeros as $num) {
            $clave = (string)$num;
            $frecuencias[$clave] = ($frecuencias[$clave] ?? 0) + 1;
        }

        $maxFrecuencia = max($frecuencias);
        if ($maxFrecuencia === 1 && count($this->numeros) > 1) {
            return "Sin moda";
        }

        $modas = [];
        foreach ($frecuencias as $valor => $frecuencia) {
            if ($frecuencia === $maxFrecuencia) {
                $modas[] = $valor;
            }
        }
        return implode(', ', $modas) . " (rep: {$maxFrecuencia})";
    }
}

$cantidad = isset($_POST['cantidad']) ? max(1, min(50, intval($_POST['cantidad']))) : 4;
$valoresIngresados = $_POST['numeros'] ?? [];
$resultados = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcular'])) {
    try {
        $estadistica = new Estadistica($valoresIngresados);
        $resultados = [
            'promedio' => $estadistica->calcularPromedio(),
            'mediana'  => $estadistica->calcularMediana(),
            'moda'     => $estadistica->calcularModa(),
        ];
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

renderHeader('03. Estadística', 'ejercicio3', '../');
?>

<div class="mac-workspace-grid">
    <!-- Ventana Izquierda -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Ejercicio 03 — Estadística</span>
        </div>

        <div class="mac-window-body">
            <form method="POST" style="display:flex; gap:10px; align-items:flex-end; margin-bottom:16px; border-bottom:2px dashed #000; padding-bottom:14px;">
                <div class="mac-form-group" style="margin-bottom:0; flex:1;">
                    <label for="cantidad">Cantidad de números (N):</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" max="50" class="mac-input" value="<?= $cantidad ?>" required>
                </div>
                <button type="submit" name="generar_campos" class="mac-btn-secondary">Actualizar</button>
            </form>

            <form method="POST">
                <input type="hidden" name="cantidad" value="<?= $cantidad ?>">
                <div class="mac-form-grid">
                    <?php for ($i = 0; $i < $cantidad; $i++): ?>
                        <div class="mac-form-group" style="margin-bottom:6px;">
                            <label>Valor #<?= $i + 1 ?>:</label>
                            <input type="number" step="any" name="numeros[]" class="mac-input"
                                   value="<?= htmlspecialchars($valoresIngresados[$i] ?? '') ?>" required>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="mac-btn-group">
                    <button type="submit" name="calcular" class="mac-btn-primary">OK</button>
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
            <span class="mac-status-counter">3 of 7</span>
            <span>NÚMEROS REALES</span>
            <span>STAT</span>
        </div>
    </section>

    <!-- Ventana Derecha -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Scrapbook — Medidas</span>
        </div>

        <div class="mac-window-body">
            <?php if ($resultados): ?>
                <div class="mac-output-frame">
                    <p><strong>Promedio:</strong></p>
                    <div class="mac-output-big"><?= round($resultados['promedio'], 4) ?></div>

                    <p><strong>Mediana:</strong></p>
                    <div class="mac-output-big"><?= round($resultados['mediana'], 4) ?></div>

                    <p><strong>Moda:</strong></p>
                    <div class="mac-output-big" style="font-size:1.2rem;"><?= htmlspecialchars($resultados['moda']) ?></div>
                </div>
            <?php else: ?>
                <?= Layout::svgIlustracionScrapbook('Estadística') ?>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">OUT</span>
            <span>PROMEDIO / MEDIANA / MODA</span>
            <span>PICT</span>
        </div>
    </section>
</div>

<?php renderFooter('ejercicio3', '../'); ?>
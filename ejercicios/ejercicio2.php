<?php
require_once __DIR__ . '/../includes/layout.php';

class Secuencias {
    private int $numero;

    public function __construct(int $numero) {
        if ($numero < 0) {
            throw new InvalidArgumentException("El número debe ser mayor o igual a 0.");
        }
        $this->numero = $numero;
    }

    public function calcularFibonacci(): array {
        if ($this->numero === 0) return [];
        if ($this->numero === 1) return [0];

        $serie = [0, 1];
        for ($i = 2; $i < $this->numero; $i++) {
            $serie[] = $serie[$i - 1] + $serie[$i - 2];
        }
        return $serie;
    }

    public function calcularFactorialSerie(): array {
        if ($this->numero === 0) return ['0! = 1'];

        $serie = [];
        $acumulado = 1;
        for ($i = 1; $i <= $this->numero; $i++) {
            $acumulado *= $i;
            $serie[] = "{$i}! = {$acumulado}";
        }
        return $serie;
    }
}

$serie = null;
$error = null;
$numero = $_POST['numero'] ?? '';
$operacion = $_POST['operacion'] ?? 'fibonacci';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $numero !== '') {
    try {
        $secuencia = new Secuencias(intval($numero));
        $serie = ($operacion === 'fibonacci')
            ? $secuencia->calcularFibonacci()
            : $secuencia->calcularFactorialSerie();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

renderHeader('02. Fibonacci / Factorial', 'ejercicio2', '../');
?>

<div class="mac-workspace-grid">
    <!-- Ventana Izquierda -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Ejercicio 02 — Sucesiones</span>
        </div>

        <div class="mac-window-body">
            <form method="POST">
                <div class="mac-form-group">
                    <label for="numero">Número entero (N):</label>
                    <input type="number" id="numero" name="numero" min="0" max="50" class="mac-input"
                           value="<?= htmlspecialchars($numero) ?>" required>
                </div>

                <div class="mac-form-group">
                    <label for="operacion">Operación:</label>
                    <select id="operacion" name="operacion" class="mac-input">
                        <option value="fibonacci" <?= $operacion === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci</option>
                        <option value="factorial" <?= $operacion === 'factorial' ? 'selected' : '' ?>>Factorial (1! hasta N!)</option>
                    </select>
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
            <span class="mac-status-counter">2 of 7</span>
            <span>FIBONACCI / FACTORIAL</span>
            <span>MATH</span>
        </div>
    </section>

    <!-- Ventana Derecha -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Scrapbook — Serie</span>
        </div>

        <div class="mac-window-body">
            <?php if ($serie !== null): ?>
                <div class="mac-output-frame">
                    <p><strong>Operación:</strong> <?= strtoupper(htmlspecialchars($operacion)) ?></p>
                    <div class="mac-output-big" style="font-size:1.15rem;">
                        <?= empty($serie) ? 'Sin elementos (N = 0)' : htmlspecialchars(implode(', ', $serie)) ?>
                    </div>
                </div>
            <?php else: ?>
                <?= Layout::svgIlustracionScrapbook('Sucesión') ?>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">OUT</span>
            <span>SERIE CALCULADA</span>
            <span>PICT</span>
        </div>
    </section>
</div>

<?php renderFooter('ejercicio2', '../'); ?>
<?php
require_once __DIR__ . '/../includes/layout.php';

class ConversorBinario {
    private int $numero;

    public function __construct(int $numero) {
        $this->numero = $numero;
    }

    public function convertir(): array {
        if ($this->numero === 0) {
            return [
                'binario' => '0',
                'pasos'   => ['0 ÷ 2 = 0 (Residuo: 0)']
            ];
        }

        $esNegativo = $this->numero < 0;
        $valor = abs($this->numero);
        $binario = '';
        $pasos = [];

        while ($valor > 0) {
            $residuo = $valor % 2;
            $cociente = intdiv($valor, 2);
            $pasos[] = "{$valor} ÷ 2 = {$cociente} (Res: {$residuo})";
            $binario = $residuo . $binario;
            $valor = $cociente;
        }

        if ($esNegativo) {
            $binario = '-' . $binario;
        }

        return [
            'binario' => $binario,
            'pasos'   => $pasos
        ];
    }
}

$numero = $_POST['numero'] ?? '';
$conversion = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $numero !== '') {
    $conversor = new ConversorBinario(intval($numero));
    $conversion = $conversor->convertir();
}

renderHeader('05. Binario', 'ejercicio5', '../');
?>

<div class="mac-workspace-grid">
    <!-- Ventana Izquierda -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Ejercicio 05 — Binario</span>
        </div>

        <div class="mac-window-body">
            <form method="POST">
                <div class="mac-form-group">
                    <label for="numero">Número entero decimal:</label>
                    <input type="number" id="numero" name="numero" class="mac-input"
                           value="<?= htmlspecialchars($numero) ?>" placeholder="Ej: 42" required>
                </div>

                <div class="mac-btn-group">
                    <button type="submit" class="mac-btn-primary">OK</button>
                    <a href="../index.php" class="mac-btn-secondary">Menú</a>
                </div>
            </form>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">5 of 7</span>
            <span>BASE 10 → BASE 2</span>
            <span>BIN</span>
        </div>
    </section>

    <!-- Ventana Derecha -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Scrapbook — Binario</span>
        </div>

        <div class="mac-window-body">
            <?php if ($conversion !== null): ?>
                <div class="mac-output-frame">
                    <p><strong>Decimal:</strong> <?= htmlspecialchars($numero) ?></p>
                    <div class="mac-output-big"><?= htmlspecialchars($conversion['binario']) ?></div>
                    <p><strong>Divisiones sucesivas:</strong></p>
                    <ul style="margin-left:20px; margin-top:4px;">
                        <?php foreach ($conversion['pasos'] as $paso): ?>
                            <li><?= htmlspecialchars($paso) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <?= Layout::svgIlustracionScrapbook('Binario') ?>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">OUT</span>
            <span>NÚMERO EN BINARIO</span>
            <span>PICT</span>
        </div>
    </section>
</div>

<?php renderFooter('ejercicio5', '../'); ?>
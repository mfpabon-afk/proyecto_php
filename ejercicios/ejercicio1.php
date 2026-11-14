<?php
require_once __DIR__ . '/../includes/layout.php';

class Acronimo {
    private string $fraseOriginal;

    public function __construct(string $frase) {
        $this->fraseOriginal = $frase;
    }

    public function generar(): string {
        $texto = str_replace('-', ' ', $this->fraseOriginal);
        $textoLimpio = preg_replace('/[^\p{L}\p{N}\s]/u', '', $texto);
        $palabras = preg_split('/\s+/', trim($textoLimpio), -1, PREG_SPLIT_NO_EMPTY);

        $acronimo = '';
        foreach ($palabras as $palabra) {
            $acronimo .= mb_strtoupper(mb_substr($palabra, 0, 1, 'UTF-8'), 'UTF-8');
        }
        return $acronimo;
    }
}

$resultado = null;
$frase = $_POST['frase'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($frase) !== '') {
    $obj = new Acronimo($frase);
    $resultado = $obj->generar();
}

renderHeader('01. Acrónimo', 'ejercicio1', '../');
?>

<div class="mac-workspace-grid">
    <!-- Ventana Izquierda: Formulario -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn" title="Cerrar y volver al menú"></a>
            <span class="mac-title-pill">Ejercicio 01 — Acrónimo</span>
        </div>

        <div class="mac-window-body">
            <form method="POST">
                <div class="mac-form-group">
                    <label for="frase">Frase de entrada:</label>
                    <input type="text" id="frase" name="frase" class="mac-input"
                           value="<?= htmlspecialchars($frase) ?>" required
                           placeholder="Ej: Portable Network Graphics">
                </div>
                <p style="margin-bottom:14px; font-size:1.1rem;">
                    * Los guiones separan palabras y los demás signos de puntuación se eliminan.
                </p>
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
            <span class="mac-status-counter">1 of 7</span>
            <span>EJERCICIO 01. ACRÓNIMO</span>
            <span>TEXT</span>
        </div>
    </section>

    <!-- Ventana Derecha: Scrapbook / Salida -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Scrapbook — Salida</span>
        </div>

        <div class="mac-window-body">
            <?php if ($resultado !== null): ?>
                <div class="mac-output-frame">
                    <p><strong>Frase procesada:</strong> <?= htmlspecialchars($frase) ?></p>
                    <div class="mac-output-big"><?= htmlspecialchars($resultado) ?></div>
                </div>
            <?php else: ?>
                <?= Layout::svgIlustracionScrapbook('Acrónimo') ?>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">OUT</span>
            <span>ACRÓNIMO GENERADO</span>
            <span>PICT</span>
        </div>
    </section>
</div>

<?php renderFooter('ejercicio1', '../'); ?>
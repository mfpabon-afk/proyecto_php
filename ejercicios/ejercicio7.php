<?php
require_once __DIR__ . '/../includes/layout.php';

class Calculadora {
    public function __construct() {
        if (!isset($_SESSION['historial_calculadora'])) {
            $_SESSION['historial_calculadora'] = [];
        }
    }

    public function calcular(float $num1, float $num2, string $operacion): float {
        switch ($operacion) {
            case 'suma':
                $resultado = $num1 + $num2;
                $simbolo = '+';
                break;
            case 'resta':
                $resultado = $num1 - $num2;
                $simbolo = '-';
                break;
            case 'multiplicacion':
                $resultado = $num1 * $num2;
                $simbolo = '×';
                break;
            case 'division':
                if ($num2 == 0) {
                    throw new DivisionByZeroError("No es posible dividir entre cero.");
                }
                $resultado = $num1 / $num2;
                $simbolo = '÷';
                break;
            case 'porcentaje':
                $resultado = ($num1 / 100) * $num2;
                $simbolo = '% de';
                break;
            default:
                throw new InvalidArgumentException("Operación no válida.");
        }

        $_SESSION['historial_calculadora'][] = [
            'operacion' => "{$num1} {$simbolo} {$num2}",
            'resultado' => $resultado
        ];

        return $resultado;
    }

    public function obtenerHistorial(): array {
        return array_reverse($_SESSION['historial_calculadora']);
    }

    public function borrarHistorial(): void {
        $_SESSION['historial_calculadora'] = [];
    }
}

$calc = new Calculadora();
$resultado = null;
$error = null;
$num1 = $_POST['num1'] ?? '';
$num2 = $_POST['num2'] ?? '';
$operacion = $_POST['operacion'] ?? 'suma';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['borrar_historial'])) {
        $calc->borrarHistorial();
    } elseif (isset($_POST['calcular'])) {
        try {
            $resultado = $calc->calcular(floatval($num1), floatval($num2), $operacion);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}

$historial = $calc->obtenerHistorial();

renderHeader('07. Calculadora', 'ejercicio7', '../');
?>

<div class="mac-workspace-grid">
    <!-- Ventana Izquierda: Calculadora -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Ejercicio 07 — Calculadora</span>
        </div>

        <div class="mac-window-body">
            <form method="POST">
                <div class="mac-form-group">
                    <label for="num1">Primer número:</label>
                    <input type="number" step="any" id="num1" name="num1" class="mac-input"
                           value="<?= htmlspecialchars($num1) ?>" required>
                </div>

                <div class="mac-form-group">
                    <label for="operacion">Operación:</label>
                    <select id="operacion" name="operacion" class="mac-input">
                        <option value="suma" <?= $operacion === 'suma' ? 'selected' : '' ?>>Suma (+)</option>
                        <option value="resta" <?= $operacion === 'resta' ? 'selected' : '' ?>>Resta (-)</option>
                        <option value="multiplicacion" <?= $operacion === 'multiplicacion' ? 'selected' : '' ?>>Multiplicación (×)</option>
                        <option value="division" <?= $operacion === 'division' ? 'selected' : '' ?>>División (÷)</option>
                        <option value="porcentaje" <?= $operacion === 'porcentaje' ? 'selected' : '' ?>>Porcentaje (%)</option>
                    </select>
                </div>

                <div class="mac-form-group">
                    <label for="num2">Segundo número:</label>
                    <input type="number" step="any" id="num2" name="num2" class="mac-input"
                           value="<?= htmlspecialchars($num2) ?>" required>
                </div>

                <div class="mac-btn-group">
                    <button type="submit" name="calcular" class="mac-btn-primary">OK</button>
                    <a href="../index.php" class="mac-btn-secondary">Menú</a>
                </div>
            </form>

            <?php if ($error): ?>
                <div class="mac-alert-error"><?= htmlspecialchars($error) ?></div>
            <?php elseif ($resultado !== null): ?>
                <div class="mac-output-big" style="margin-top:16px;">
                    = <?= htmlspecialchars((string)$resultado) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter">7 of 7</span>
            <span>CALCULADORA</span>
            <span>CALC</span>
        </div>
    </section>

    <!-- Ventana Derecha: Historial de Operaciones -->
    <section class="mac-window">
        <div class="mac-titlebar">
            <a href="../index.php" class="mac-close-btn"></a>
            <span class="mac-title-pill">Scrapbook — Historial</span>
        </div>

        <div class="mac-window-body">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <strong>Registro de sesión:</strong>
                <form method="POST">
                    <button type="submit" name="borrar_historial" class="mac-btn-secondary">Borrar Historial</button>
                </form>
            </div>

            <?php if (empty($historial)): ?>
                <?= Layout::svgIlustracionScrapbook('Historial vacío') ?>
            <?php else: ?>
                <div class="mac-output-frame">
                    <table class="mac-table">
                        <thead>
                            <tr>
                                <th>Operación</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historial as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['operacion']) ?></td>
                                    <td><strong><?= htmlspecialchars((string)$item['resultado']) ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="mac-scrollbar">
            <div class="mac-scroll-arrow">◀</div>
            <div class="mac-scroll-thumb"></div>
            <div class="mac-scroll-arrow">▶</div>
        </div>
        <div class="mac-statusbar">
            <span class="mac-status-counter"><?= count($historial) ?> reg.</span>
            <span>HISTORIAL CALCULADORA</span>
            <span>PICT</span>
        </div>
    </section>
</div>

<?php renderFooter('ejercicio7', '../'); ?>

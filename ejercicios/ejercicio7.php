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

renderHeader('07. CALCULADORA', 'MÓDULO 07 // OPERACIONES E HISTORIAL EN SESIÓN', 'ejercicio7', '../');
?>

<section class="work-panel">
    <h2 class="section-label">Calculadora Aritmética</h2>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label for="num1">Primer número (entero o decimal):</label>
                <input type="number" step="any" id="num1" name="num1" class="form-control" 
                       value="<?= htmlspecialchars($num1) ?>" required>
            </div>
            <div class="form-group">
                <label for="operacion">Operación:</label>
                <select id="operacion" name="operacion" class="form-control">
                    <option value="suma" <?= $operacion === 'suma' ? 'selected' : '' ?>>Suma (+)</option>
                    <option value="resta" <?= $operacion === 'resta' ? 'selected' : '' ?>>Resta (-)</option>
                    <option value="multiplicacion" <?= $operacion === 'multiplicacion' ? 'selected' : '' ?>>Multiplicación (×)</option>
                    <option value="division" <?= $operacion === 'division' ? 'selected' : '' ?>>División (÷)</option>
                    <option value="porcentaje" <?= $operacion === 'porcentaje' ? 'selected' : '' ?>>Porcentaje (%)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="num2">Segundo número (entero o decimal):</label>
                <input type="number" step="any" id="num2" name="num2" class="form-control" 
                       value="<?= htmlspecialchars($num2) ?>" required>
            </div>
        </div>
        <button type="submit" name="calcular" class="btn-recruit">CALCULAR</button>
    </form>

    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($resultado !== null): ?>
        <div class="result-box">
            <h3>Resultado</h3>
            <div class="result-highlight"><?= htmlspecialchars((string)$resultado) ?></div>
        </div>
    <?php endif; ?>
</section>

<section class="work-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
        <h2 class="section-label" style="margin-bottom:0;">Historial de Operaciones</h2>
        <form method="POST">
            <button type="submit" name="borrar_historial" class="btn-outline">BORRAR HISTORIAL</button>
        </form>
    </div>

    <?php if (empty($historial)): ?>
        <p style="color:var(--text-muted);">No hay operaciones registradas en la sesión actual.</p>
    <?php else: ?>
        <table class="tactical-table">
            <thead>
                <tr>
                    <th>Operación</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $item): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($item['operacion']) ?></strong></td>
                        <td style="color:var(--accent-red); font-weight:700;"><?= htmlspecialchars((string)$item['resultado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php renderFooter('../'); ?>
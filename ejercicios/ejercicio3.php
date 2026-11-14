<?php
require_once __DIR__ . '/../includes/layout.php';

class Estadistica {
    /** @var float[] */
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
            return "Sin moda (todos los valores aparecen una sola vez)";
        }

        $modas = [];
        foreach ($frecuencias as $valor => $frecuencia) {
            if ($frecuencia === $maxFrecuencia) {
                $modas[] = $valor;
            }
        }
        return implode(', ', $modas) . " (frecuencia: {$maxFrecuencia})";
    }
}

$cantidad = isset($_POST['cantidad']) ? max(1, min(50, intval($_POST['cantidad']))) : 5;
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

renderHeader('03. ESTADÍSTICA', 'MÓDULO 03 // PROMEDIO, MEDIANA Y MODA', 'ejercicio3', '../');
?>

<section class="work-panel">
    <h2 class="section-label">1. Definir Cantidad de Números Reales</h2>
    <form method="POST" style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap; margin-bottom:24px;">
        <div class="form-group" style="margin-bottom:0; width:240px;">
            <label for="cantidad">Cantidad de números (N):</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="50" class="form-control" value="<?= $cantidad ?>" required>
        </div>
        <button type="submit" name="generar_campos" class="btn-outline">GENERAR CAMPOS</button>
    </form>

    <h2 class="section-label">2. Ingresar Serie de Números Reales</h2>
    <form method="POST">
        <input type="hidden" name="cantidad" value="<?= $cantidad ?>">
        <div class="form-grid">
            <?php for ($i = 0; $i < $cantidad; $i++): ?>
                <div class="form-group">
                    <label>Número #<?= $i + 1 ?>:</label>
                    <input type="number" step="any" name="numeros[]" class="form-control" 
                           value="<?= htmlspecialchars($valoresIngresados[$i] ?? '') ?>" required>
                </div>
            <?php endfor; ?>
        </div>
        <button type="submit" name="calcular" class="btn-recruit">CALCULAR ESTADÍSTICAS</button>
    </form>

    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($resultados): ?>
        <div class="result-box">
            <h3>Resultados Estadísticos</h3>
            <p><strong>Promedio (Media Aritmética):</strong> <?= round($resultados['promedio'], 4) ?></p>
            <p><strong>Mediana (Valor Central):</strong> <?= round($resultados['mediana'], 4) ?></p>
            <p><strong>Moda:</strong> <?= htmlspecialchars($resultados['moda']) ?></p>
        </div>
    <?php endif; ?>
</section>

<?php renderFooter('../'); ?>

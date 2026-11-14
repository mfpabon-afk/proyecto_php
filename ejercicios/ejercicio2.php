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

renderHeader('02. FIBONACCI / FACTORIAL', 'MÓDULO 02 // SERIES NUMÉRICAS', 'ejercicio2', '../');
?>

<section class="work-panel">
    <h2 class="section-label">Generador de Sucesiones</h2>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label for="numero">Número entero (N):</label>
                <input type="number" id="numero" name="numero" min="0" max="50" class="form-control" 
                       value="<?= htmlspecialchars($numero) ?>" required>
            </div>
            <div class="form-group">
                <label for="operacion">Seleccione la operación:</label>
                <select id="operacion" name="operacion" class="form-control">
                    <option value="fibonacci" <?= $operacion === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci</option>
                    <option value="factorial" <?= $operacion === 'factorial' ? 'selected' : '' ?>>Serie Factorial (1! hasta N!)</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn-recruit">CALCULAR SERIE</button>
    </form>

    <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($serie !== null): ?>
        <div class="result-box">
            <h3>Serie Resultante (<?= strtoupper(htmlspecialchars($operacion)) ?>)</h3>
            <p style="font-size: 1.25rem; font-weight: 600; letter-spacing: 1px;">
                <?= empty($serie) ? 'Sin elementos (N = 0)' : htmlspecialchars(implode(' , ', $serie)) ?>
            </p>
        </div>
    <?php endif; ?>
</section>

<?php renderFooter('../'); ?>

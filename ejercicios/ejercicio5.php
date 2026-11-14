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
            $pasos[] = "{$valor} ÷ 2 = {$cociente} (Residuo: {$residuo})";
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

renderHeader('05. BINARIO', 'MÓDULO 05 // CONVERSIÓN DE BASE NUMÉRICA', 'ejercicio5', '../');
?>

<section class="work-panel">
    <h2 class="section-label">Convertir Número Entero a Binario</h2>
    <form method="POST">
        <div class="form-group">
            <label for="numero">Número entero decimal:</label>
            <input type="number" id="numero" name="numero" class="form-control" 
                   value="<?= htmlspecialchars($numero) ?>" placeholder="Ej: 42" required>
        </div>
        <button type="submit" class="btn-recruit">CONVERTIR A BINARIO</button>
    </form>

    <?php if ($conversion !== null): ?>
        <div class="result-box">
            <h3>Equivalente Binario</h3>
            <div class="result-highlight"><?= htmlspecialchars($conversion['binario']) ?></div>
            <p style="margin-top:12px; font-size:0.9rem; color:#BDBCB7;">Proceso de divisiones sucesivas:</p>
            <ul style="margin-left:20px; margin-top:6px; font-size:0.9rem;">
                <?php foreach ($conversion['pasos'] as $paso): ?>
                    <li><?= htmlspecialchars($paso) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</section>

<?php renderFooter('../'); ?>

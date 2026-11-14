<?php
require_once __DIR__ . '/../includes/layout.php';

class Acronimo {
    private string $fraseOriginal;

    public function __construct(string $frase) {
        $this->fraseOriginal = $frase;
    }

    public function generar(): string {
        // Los guiones actúan como separadores de palabras
        $texto = str_replace('-', ' ', $this->fraseOriginal);
        // Eliminar todos los demás signos de puntuación
        $textoLimpio = preg_replace('/[^\p{L}\p{N}\s]/u', '', $texto);
        // Separar palabras
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

renderHeader('01. ACRÓNIMO', 'MÓDULO 01 // PROCESAMIENTO DE CADENAS', 'ejercicio1', '../');
?>

<section class="work-panel">
    <h2 class="section-label">Convertir Frase a Acrónimo</h2>
    <form method="POST">
        <div class="form-group">
            <label for="frase">Ingrese la frase (Ej: Portable Network Graphics, Liquid-crystal display, Thank George It's Friday!):</label>
            <input type="text" id="frase" name="frase" class="form-control" 
                   value="<?= htmlspecialchars($frase) ?>" required placeholder="Escriba aquí la frase...">
        </div>
        <button type="submit" class="btn-recruit">GENERAR ACRÓNIMO</button>
    </form>

    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <h3>Acrónimo Generado</h3>
            <p>Entrada: <strong><?= htmlspecialchars($frase) ?></strong></p>
            <div class="result-highlight"><?= htmlspecialchars($resultado) ?></div>
        </div>
    <?php endif; ?>
</section>

<?php renderFooter('../'); ?>

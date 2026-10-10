<?php
/**
 * Clase Binario
 * Convierte un número entero positivo a su representación en binario.
 */
class Binario {
    private int $numero;

    public function __construct(int $numero) {
        $this->numero = max(0, $numero);
    }

    public function convertir(): array {
        if ($this->numero === 0) {
            return [
                'binario' => '0',
                'bits' => ['0'],
                'pasos' => ['0 ÷ 2 = 0 (Residuo: 0)']
            ];
        }

        $n = $this->numero;
        $residuos = [];
        $pasos = [];

        while ($n > 0) {
            $cociente = (int)floor($n / 2);
            $residuo = $n % 2;
            $pasos[] = "{$n} ÷ 2 = {$cociente} (Residuo: {$residuo})";
            $residuos[] = $residuo;
            $n = $cociente;
        }

        $bits = [];
        $cant = count($residuos);
        for ($i = $cant - 1; $i >= 0; $i--) {
            $bits[] = (string)$residuos[$i];
        }

        return [
            'binario' => implode('', $bits),
            'bits' => $bits,
            'pasos' => $pasos
        ];
    }
}
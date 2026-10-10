<?php
/**
 * Clase PromedioModa
 * Taller Académico - Ejercicio 3
 *
 * Calculates Promedio, Mediana (mediante Bubble Sort manual) y Moda.
 */
class PromedioModa {
    private array $numeros;

    public function __construct(string $entradaTexto) {
        $this->numeros = $this->parsearNumerosManual($entradaTexto);
    }

    private function parsearNumerosManual(string $cadena): array {
        $longitud = strlen($cadena);
        $numeros = [];
        $buffer = '';

        for ($i = 0; $i < $longitud; $i++) {
            $char = $cadena[$i];
            if ($char === ',' || $char === ' ' || $char === "\t" || $char === "\n") {
                if ($buffer !== '' && is_numeric($buffer)) {
                    $numeros[] = (float)$buffer;
                    $buffer = '';
                }
            } else {
                $buffer .= $char;
            }
        }
        if ($buffer !== '' && is_numeric($buffer)) {
            $numeros[] = (float)$buffer;
        }

        return $numeros;
    }

    public function calcular(): array {
        $n = count($this->numeros);
        if ($n === 0) {
            return ['valido' => false, 'mensaje' => 'Ingrese al menos un número válido.'];
        }

        // 1. Promedio (Media Aritmética)
        $sumaTotal = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $sumaTotal += $this->numeros[$i];
        }
        $promedio = $sumaTotal / $n;

        // 2. Mediana (Algoritmo Bubble Sort)
        $ordenados = $this->numeros;
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($ordenados[$j] > $ordenados[$j + 1]) {
                    $temp = $ordenados[$j];
                    $ordenados[$j] = $ordenados[$j + 1];
                    $ordenados[$j + 1] = $temp;
                }
            }
        }

        if ($n % 2 === 1) {
            $mediana = $ordenados[(int)floor($n / 2)];
        } else {
            $m1 = $ordenados[($n / 2) - 1];
            $m2 = $ordenados[$n / 2];
            $mediana = ($m1 + $m2) / 2.0;
        }

        // 3. Moda
        $frecuencias = [];
        for ($i = 0; $i < $n; $i++) {
            $val = (string)$this->numeros[$i];
            $frecuencias[$val] = ($frecuencias[$val] ?? 0) + 1;
        }

        $maxFreq = 0;
        foreach ($frecuencias as $val => $freq) {
            if ($freq > $maxFreq) {
                $maxFreq = $freq;
            }
        }

        if ($maxFreq === 1 && count($frecuencias) > 1) {
            $textoModa = 'No hay moda (todos los valores tienen frecuencia 1)';
        } else {
            $modas = [];
            foreach ($frecuencias as $val => $freq) {
                if ($freq === $maxFreq) {
                    $modas[] = (float)$val;
                }
            }
            $textoModa = implode(', ', $modas) . " (Frecuencia: $maxFreq)";
        }

        return [
            'valido' => true,
            'cantidad' => $n,
            'promedio' => round($promedio, 4),
            'mediana' => round($mediana, 4),
            'moda' => $textoModa,
            'ordenados' => $ordenados
        ];
    }

    public function getNumeros(): array { return $this->numeros; }
}
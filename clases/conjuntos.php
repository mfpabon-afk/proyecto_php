<?php
/**
 * Clase Conjuntos
 * Taller Académico - Ejercicio 4
 *
 * Operaciones con conjuntos (Unión, Intersección y Diferencias) usando búsqueda lineal manual.
 */
class Conjuntos {
    private array $conjuntoA;
    private array $conjuntoB;

    public function __construct(string $entradaA, string $entradaB) {
        $this->conjuntoA = $this->parsearEInsertarUnicos($entradaA);
        $this->conjuntoB = $this->parsearEInsertarUnicos($entradaB);
    }

    private function parsearEInsertarUnicos(string $cadena): array {
        $longitud = strlen($cadena);
        $buffer = '';
        $resultado = [];

        for ($i = 0; $i < $longitud; $i++) {
            $char = $cadena[$i];
            if ($char === ',' || $char === ' ' || $char === "\t" || $char === "\n") {
                if ($buffer !== '' && is_numeric($buffer)) {
                    $val = (int)$buffer;
                    if (!$this->existeEnArreglo($resultado, $val)) {
                        $resultado[] = $val;
                    }
                    $buffer = '';
                }
            } else {
                $buffer .= $char;
            }
        }

        if ($buffer !== '' && is_numeric($buffer)) {
            $val = (int)$buffer;
            if (!$this->existeEnArreglo($resultado, $val)) {
                $resultado[] = $val;
            }
        }

        $this->ordenarBurbuja($resultado);
        return $resultado;
    }

    private function existeEnArreglo(array $arr, int $elem): bool {
        $cant = count($arr);
        for ($i = 0; $i < $cant; $i++) {
            if ($arr[$i] === $elem) {
                return true;
            }
        }
        return false;
    }

    private function ordenarBurbuja(array &$arr): void {
        $cant = count($arr);
        for ($i = 0; $i < $cant - 1; $i++) {
            for ($j = 0; $j < $cant - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
    }

    public function calcular(): array {
        // Unión (A ∪ B)
        $union = $this->conjuntoA;
        $cantB = count($this->conjuntoB);
        for ($i = 0; $i < $cantB; $i++) {
            if (!$this->existeEnArreglo($union, $this->conjuntoB[$i])) {
                $union[] = $this->conjuntoB[$i];
            }
        }
        $this->ordenarBurbuja($union);

        // Intersección (A ∩ B)
        $interseccion = [];
        $cantA = count($this->conjuntoA);
        for ($i = 0; $i < $cantA; $i++) {
            if ($this->existeEnArreglo($this->conjuntoB, $this->conjuntoA[$i])) {
                $interseccion[] = $this->conjuntoA[$i];
            }
        }
        $this->ordenarBurbuja($interseccion);

        // Diferencia A - B
        $diferenciaAB = [];
        for ($i = 0; $i < $cantA; $i++) {
            if (!$this->existeEnArreglo($this->conjuntoB, $this->conjuntoA[$i])) {
                $diferenciaAB[] = $this->conjuntoA[$i];
            }
        }
        $this->ordenarBurbuja($diferenciaAB);

        // Diferencia B - A
        $diferenciaBA = [];
        for ($i = 0; $i < $cantB; $i++) {
            if (!$this->existeEnArreglo($this->conjuntoA, $this->conjuntoB[$i])) {
                $diferenciaBA[] = $this->conjuntoB[$i];
            }
        }
        $this->ordenarBurbuja($diferenciaBA);

        return [
            'conjunto_a' => $this->conjuntoA,
            'conjunto_b' => $this->conjuntoB,
            'union' => $union,
            'interseccion' => $interseccion,
            'diferencia_a_b' => $diferenciaAB,
            'diferencia_b_a' => $diferenciaBA
        ];
    }

    public function getConjuntoA(): array { return $this->conjuntoA; }
    public function getConjuntoB(): array { return $this->conjuntoB; }
}
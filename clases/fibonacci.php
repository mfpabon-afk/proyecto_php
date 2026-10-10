<?php
/**
 * Clase Fibonacci
 * Taller Académico - Ejercicio 2
 *
 * Genera la Sucesión de Fibonacci o el cálculo de Factorial.
 */
class Fibonacci {
    private int $numero;
    private string $operacion;
    private array $serie;
    private string $resultado;

    public function __construct(int $numero, string $operacion) {
        $this->numero = max(0, min(50, $numero));
        $this->operacion = strtolower($operacion);
        $this->serie = [];
        $this->resultado = '';
    }

    public function calcular(): array {
        if ($this->operacion === 'factorial') {
            $this->calcularFactorial();
        } else {
            $this->calcularFibonacci();
        }

        return [
            'serie' => $this->serie,
            'resultado' => $this->resultado
        ];
    }

    private function calcularFibonacci(): void {
        if ($this->numero === 0) {
            $this->serie = [];
            $this->resultado = 'Cantidad de términos: 0';
            return;
        }

        $a = 0;
        $b = 1;
        $this->serie = [];

        for ($i = 0; $i < $this->numero; $i++) {
            $this->serie[] = $a;
            $siguiente = $a + $b;
            $a = $b;
            $b = $siguiente;
        }

        $texto = '';
        $cant = count($this->serie);
        for ($i = 0; $i < $cant; $i++) {
            $texto .= $this->serie[$i] . ($i < $cant - 1 ? ' → ' : '');
        }

        $this->resultado = $texto;
    }

    private function calcularFactorial(): void {
        if ($this->numero === 0) {
            $this->serie = [1];
            $this->resultado = '0! = 1';
            return;
        }

        $fact = 1;
        $pasos = [];

        for ($i = 1; $i <= $this->numero; $i++) {
            $fact *= $i;
            $pasos[] = $i;
        }

        $this->serie = $pasos;

        $proceso = '';
        $cant = count($pasos);
        for ($i = 0; $i < $cant; $i++) {
            $proceso .= $pasos[$i] . ($i < $cant - 1 ? ' × ' : '');
        }

        $this->resultado = $this->numero . '! = ' . $proceso . ' = ' . number_format($fact, 0, ',', '.');
    }

    public function getNumero(): int { return $this->numero; }
    public function getOperacion(): string { return $this->operacion; }
    public function getSerie(): array { return $this->serie; }
    public function getResultado(): string { return $this->resultado; }
}
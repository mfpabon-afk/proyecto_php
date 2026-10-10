<?php
/**
 * Clase Calculadora
 * Encapsula la lógica de operaciones básicas y porcentaje.
 */
class Calculadora {
    private float $num1;
    private float $num2;
    private string $operacion;
    private float $resultado;

    /**
     * Constructor de la Calculadora
     */
    public function __construct(float $num1, float $num2, string $operacion) {
        $this->num1 = $num1;
        $this->num2 = $num2;
        $this->operacion = $operacion;
        $this->resultado = 0.0;
    }

    /**
     * Ejecuta el cálculo según la operación seleccionada
     */
    public function calcular(): float {
        switch ($this->operacion) {
            case '+':
                $this->resultado = $this->num1 + $this->num2;
                break;
            case '-':
                $this->resultado = $this->num1 - $this->num2;
                break;
            case '*':
                $this->resultado = $this->num1 * $this->num2;
                break;
            case '/':
                $this->resultado = ($this->num2 != 0) ? ($this->num1 / $this->num2) : 0;
                break;
            case '%':
                $this->resultado = ($this->num1 * $this->num2) / 100;
                break;
            default:
                $this->resultado = 0;
        }
        return $this->resultado;
    }

    public function getExpresionFormat(): string {
        $simbolo = $this->operacion;
        if ($this->operacion === '%') {
            return "{$this->num2}% de {$this->num1} = {$this->resultado}";
        }
        return "{$this->num1} {$simbolo} {$this->num2} = {$this->resultado}";
    }

    public function getResultado(): float { return $this->resultado; }
}
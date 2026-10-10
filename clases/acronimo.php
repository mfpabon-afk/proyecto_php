<?php
/**
 * Clase Acronimo
 * Taller Académico - Ejercicio 1
 *
 * Convierte una frase o término largo en su acrónimo en mayúsculas,
 * procesando carácter por carácter mediante una máquina de estados.
 */
class Acronimo {
    private string $frase;
    private string $resultado;

    /**
     * Constructor de la clase
     * @param string $frase Texto de entrada
     */
    public function __construct(string $frase) {
        $this->frase = trim($frase);
        $this->resultado = '';
    }

    /**
     * Procesa la frase carácter por carácter y devuelve el acrónimo.
     * @return string
     */
    public function calcular(): string {
        if ($this->frase === '') {
            $this->resultado = '';
            return '';
        }

        $acronimo = '';
        $enPalabra = false; // Bandera de estado
        $longitud = mb_strlen($this->frase, 'UTF-8');

        for ($i = 0; $i < $longitud; $i++) {
            $char = mb_substr($this->frase, $i, 1, 'UTF-8');

            if ($char === ' ' || $char === '-' || $char === '_') {
                $enPalabra = false;
            } else {
                if ($this->esLetraONumero($char)) {
                    if (!$enPalabra) {
                        $acronimo .= mb_strtoupper($char, 'UTF-8');
                        $enPalabra = true;
                    }
                }
            }
        }

        $this->resultado = $acronimo;
        return $this->resultado;
    }

    private function esLetraONumero(string $char): bool {
        return preg_match('/[\p{L}\p{N}]/u', $char) === 1;
    }

    public function getFrase(): string { return $this->frase; }
    public function getResultado(): string { return $this->resultado; }
}
<?php
require_once __DIR__ . '/../includes/layout.php';

class NodoArbol {
    public string \$valor;
    public ?NodoArbol \$izquierda = null;
    public ?NodoArbol \$derecha = null;

    public function __construct(string \$valor) {
        $this->valor =$valor;
    }
}

class ArbolBinario {
    private ?NodoArbol \$raiz = null;
    private string \$metodoUsado = '';

    /**
     * Convierte cualquier entrada de letras (con flechas, comas, espacios o juntas) en un arreglo de nodos.
     */
    public function parsearRecorrido(string \$cadena): array {
        $limpio = mb_strtoupper(trim($cadena), 'UTF-8');
        if (\$limpio === '') {
            return [];
        }

        $normalizado = trim(preg_replace('/[\s,;\vert{}\-\/>→=]+/u', ' ',$limpio));

        if (strpos($normalizado, ' ') === false && mb_strlen($normalizado, 'UTF-8') > 1) {
            return preg_split('//u', \$normalizado, -1, PREG_SPLIT_NO_EMPTY);
        }

        return preg_split('/\s+/u', \$normalizado, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function construir(string $preStr, string$inStr, string $postStr): void {$pre  = $this->parsearRecorrido($preStr);
        $in   =$this->parsearRecorrido($inStr);$post = $this->parsearRecorrido($postStr);

        $ingresados = (!empty($pre) ? 1 : 0) + (!empty($in) ? 1 : 0) + (!empty($post) ? 1 : 0);
        if (\$ingresados < 2) {
            throw new InvalidArgumentException("Debe ingresar mínimo dos recorridos para construir el árbol.");
        }

        // Si se ingresan los tres a la vez, por defecto se calcula con Preorden - Inorden[cite: 1]
        if (!empty(\$pre) && !empty($in)) {$this->validarConsistencia($pre,$in);
            $this->metodoUsado = (!empty($post))
                ? "Preorden + Inorden (priorizado por defecto al ingresar los tres recorridos)"
                : "Preorden + Inorden";
            $this->raiz =$this->desdePreIn($pre,$in);
        } elseif (!empty($post) && !empty($in)) {
            $this->validarConsistencia($post, $in);$this->metodoUsado = "Postorden + Inorden";
            $this->raiz =$this->desdePostIn($post,$in);
        } else {
            $this->validarConsistencia($pre, $post);$this->metodoUsado = "Preorden + Postorden";
            $this->raiz =$this->desdePrePost($pre,$post);
        }
    }

    private function validarConsistencia(array $r1, array$r2): void {
        if (count($r1) !== count($r2)) {
            throw new InvalidArgumentException("Los recorridos ingresados tienen diferente cantidad de letras.");
        }
        if (count(array_unique($r1)) !== count($r1)) {
            throw new InvalidArgumentException("No repitas letras dentro del mismo recorrido.");
        }
        $s1 =$r1;
        $s2 =$r2;
        sort(\$s1);
        sort(\$s2);
        if ($s1 !==$s2) {
            throw new InvalidArgumentException("Los recorridos deben contener exactamente las mismas letras.");
        }
    }

    private function desdePreIn(array $pre, array$in): ?NodoArbol {
        if (empty($pre) \vert{}\vert{} empty($in)) {
            return null;
        }

        \$valorRaiz = $pre[0];$idx = array_search($valorRaiz,$in, true);
        if (\$idx === false) {
            throw new InvalidArgumentException("La combinación de Preorden e Inorden no forma un árbol binario válido.");
        }

        $nodo = new NodoArbol($valorRaiz);
        $inIzq  = array_slice($in, 0, $idx);$inDer  = array_slice($in,$idx + 1);
        $preIzq = array_slice($pre, 1, count($inIzq));$preDer = array_slice($pre, 1 + count($inIzq));

        $nodo->izquierda =$this->desdePreIn($preIzq,$inIzq);
        $nodo->derecha   =$this->desdePreIn($preDer,$inDer);
        return \$nodo;
    }

    private function desdePostIn(array $post, array$in): ?NodoArbol {
        if (empty($post) \vert{}\vert{} empty($in)) {
            return null;
        }

        \$valorRaiz = end($post);$idx = array_search($valorRaiz,$in, true);
        if (\$idx === false) {
            throw new InvalidArgumentException("La combinación de Postorden e Inorden no forma un árbol binario válido.");
        }

        \$nodo = new NodoArbol($valorRaiz);$inIzq   = array_slice($in, 0,$idx);
        $inDer   = array_slice($in, $idx + 1);$postIzq = array_slice($post, 0, count($inIzq));
        $postDer = array_slice($post, count($inIzq), count($inDer));

        $nodo->izquierda =$this->desdePostIn($postIzq,$inIzq);
        $nodo->derecha   =$this->desdePostIn($postDer,$inDer);
        return \$nodo;
    }

    private function desdePrePost(array $pre, array$post): ?NodoArbol {
        if (empty(\$pre)) {
            return null;
        }

        $nodo = new NodoArbol($pre[0]);
        if (count(\$pre) === 1) {
            return \$nodo;
        }

        \$raizIzq = $pre[1];$idx = array_search($raizIzq,$post, true);
        if (\$idx === false || $idx >= count($post) - 1) {
            throw new InvalidArgumentException("La combinación de Preorden y Postorden no forma un árbol binario válido.");
        }

        $tamIzq =$idx + 1;
        $preIzq  = array_slice($pre, 1, $tamIzq);$postIzq = array_slice($post, 0,$tamIzq);
        $preDer  = array_slice($pre, $tamIzq + 1);$postDer = array_slice($post,$tamIzq, -1);

        $this->validarConsistencia($preIzq, $postIzq);$this->validarConsistencia($preDer,$postDer);

        $nodo->izquierda =$this->desdePrePost($preIzq,$postIzq);
        $nodo->derecha   =$this->desdePrePost($preDer,$postDer);
        return \$nodo;
    }

    public function getMetodoUsado(): string {
        return \$this->metodoUsado;
    }

    public function obtenerRecorridosGenerados(): array {
        $pre = [];$in = [];
        $post = [];$this->recorrer($this->raiz,$pre, $in,$post);
        return [
            'preorden'  => implode(' → ', \$pre),
            'inorden'   => implode(' → ', \$in),
            'postorden' => implode(' → ', \$post),
        ];
    }

    private function recorrer(?NodoArbol $nodo, array &$pre, array &$in, array &$post): void {
        if (!\$nodo) return;
        $pre[] =$nodo->valor;
        \$this->recorrer($nodo->izquierda,$pre, $in,$post);
        $in[] =$nodo->valor;
        \$this->recorrer($nodo->derecha,$pre, $in,$post);
        $post[] =$nodo->valor;
    }

    public function renderizarSVG(): string {
        if (!\$this->raiz) {
            return '';
        }

        $totalNodos =$this->contarNodos($this->raiz);$altura     = $this->obtenerAltura($this->raiz);

        \$pasoX   = 70;
        \$pasoY   = 85;
        \$margenX = 50;
        \$margenY = 50;

        $anchoSVG = max(460,$totalNodos * $pasoX +$margenX * 2);
        $altoSVG  = max(230,$altura * $pasoY +$margenY);

        $coords = [];$columnaActual = 0;
        $this->calcularCoordenadas($this->raiz, 0, $columnaActual,$pasoX, $pasoY,$margenX, $margenY,$coords);

        \$lineas = '';
        $nodos  = '';$this->generarElementosSVG($this->raiz,$coords, $lineas,$nodos);

        return "<svg width='100%' viewBox='0 0 {$anchoSVG} {$altoSVG}' style='max-height:440px; background:#15202B; border:1px solid #FF4655;'>
                    {\$lineas}
                    {\$nodos}
                </svg>";
    }

    private function contarNodos(?NodoArbol \$nodo): int {
        if (!\$nodo) return 0;
        return 1 + $this->contarNodos($nodo->izquierda) + $this->contarNodos($nodo->derecha);
    }

    private function obtenerAltura(?NodoArbol \$nodo): int {
        if (!\$nodo) return 0;
        return 1 + max($this->obtenerAltura($nodo->izquierda), $this->obtenerAltura($nodo->derecha));
    }

    private function calcularCoordenadas(
        ?NodoArbol \$nodo,
        int \$profundidad,
        int &\$columnaActual,
        int \$pasoX,
        int \$pasoY,
        int \$margenX,
        int \$margenY,
        array &\$coords
    ): void {
        if (!\$nodo) return;

        \$this->calcularCoordenadas($nodo->izquierda,$profundidad + 1, $columnaActual,$pasoX, $pasoY,$margenX, $margenY,$coords);

        $coords[$nodo->valor] = [
            'x' => \$margenX + ($columnaActual * $pasoX) + ($pasoX / 2), 'y' =>$margenY + ($profundidad * $pasoY),
        ];
        \$columnaActual++;

        \$this->calcularCoordenadas($nodo->derecha,$profundidad + 1, $columnaActual,$pasoX, $pasoY,$margenX, $margenY,$coords);
    }

    private function generarElementosSVG(?NodoArbol $nodo, array$coords, string &$lineas, string &$nodos): void {
        if (!\$nodo) return;

        $x =$coords[$nodo->valor]['x'];$y = $coords[$nodo->valor]['y'];

        if ($nodo->izquierda) {$izqX = $coords[$nodo->izquierda->valor]['x'];
            $izqY =$coords[$nodo->izquierda->valor]['y'];$lineas .= "<line x1='{$x}' y1='{$y}' x2='{$izqX}' y2='{$izq
            
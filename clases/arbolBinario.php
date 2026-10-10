<?php
class NodoArbol {
    public string $valor;
    public ?NodoArbol $izq = null;
    public ?NodoArbol $der = null;

    public function __construct(string $valor) {
        $this->valor = $valor;
    }
}

class ArbolBinario {
    private array $preorden;
    private array $inorden;

    public function __construct(string $strPre, string $strIn) {
        $this->preorden = $this->parsearArray($strPre);
        $this->inorden = $this->parsearArray($strIn);
    }

    private function parsearArray(string $cadena): array {
        $elementos = preg_split('/[\s,\->]+/', trim($cadena));
        $res = [];
        if (is_array($elementos)) {
            foreach ($elementos as $e) {
                $e = trim($e);
                if ($e !== '') $res[] = $e;
            }
        }
        return $res;
    }

    public function construir(): ?NodoArbol {
        if (empty($this->preorden) || empty($this->inorden)) return null;
        $preIdx = 0;
        return $this->construirRec($this->preorden, $this->inorden, $preIdx, 0, count($this->inorden) - 1);
    }

    private function construirRec(array $pre, array $in, int &$preIdx, int $inInicio, int $inFin): ?NodoArbol {
        if ($inInicio > $inFin || $preIdx >= count($pre)) return null;

        $raizVal = $pre[$preIdx++];
        $nodo = new NodoArbol($raizVal);

        $inIdx = -1;
        for ($i = $inInicio; $i <= $inFin; $i++) {
            if ($in[$i] === $raizVal) {
                $inIdx = $i;
                break;
            }
        }

        if ($inIdx === -1) return $nodo;

        $nodo->izq = $this->construirRec($pre, $in, $preIdx, $inInicio, $inIdx - 1);
        $nodo->der = $this->construirRec($pre, $in, $preIdx, $inIdx + 1, $inFin);

        return $nodo;
    }

    public function renderHTML(?NodoArbol $nodo): string {
        if ($nodo === null) return '';

        $html = '<div class="tree-node">';
        $html .= '<div class="node-badge">' . htmlspecialchars($nodo->valor) . '</div>';
        if ($nodo->izq !== null || $nodo->der !== null) {
            $html .= '<div class="node-children">';
            $html .= '<div class="child-branch">' . ($nodo->izq ? $this->renderHTML($nodo->izq) : '<div class="node-badge null">&Oslash;</div>') . '</div>';
            $html .= '<div class="child-branch">' . ($nodo->der ? $this->renderHTML($nodo->der) : '<div class="node-badge null">&Oslash;</div>') . '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}
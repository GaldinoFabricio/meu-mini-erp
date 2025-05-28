<?php
require_once __DIR__ . '/../models/Cupom.php';

class CupomController {
    public function gerenciar() {
        $cupons = Cupom::buscarTodos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = $_POST['codigo'] ?? '';
            $tipo = $_POST['tipo'] ?? 'fixo';
            $valor = $_POST['valor'] ?? 0;
            $valor_minimo = $_POST['valor_minimo'] ?? 0;
            $validade = $_POST['validade'] ?? date('Y-m-d');

            Cupom::criar($codigo, $tipo, $valor, $valor_minimo, $validade);

            header('Location: /cupons');
            exit;
        }

        include __DIR__ . '/../views/cupons/gerenciar.php';
    }
}

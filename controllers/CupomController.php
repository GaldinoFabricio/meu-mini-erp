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

    public function criar() {
        ob_clean();
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');
        $dados = json_decode($input, true);

        $codigo = $dados['codigo'] ?? '';
        $tipo = $dados['tipo'] ?? 'fixo';
        $valor = $dados['valor'] ?? 0;
        $valor_minimo = $dados['valor_minimo'] ?? 0;
        $validade = $dados['validade'] ?? date('Y-m-d');

        if (strtotime($validade) < strtotime(date('Y-m-d'))) {
            die(json_encode(['sucesso' => false, 'erro' => 'A validade deve ser maior ou igual a hoje.']));
        }

        try {
            Cupom::criar($codigo, $tipo, $valor, $valor_minimo, $validade);
            die(json_encode(['sucesso' => true, 'mensagem' => 'Cupom criado com sucesso!']));
        } catch (Exception $e) {
            die(json_encode(['sucesso' => false, 'erro' => $e->getMessage()]));
        }    
    }
}

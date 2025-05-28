<?php
require_once __DIR__ . '/../models/Estoque.php';

class EstoqueController {
    public function listar() {
        $estoques = Estoque::buscarTodos();
        include __DIR__ . '/../views/estoques/listar.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /estoques');
            exit;
        }

        $estoque = Estoque::buscarPorId($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantidade = $_POST['quantidade'] ?? 0;
            Estoque::atualizar($id, $quantidade);
            header('Location: /estoques');
            exit;
        }

        include __DIR__ . '/../views/estoques/editar.php';
    }
}

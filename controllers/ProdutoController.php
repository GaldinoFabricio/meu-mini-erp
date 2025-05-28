<?php
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController {
    public function index() {
        $produtos = Produto::listarTodos();
        include __DIR__ . '/../views/produtos/listar.php';
    }

    public function form() {
        include __DIR__ . '/../views/produtos/form.php';
    }

    public function salvar() {
        header('Content-Type: application/json');
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $estoque = $_POST['estoque'];
        try {
            Produto::salvar($nome, $preco, $estoque);
        //header("Location: /");

            die(
                json_encode([
                    'sucesso' => true,
                    'mensagem' => 'Produto criado com sucesso!'
                ])
            );
        } catch (Exception $e) {
            die(
                json_encode([
                    'sucesso' => false,
                    'erro' => $e->getMessage()
                ])
            );
        }
    }
}

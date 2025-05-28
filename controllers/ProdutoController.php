<?php
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController {
    public function index() {
        $produtos = Produto::listarTodos();
        include __DIR__ . '/../views/produtos/form.php';
    }

    public function salvar() {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $estoque = $_POST['estoque'];
        Produto::salvar($nome, $preco, $estoque);
        header("Location: /");
    }
}

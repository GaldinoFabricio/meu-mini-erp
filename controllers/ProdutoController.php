<?php
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController {
    public function index() {
        $produtos = Produto::listarTodos();
        include __DIR__ . '/../views/produtos/listar.php';
    }

    public function form() {
        $Produtos = Produto::listarTodos();
        include __DIR__ . '/../views/produtos/form.php';
    }

    public function salvar() {
        ob_clean();
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');
        $dados = json_decode($input, true);

        // Agora pega os dados corretamente
        $nome = $dados['nome'] ?? null;
        $preco = $dados['preco'] ?? null;
        $estoque = $dados['estoque'] ?? null;

        try {
            Produto::salvar($nome, $preco, $estoque);

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

    public function editar() {
        ob_clean();
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');
        $dados = json_decode($input, true);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /produtos');
            exit;
        }
        if (!$dados) {
            die(
                json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Dados inválidos!'
                ])
            );
        }

        $produto = Produto::buscarPorId($id);

        if (!$produto) {
            die(
                json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Produto não encontrado!'
                ])
            );
        }

    
        $nome = $dados['nome'] ?? null;
        $preco = $dados['preco'] ?? null;
        $estoque = $dados['estoque'] ?? null;

        Produto::atualizar($id, $nome, $preco, $estoque);
        die(
            json_encode([
                'sucesso' => true,
                'mensagem' => 'Produto atualizado com sucesso!'
            ])
        );
    }
}

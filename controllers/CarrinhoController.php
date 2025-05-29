<?php
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../helpers/functions.php';

session_start();

class CarrinhoController
{
    public function adicionar()
    {
        session_start();
        ob_clean();

        header('Content-Type: application/json');

        $produto_id = $_GET['produto_id'] ?? null;
        $quantidade = $_GET['quantidade'] ?? 1;

        if (!$produto_id) {
            echo json_encode(['erro' => 'ID do produto não informado.']);
            die();
        }

        $produto = Produto::buscarPorId($produto_id);
        if (!$produto) {
            echo json_encode(['erro' => 'Produto não encontrado.']);
            die();
        }

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$produto_id])) {
            $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$produto_id] = [
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'preco_total' => $produto['preco'] * $quantidade,
                'quantidade' => $quantidade
            ];
        }

        echo json_encode([
            'sucesso' => true,
            'mensagem' => "Produto {$produto['nome']} adicionado ao carrinho."
        ]);
        die();
    }


    public function comprar()
    {
        session_start();

        $produto_id = $_POST['produto_id'] ?? null;
        $quantidade = $_POST['quantidade'] ?? 1;

        if (!$produto_id || $quantidade < 1) {
            $_SESSION['erro'] = "Produto ou quantidade inválidos.";
            header('Location: /produtos');
            exit;
        }

        $produto = Produto::buscarPorId($produto_id);
        if (!$produto) {
            $_SESSION['erro'] = "Produto não encontrado.";
            header('Location: /produtos');
            exit;
        }

        $estoque = Estoque::buscarPorProdutoId($produto_id);
        if (!$estoque || $estoque['quantidade'] < $quantidade) {
            $_SESSION['erro'] = "Estoque insuficiente para o produto {$produto['nome']}.";
            header('Location: /produtos');
            exit;
        }

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$produto_id])) {
            $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$produto_id] = [
                'produto_id' => $produto_id,
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'quantidade' => $quantidade
            ];
        }

        $nova_quantidade = $estoque['quantidade'] - $quantidade;
        Estoque::atualizar($estoque['id'], $nova_quantidade);

        $_SESSION['sucesso'] = "Produto {$produto['nome']} adicionado ao carrinho.";
        header('Location: /produtos');
        exit;
    }

    public function atualizarQuantidade()
    {
        session_start();
        ob_clean();

        header('Content-Type: application/json');
        $input = file_get_contents('php://input');
        $dados = json_decode($input, true);

        $produto_id = $dados['produto_id'] ?? null;
        $action = $dados['action'] ?? null;

        if (!$produto_id || !isset($_SESSION['carrinho'][$produto_id])) {
            echo json_encode(['erro' => 'Produto não encontrado no carrinho.']);
            die();
        }
        if ($action !== 'incrementar' && $action !== 'decrementar') {
            echo json_encode(['erro' => 'Ação inválida.']);
            die();
        }
        $quantidade = $_SESSION['carrinho'][$produto_id]['quantidade'];
        if ($action === 'incrementar') {
            $quantidade++;
            $_SESSION['carrinho'][$produto_id]['preco_total'] = $_SESSION['carrinho'][$produto_id]['preco'] * $quantidade;
        } elseif ($action === 'decrementar') {
            if ($quantidade <= 1) {
                unset($_SESSION['carrinho'][$produto_id]);
                echo json_encode(['sucesso' => true, 'mensagem' => 'aaQuantidade atualizada com sucesso.']);
                die();
            }
            $quantidade--;
            $_SESSION['carrinho'][$produto_id]['preco_total'] = $_SESSION['carrinho'][$produto_id]['preco'] * $quantidade;
        }

        $_SESSION['carrinho'][$produto_id]['quantidade'] = $quantidade;
        

        echo json_encode(['sucesso' => true, 'mensagem' => 'Quantidade atualizada com sucesso.']);
        die();
    }

    public function mostrarCarrinho()
    {
        $carrinho = $_SESSION['carrinho'] ?? [];
        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
        $frete = 0;
        if ($_SESSION['cep']) {
            $frete = calcularFrete($subtotal);
        }
        $total = $subtotal +  $frete;
        $_SESSION['subtotal'] = $subtotal;
        $_SESSION['frete'] = $frete;
        $_SESSION['total'] = $total;

        include __DIR__ . '/../views/pedidos/carrinho.php';

        require_once __DIR__ . '/../models/Cupom.php';

        $desconto = 0;
        $cupom_aplicado = null;

        if (!empty($_GET['cupom'])) {
            $cupom = Cupom::buscarPorCodigo($_GET['cupom']);
            if ($cupom && $subtotal >= $cupom['valor_minimo']) {
                $cupom_aplicado = $cupom;
                $desconto = $cupom['tipo'] == 'percentual'
                    ? $subtotal * ($cupom['valor'] / 100)
                    : $cupom['valor'];
            }
        }

        $total = $subtotal - $desconto + $frete;
    }

    public function finalizar()
    {
        session_start();
        ob_clean();

        if (empty($_SESSION['carrinho'])) {
            echo "Carrinho vazio!";
            return;
        }

        include __DIR__ . '/../views/pedidos/finalizar.php';
    }

    public function finalizarPedido()
    {
        ob_clean();
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');
        $dados = json_decode($input, true);
        $email = $dados['email'] ?? null;

        if (empty($_SESSION['carrinho'])) {
            echo "Carrinho vazio!";
            return;
        }

        Pedido::salvar($_SESSION['carrinho'], $_SESSION['subtotal'], $_SESSION['frete'], $_SESSION['total'], $_SESSION['endereco'], $_SESSION['cep']);
        $mensagem = "<h2>Pedido realizado com sucesso!</h2>";
        foreach ($_SESSION['carrinho'] as $item) {
            $mensagem .= "{$item['nome']} - Qtd: {$item['quantidade']}<br>";
        }
        $mensagem .= "<p>Total: R$ " . number_format($_SESSION['total'], 2, ',', '.') . "</p>";
        $mensagem .= "<p>Endereço: ".$_SESSION['endereco']."</p>";
        include __DIR__ . '/../helpers/mailer.php';
        enviarEmail($email, "Confirmação de Pedido", $mensagem);

        unset($_SESSION['carrinho']);
        unset($_SESSION['subtotal']);
        unset($_SESSION['frete']);
        unset($_SESSION['total']);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Pedido finalizado com sucesso!']);
        die();
    }

    public function removerItem()
    {
        session_start();
        ob_clean();

        header('Content-Type: application/json');

        $produto_id = $_GET['produto_id'] ?? null;

        if (!$produto_id || !isset($_SESSION['carrinho'][$produto_id])) {
            echo json_encode(['erro' => 'Produto não encontrado no carrinho.']);
            die();
        }

        unset($_SESSION['carrinho'][$produto_id]);

        echo json_encode(['sucesso' => true, 'mensagem' => 'Produto removido do carrinho.']);
        die();
    }

    public function calcularFrete()
    {
        session_start();
        ob_clean();

        header('Content-Type: application/json');
        $input = file_get_contents('php://input');
        $dados = json_decode($input, true);
        $cep = $dados['cep'] ?? null;

        if (!$cep) {
            echo json_encode(['erro' => 'CEP não informado.']);
            die();
        }

        require_once __DIR__ . '/../helpers/via_cep.php';

        $dados_cep = buscarEnderecoPorCep($cep);
        if (isset($dados_cep['erro'])) {
            echo json_encode(['erro' => 'CEP inválido.']);
            die();
        }

        $_SESSION['cep'] = $cep;
        $_SESSION['endereco'] = $dados_cep['logradouro'] . ', ' . $dados_cep['bairro'] . ', ' . $dados_cep['localidade'] . ' - ' . $dados_cep['uf'];

        echo json_encode(['sucesso' => true, 'endereco' => $dados_cep]);
        die();
    }
}

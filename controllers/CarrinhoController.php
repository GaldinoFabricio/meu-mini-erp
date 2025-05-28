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

        // Limpa qualquer output anterior
        ob_clean();

        // Define o header JSON
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

        // Iniciar carrinho se não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Adiciona ou atualiza item
        if (isset($_SESSION['carrinho'][$produto_id])) {
            $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
            $_SESSION['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$produto_id] = [
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
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

        // Buscar produto
        $produto = Produto::buscarPorId($produto_id);
        if (!$produto) {
            $_SESSION['erro'] = "Produto não encontrado.";
            header('Location: /produtos');
            exit;
        }

        // Buscar estoque do produto
        $estoque = Estoque::buscarPorProdutoId($produto_id);
        if (!$estoque || $estoque['quantidade'] < $quantidade) {
            $_SESSION['erro'] = "Estoque insuficiente para o produto {$produto['nome']}.";
            header('Location: /produtos');
            exit;
        }

        // Inicia carrinho na sessão, se não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Se produto já está no carrinho, soma quantidade
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

        // Atualiza o estoque no banco (reduz a quantidade)
        $nova_quantidade = $estoque['quantidade'] - $quantidade;
        Estoque::atualizar($estoque['id'], $nova_quantidade);

        $_SESSION['sucesso'] = "Produto {$produto['nome']} adicionado ao carrinho.";
        header('Location: /produtos');
        exit;
    }

    public function mostrarCarrinho()
    {
        $carrinho = $_SESSION['carrinho'] ?? [];
        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
        $frete = calcularFrete($subtotal);
        $total = $subtotal + $frete;

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

    public function finalizarPedido()
    {
        $endereco = $_POST['endereco'];
        $cep = $_POST['cep'];

        require_once __DIR__ . '/../helpers/via_cep.php';

        $dados_cep = buscarEnderecoPorCep($cep);
        if (isset($dados_cep['erro'])) {
            echo "CEP inválido!";
            return;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];
        if (empty($carrinho)) {
            echo "Carrinho vazio!";
            return;
        }

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
        $frete = calcularFrete($subtotal);
        $total = $subtotal + $frete;

        Pedido::salvar($carrinho, $subtotal, $frete, $total, $endereco, $cep);

        require_once __DIR__ . '/../helpers/mailer.php';

        $mensagem = "<h2>Pedido Realizado</h2>";
        foreach ($carrinho as $item) {
            $mensagem .= "{$item['nome']} - Qtd: {$item['quantidade']}<br>";
        }
        $mensagem .= "<p>Total: R$ " . number_format($total, 2, ',', '.') . "</p>";
        $mensagem .= "<p>Endereço: $endereco</p>";

        enviarEmail("cliente@email.com", "Confirmação de Pedido", $mensagem);

        unset($_SESSION['carrinho']); // limpa carrinho
        echo "Pedido finalizado com sucesso!";
    }
}

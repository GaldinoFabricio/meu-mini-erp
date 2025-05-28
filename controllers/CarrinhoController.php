<?php
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../helpers/functions.php';

session_start();

class CarrinhoController
{
    public function adicionar()
    {
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'] ?? 1;

        $produto = Produto::buscarPorId($produto_id);
        if (!$produto) {
            echo "Produto não encontrado";
            return;
        }

        $_SESSION['carrinho'][$produto_id] = [
            'nome' => $produto['nome'],
            'preco' => $produto['preco'],
            'quantidade' => $quantidade
        ];

        header("Location: /carrinho");
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

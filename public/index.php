<?php
require_once __DIR__ . '/../controllers/ProdutoController.php';
require_once __DIR__ . '/../controllers/CarrinhoController.php';


$uri = $_SERVER['REQUEST_URI'];
$metodo = $_SERVER['REQUEST_METHOD'];

$produtoController = new ProdutoController();

if ($uri === '/' && $metodo === 'GET') {
    $produtoController->index();
} elseif ($uri === '/salvar' && $metodo === 'POST') {
    $produtoController->salvar();
} else {
    echo "Página não encontrada.";
}

$carrinhoController = new CarrinhoController();

if ($uri === '/adicionar' && $metodo === 'POST') {
    $carrinhoController->adicionar();
} elseif ($uri === '/carrinho' && $metodo === 'GET') {
    $carrinhoController->mostrarCarrinho();
} elseif ($uri === '/finalizar-pedido' && $metodo === 'POST') {
    $carrinhoController->finalizarPedido();
}

require_once __DIR__ . '/../controllers/WebhookController.php';

$webhookController = new WebhookController();

if ($uri === '/webhook' && $metodo === 'POST') {
    $webhookController->receber();
}

require_once __DIR__ . '/../routes/web.php';

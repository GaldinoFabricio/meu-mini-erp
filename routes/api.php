<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Remove barra final (se houver)
$uri = rtrim($uri, '/');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

switch ($uri) {
    case '/api/produtos/salvar':
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->salvar();
        break;

    case '/api/estoques/salvar':
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->salvar();
        break;

    case (preg_match('#^/api/estoques/editar$#', $uri) ? true : false):
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->editar();
        break;

    case '/api/cupons/criar':
        require_once __DIR__ . '/../controllers/CupomController.php';
        $controller = new CupomController();
        $controller->criar();
        break;

    case '/api/carrinho/adicionar':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->adicionar();
        // NÃO adicione break aqui - o método adicionar() já faz die()
        break;
    
    case (preg_match('#^/api/carrinho/remover$#', $uri) ? true : false):
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->removerItem();
        // NÃO adicione break aqui - o método adicionar() já faz die()
        break;
    
    case '/api/carrinho/atuaizar-quantidade':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->atualizarQuantidade();
        break;
    
    case '/api/carrinho/calcular-frete':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->calcularFrete();
        break;

    case '/api/carrinho/comprar':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->comprar();
        break;

    case '/api/pedido/finalizar-pedido':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->finalizarPedido();
        break;

    case '/api/webhook':
        require_once __DIR__ . '/../controllers/WebhookController.php';
        $controller = new WebhookController();
        $controller->receber();
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada";
        break;
}

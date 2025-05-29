<?php
// Simples roteador básico para PHP puro

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
    case '/':
    case '/produtos':
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->index();
        break;

    case '/produtos/salvar':
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->salvar();
        break;

    case '/estoques':
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->form();
        break;

    case '/estoques/salvar':
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->salvar();
        break;

    case (preg_match('#^/estoques/editar$#', $uri) ? true : false):
        require_once __DIR__ . '/../controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $controller->editar();
        break;

    case '/cupons':
        require_once __DIR__ . '/../controllers/CupomController.php';
        $controller = new CupomController();
        $controller->gerenciar();
        break;

    case '/cupons/criar':
        require_once __DIR__ . '/../controllers/CupomController.php';
        $controller = new CupomController();
        $controller->criar();
        break;

    case '/carrinho':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->mostrarCarrinho();
        break;

    case '/carrinho/adicionar':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->adicionar();
        // NÃO adicione break aqui - o método adicionar() já faz die()
        break;
    
    case (preg_match('#^/carrinho/remover$#', $uri) ? true : false):
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->removerItem();
        // NÃO adicione break aqui - o método adicionar() já faz die()
        break;

    case '/carrinho/comprar':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->comprar();
        break;

    case '/pedido/finalizar':
        require_once __DIR__ . '/../controllers/CarrinhoController.php';
        $controller = new CarrinhoController();
        $controller->finalizarPedido();
        break;

    case '/webhook':
        require_once __DIR__ . '/../controllers/WebhookController.php';
        $controller = new WebhookController();
        $controller->receber();
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada";
        break;
}

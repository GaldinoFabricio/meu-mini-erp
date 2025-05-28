<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">
    <h2>Cadastro de Produto</h2>
    <form action="/salvar" method="POST">
        <input type="text" name="nome" placeholder="Nome" class="form-control mb-2" required>
        <input type="number" step="0.01" name="preco" placeholder="Preço" class="form-control mb-2" required>
        <input type="number" name="estoque" placeholder="Estoque" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <h3 class="mt-5">Produtos Cadastrados</h3>
    <ul class="list-group">
        <?php foreach ($produtos as $p): ?>
            <li class="list-group-item">
                <?= $p['nome'] ?> - R$ <?= number_format($p['preco'], 2, ',', '.') ?> - Estoque: <?= $p['estoque'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <form action="/adicionar" method="POST" class="d-inline">
        <input type="hidden" name="produto_id" value="<?= $p['id'] ?>">
        <input type="number" name="quantidade" value="1" min="1" class="form-control d-inline w-auto">
        <button type="submit" class="btn btn-sm btn-success">Comprar</button>
    </form>

</body>

</html>
<h2>Carrinho</h2>
<?php if (empty($carrinho)): ?>
    <p>Seu carrinho está vazio.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Qtd</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carrinho as $item): ?>
                <tr>
                    <td><?= $item['nome'] ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><strong>Subtotal:</strong> R$ <?= number_format($subtotal, 2, ',', '.') ?></p>
    <p><strong>Frete:</strong> R$ <?= number_format($frete, 2, ',', '.') ?></p>
    <p><strong>Total:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>

    <form method="GET" action="/carrinho" class="mb-3">
        <input type="text" name="cupom" class="form-control w-25 d-inline" placeholder="Cupom" value="<?= $_GET['cupom'] ?? '' ?>">
        <button class="btn btn-info">Aplicar</button>
    </form>

    <?php if ($cupom_aplicado): ?>
        <p><strong>Cupom aplicado:</strong> <?= $cupom_aplicado['codigo'] ?> (-R$ <?= number_format($desconto, 2, ',', '.') ?>)</p>
    <?php endif; ?>

    <form method="POST" action="/finalizar-pedido">
        <input type="text" name="cep" placeholder="CEP" class="form-control mb-2" required>
        <input type="text" name="endereco" placeholder="Endereço completo" class="form-control mb-2" required>
        <button type="submit" class="btn btn-success">Finalizar Pedido</button>
    </form>
<?php endif; ?>
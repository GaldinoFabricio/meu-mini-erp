<h2>Estoque</h2>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($estoques)): ?>
            <?php foreach ($estoques as $estoque): ?>
                <tr>
                    <td><?= htmlspecialchars($estoque['nome']) ?></td>
                    <td><?= (int)$estoque['quantidade'] ?></td>
                    <td>
                        <a href="/estoques/editar?id=<?= $estoque['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center">Nenhum estoque cadastrado.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../templates/footer.php'; ?>

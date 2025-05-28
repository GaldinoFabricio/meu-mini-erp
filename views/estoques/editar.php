<h2>Editar Estoque - Produto: <?= htmlspecialchars($estoque['produto_id']) ?></h2>

<form method="POST" action="/estoques/editar?id=<?= $estoque['id'] ?>">
    <div class="mb-3">
        <label for="quantidade" class="form-label">Quantidade</label>
        <input type="number" id="quantidade" name="quantidade" value="<?= (int)$estoque['quantidade'] ?>" min="0" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="/estoques" class="btn btn-secondary">Cancelar</a>
</form>

<?php include __DIR__ . '/../templates/footer.php'; ?>

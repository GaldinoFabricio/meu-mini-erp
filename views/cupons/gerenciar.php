<?php include __DIR__ . '/../templates/header.php'; ?>

<h2>Gerenciar Cupons</h2>

<form method="POST" class="mb-4">
    <div class="mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" id="codigo" name="codigo" class="form-control" required />
    </div>
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select id="tipo" name="tipo" class="form-select" required>
            <option value="fixo">Valor Fixo</option>
            <option value="percentual">Percentual (%)</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="valor" class="form-label">Valor</label>
        <input type="number" step="0.01" id="valor" name="valor" class="form-control" required />
    </div>
    <div class="mb-3">
        <label for="valor_minimo" class="form-label">Valor Mínimo do Pedido</label>
        <input type="number" step="0.01" id="valor_minimo" name="valor_minimo" class="form-control" required />
    </div>
    <div class="mb-3">
        <label for="validade" class="form-label">Validade</label>
        <input type="date" id="validade" name="validade" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary">Adicionar Cupom</button>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Valor Mínimo</th>
            <th>Validade</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cupons as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['codigo']) ?></td>
                <td><?= htmlspecialchars($c['tipo']) ?></td>
                <td><?= number_format($c['valor'], 2, ',', '.') ?></td>
                <td><?= number_format($c['valor_minimo'], 2, ',', '.') ?></td>
                <td><?= $c['validade'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../templates/footer.php'; ?>

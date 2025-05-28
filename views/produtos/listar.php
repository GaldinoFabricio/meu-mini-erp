<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px;">
    <h3>Produtos</h3>
    <a href="/produtos/criar"
        style="text-decoration: none; padding: 10px 20px; background-color: #28a745; color: white; border-radius: 5px; font-weight: bold;">
        + Novo Produto
    </a>
</div>
<section style="display: flex; flex-wrap: wrap; gap: 20px; padding: 10px;">
    <?php foreach ($produtos as $p): ?>
        <article style="display: flex; flex-direction: column; align-items: center; width: 220px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #fafafa; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h4 style="font-size: 1.5rem; text-align: center; margin: 0 0 10px;"><?= htmlspecialchars($p['nome']) ?></h4>

            <figure style="margin: 0;">
                <img
                    src="<?= htmlspecialchars($p['imagem'] ?? 'placeholder.jpg') ?>"
                    alt="Imagem de <?= htmlspecialchars($p['nome']) ?>"
                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 6px; background-color: #f1f1f1;">
            </figure>

            <p style="margin: 10px 0 0; font-weight: bold;">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
            <p style="margin: 5px 0 10px; font-size: 0.9rem; color: #666;">Estoque: <?= $p['estoque'] ?></p>

            <a onclick="adicionarAoCarrinho(<?= $p['id'] ?>)"
                style="text-decoration: none; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">
                Comprar
            </a>
        </article>
    <?php endforeach; ?>
</section>

<script>
    function adicionarAoCarrinho(produtoId) {
        fetch(`/carrinho/adicionar?produto_id=${produtoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    alert(data.mensagem);
                    window.location.reload();
                } else {
                    alert(data.erro);
                }
            })
            .catch(error => console.error('Erro ao adicionar produto ao carrinho:', error));
    }
</script>
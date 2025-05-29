<h2>Carrinho</h2>

<?php if (empty($carrinho)): ?>
    <p>Seu carrinho está vazio.</p>
<?php else: ?>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div style="grid-column: 1 / 3;">
            <?php foreach ($carrinho as $key => $item): ?>
                <div class="item-carrinho" style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #ccc;">
                    <div class="coluna" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <img src="<?= $item['imagem'] ?>" alt="<?= $item['nome'] ?>" class="img-produto">
                        <span><?= $item['nome'] ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="cursor: pointer;" onclick="updatedQuantidade(<?= $key ?>, 'decrementar')">-</span>
                        <span class="coluna"><?= $item['quantidade'] ?></span>
                        <span style="cursor: pointer;" onclick="updatedQuantidade(<?= $key ?>, 'incrementar')">+</span>
                    </div>
                    <div class="coluna">R$ <?= number_format($item['preco_total'], 2, ',', '.') ?></div>
                    <div class="coluna">
                        <button onclick="remover(<?= $key ?>)">Remover</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="background-color: #f1f1f1; padding: 20px; border-radius: 5px; gap: 20px; display: flex; flex-direction: column;">
            <h3>SubTotal: R$ <?= number_format($total, 2, ',', '.') ?></h3>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <span>Entrega</span>
                <div>
                    <input type="text" name="cep" placeholder="XXXXX-XXX" style="height: 100%; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                    <button onclick="buscarCEP()" class="btn btn-info">Buscar</button>
                </div>
                <span class="endereco"><?=$_SESSION['endereco']?></span>
            </div>
            <button onclick="finalizarPedido()" class="btn btn-success" style="width: 100%;">Ir para finalizar pedidoS</button>
        </div>
    </div>
<?php endif; ?>

<script>
    function remover(id) {
        fetch('/carrinho/remover?produto_id=' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    //alert(data.mensagem);
                    window.location.reload();
                    return;
                } else {
                    alert('Erro ao remover item do carrinho.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao remover item do carrinho.');
            });
    }

    function buscarCEP() {
        const cep = document.querySelector('input[name="cep"]').value.replace(/\D/g, '');
        fetch('/carrinho/calcular-frete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cep: cep })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar CEP');
                }
                return response;
            })
            .then(response => response.json())
            .then(data => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao buscar CEP.');
            });
    }

    function updatedQuantidade(id, action) {
        fetch('/carrinho/atuaizar-quantidade', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    produto_id: id,
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                window.location.reload();
                return;
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao atualizar quantidade.');
            });
    }
    document.querySelectorAll('.item-carrinho').forEach(item => {
        item.querySelector('.btn-remover').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            remover(id);
        });
    });

    function finalizarPedido() {
        
        window.location.href = '/pedido/finalizar';
        /*fetch('/carrinho/comprar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/pedido/finalizar';
                } else {
                    alert('Erro ao finalizar pedido.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao finalizar pedido.');
            });*/
    }
</script>
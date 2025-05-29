<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px;">
    <h3>Criar Produtos</h3>
</div>
<div class="editar-criar" style="display: flex; flex-wrap: wrap; gap: 20px; padding: 10px;">
    <input type="text" name="nome" placeholder="Nome" class="form-control mb-2" required>
    <input type="number" step="0.01" name="preco" placeholder="Preço" class="form-control mb-2" required>
    <input type="number" name="estoque" placeholder="Estoque" class="form-control mb-2" required>
    <button type="submit" class="salvar btn btn-primary" onclick="criarProduto()">Salvar</button>
</div>
<div>
    <h3>Produtos Criados</h3>
    <?php if ($Produtos) {?>
    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Qtd</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Produtos as $item): ?>
                <tr>
                    <td><?= $item['nome'] ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td><?= $item['estoque'] ?></td>
                    <td>
                        <a onClick="editarProduto(<?=$item['id']?>,'<?=$item['nome']?>','<?=$item['preco']?>','<?=$item['estoque']?>')" class="btn btn-sm btn-warning">Editar</a>
                        <a href="/estoques/excluir?id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php } else { ?>
        <p>Nenhum produto criado ainda.</p>
    <?php } ?>
</div>
<script>
    function criarProduto() {
        const nome = document.querySelector('input[name="nome"]').value;
        const preco = parseFloat(document.querySelector('input[name="preco"]').value);
        const estoque = parseInt(document.querySelector('input[name="estoque"]').value);

        if (!nome || isNaN(preco) || isNaN(estoque)) {
            alert("Por favor, preencha todos os campos corretamente.");
            return;
        }

        fetch('/estoques/salvar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nome, preco, estoque })
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                alert("Produto criado com sucesso!");
                window.location.href = '/produtos';
            } else {
                alert("Erro ao criar produto: " + data.erro);
            }
        })
        .catch(error => {
            console.error('Erro ao criar produto:', error);
            alert("Ocorreu um erro ao criar o produto. Tente novamente mais tarde.");
        });
    }

    editarProduto = (id, nome, preço, qtd) => {
        const nomeInput = document.querySelector('input[name="nome"]');
        const precoInput = document.querySelector('input[name="preco"]');
        const estoqueInput = document.querySelector('input[name="estoque"]');

        nomeInput.value = nome;
        precoInput.value = preço;
        estoqueInput.value = qtd;

        // Atualiza o botão para salvar como editar
        document.querySelector('.salvar').style.display = "none";
        
        const editarButton = document.createElement('button');
        editarButton.textContent = "Editar Produto";
        editarButton.className = "btn btn-warning";
        editarButton.onclick = () => editarProdutoConfirmado(id);
        document.querySelector('.editar-criar').appendChild(editarButton);
        

    }

    editarProdutoConfirmado = (id) => {
        alert("aqui");
        const nome = document.querySelector('input[name="nome"]').value;
        const preco = parseFloat(document.querySelector('input[name="preco"]').value);
        const estoque = parseInt(document.querySelector('input[name="estoque"]').value);

        if (!nome || isNaN(preco) || isNaN(estoque)) {
            alert("Por favor, preencha todos os campos corretamente.");
            return;
        }

        fetch(`/estoques/editar?id=${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nome, preco, estoque })
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                alert("Produto editado com sucesso!");
                window.location.href = '/produtos';
            } else {
                alert("Erro ao editar produto: " + data.erro);
            }
        })
        .catch(error => {
            console.error('Erro ao editar produto:', error);
            alert("Ocorreu um erro ao editar o produto. Tente novamente mais tarde.");
        });
    }
</script>
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px;">
    <h3>Criar Produtos</h3>
    <a href="/produtos/criar"
        style="text-decoration: none; padding: 10px 20px; background-color:rgb(167, 40, 57); color: white; border-radius: 5px; font-weight: bold;">
        <- Voltar
    </a>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 10px;">
    <input type="text" name="nome" placeholder="Nome" class="form-control mb-2" required>
    <input type="number" step="0.01" name="preco" placeholder="Preço" class="form-control mb-2" required>
    <input type="number" name="estoque" placeholder="Estoque" class="form-control mb-2" required>
    <button type="submit" class="btn btn-primary" onclick="criarProduto()">Salvar</button>
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

        fetch('/produtos/criar', {
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
</script>
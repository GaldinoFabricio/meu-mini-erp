<style>
    .pedido-finalizado {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .success-container, .email-container {
        background: #fff;
        padding: 40px 60px;
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .success-icon {
        font-size: 60px;
        color: #27ae60;
        margin-bottom: 20px;
    }

    .success-message {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    .success-detail {
        color: #666;
        margin-bottom: 30px;
    }

    .btn-home, .btn-send {
        display: inline-block;
        padding: 12px 30px;
        background: #27ae60;
        color: #fff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        transition: background 0.2s;
        cursor: pointer;
    }

    .btn-home:hover, .btn-send:hover {
        background: #219150;
    }

    .input-email {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 15px;
        font-size: 16px;
    }
</style>

<section class="pedido-finalizado">
    <div class="email-container" id="email-container">
        <h2>Informe seu e-mail para finalizar o pedido</h2>
        <input type="email" id="email" class="input-email" placeholder="Digite seu e-mail" required>
        <button class="btn-send" id="sendEmailBtn">Enviar</button>
        <div id="email-error" style="color: #e74c3c; margin-top: 10px; display: none;"></div>
    </div>

    <div class="success-container" id="success-container" style="display: none;">
        <div class="success-icon">&#10004;</div>
        <div class="success-message">Pedido finalizado com sucesso!</div>
        <div class="success-detail">Obrigado por comprar conosco.<br>Em breve você receberá mais informações por e-mail.</div>
        <a href="/pedidos" class="btn-home">Voltar para pedidos</a>
    </div>
</section>

<script>
document.getElementById('sendEmailBtn').addEventListener('click', function() {
    var emailInput = document.getElementById('email');
    var email = emailInput.value.trim();
    var errorDiv = document.getElementById('email-error');
    errorDiv.style.display = 'none';

    if (!email || !validateEmail(email)) {
        errorDiv.textContent = 'Por favor, insira um e-mail válido.';
        errorDiv.style.display = 'block';
        return;
    }

    fetch('/pedido/finalizar-pedido', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ email: email })
    })
    .then(response => {
        if (!response.ok) throw new Error('Erro ao finalizar pedido');
        return response.json();
    })
    .then(data => {
        document.getElementById('email-container').style.display = 'none';
        document.getElementById('success-container').style.display = 'block';
    })
    .catch(error => {
        errorDiv.textContent = 'Erro ao enviar. Tente novamente.';
        errorDiv.style.display = 'block';
    });
});

function validateEmail(email) {
    // Simple email validation
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
</script>
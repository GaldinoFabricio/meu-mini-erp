# 💼 Mini ERP em PHP Puro

Este projeto é um mini ERP desenvolvido como parte de um processo seletivo. Ele permite o gerenciamento de produtos, estoque, carrinho de compras, aplicação de cupons, cálculo de frete, finalização de pedidos com envio de e-mail, e integração com ViaCEP e Webhook de atualização de status.

---

## 🚀 Tecnologias Utilizadas

- **PHP Puro (MVC simples)**
- **MySQL**
- **Bootstrap 5**
- **ViaCEP API**
- **Envio de e-mails via `mail()`**
- **JSON Webhook Receiver**

---

## 🛠️ Funcionalidades

- ✅ Cadastro de produtos e controle de estoque
- ✅ Carrinho de compras via sessão
- ✅ Cálculo de frete (com regras por subtotal)
- ✅ Aplicação de cupons (fixo ou percentual)
- ✅ Verificação de endereço via API [ViaCEP](https://viacep.com.br/)
- ✅ Envio de e-mail ao finalizar o pedido
- ✅ Webhook para atualização ou cancelamento de pedidos

---

## 📂 Estrutura de Pastas

/meu-mini-erp/
│
├── config/
│   └── database.php          # Conexão com MySQL
│
├── controllers/
│   ├── ProdutoController.php
│   ├── PedidoController.php
│   ├── CupomController.php
│   ├── EstoqueController.php
│   └── WebhookController.php
│
├── models/
│   ├── Produto.php
│   ├── Pedido.php
│   ├── Cupom.php
│   ├── Estoque.php
│   └── Database.php          # Classe genérica de conexão
│
├── views/
│   ├── templates/
│   │   ├── header.php
│   │   └── footer.php
│   ├── produtos/
│   │   └── form.php          # Tela de cadastro e edição
│   ├── pedidos/
│   │   └── carrinho.php      # Carrinho e finalização
│   └── cupons/
│       └── gerenciar.php
│
├── public/
│   ├── index.php             # Roteador principal
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── assets/
│       └── (imagens etc.)
│
├── sql/
│   └── estrutura.sql         # Script para criar as 4 tabelas
│
├── helpers/
│   ├── functions.php         # Funções genéricas (ex: validar CEP, calcular frete)
│   └── mailer.php            # Script para envio de e-mail
│
├── routes/
│   └── web.php               # Define as rotas (se desejar fazer um mini router)
│
├── .gitignore
├── README.md
└── composer.json (opcional)


---

## ⚙️ Como Rodar Localmente

1. Clone o projeto:
   ```bash
   git clone https://github.com/seu-usuario/meu-mini-erp.git
   
   sql/estrutura.sql
   
   http://localhost/meu-mini-erp/public/
   

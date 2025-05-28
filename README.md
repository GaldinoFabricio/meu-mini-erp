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
├── config/ # Conexão com banco
├── controllers/ # Lógica de negócio
├── models/ # Interações com o BD
├── views/ # Interface com Bootstrap
├── public/ # Ponto de entrada (index.php)
├── helpers/ # Funções extras (frete, e-mail, cep)
├── sql/estrutura.sql # Script SQL
└── README.md


---

## ⚙️ Como Rodar Localmente

1. Clone o projeto:
   ```bash
   git clone https://github.com/seu-usuario/meu-mini-erp.git
   
   sql/estrutura.sql
   
   http://localhost/meu-mini-erp/public/
   

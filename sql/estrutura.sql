CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    itens TEXT,
    subtotal DECIMAL(10, 2),
    frete DECIMAL(10, 2),
    total DECIMAL(10, 2),
    endereco VARCHAR(255),
    cep VARCHAR(10),
    status VARCHAR(20),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL,
    tipo ENUM('percentual', 'fixo') NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    valor_minimo DECIMAL(10,2) NOT NULL,
    validade DATE NOT NULL
);


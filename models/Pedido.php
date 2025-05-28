<?php
require_once 'Database.php';

class Pedido {
    public static function salvar($carrinho, $subtotal, $frete, $total, $endereco, $cep) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO pedidos (itens, subtotal, frete, total, endereco, cep, status) VALUES (?, ?, ?, ?, ?, ?, 'novo')");
        $stmt->execute([
            json_encode($carrinho),
            $subtotal,
            $frete,
            $total,
            $endereco,
            $cep
        ]);
    }
}

<?php
require_once 'Database.php';

class Estoque {
    public static function buscarTodos() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT e.*, p.nome FROM estoque e JOIN produtos p ON e.produto_id = p.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM estoque WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizar($id, $quantidade) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE estoque SET quantidade = ? WHERE id = ?");
        $stmt->execute([$quantidade, $id]);
    }

    public static function criar($produto_id, $quantidade) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO estoque (produto_id, quantidade) VALUES (?, ?)");
        $stmt->execute([$produto_id, $quantidade]);
    }

    public static function buscarPorProdutoId($produto_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM estoque WHERE produto_id = ?");
        $stmt->execute([$produto_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

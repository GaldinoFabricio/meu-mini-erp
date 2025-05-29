<?php
require_once 'Database.php';

class Produto
{
    public static function listarTodos()
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM produtos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function salvar($nome, $preco, $estoque)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, estoque) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $preco, $estoque]);
    }

    public static function buscarPorId($id)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizar($id, $nome, $preco, $estoque)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, estoque = ? WHERE id = ?");
        $stmt->execute([$nome, $preco, $estoque, $id]);
    }
}

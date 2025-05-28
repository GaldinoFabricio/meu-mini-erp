<?php
require_once 'Database.php';

class Cupom
{
    public static function buscarPorCodigo($codigo)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM cupons WHERE codigo = ? AND validade >= CURDATE()");
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function criar($codigo, $tipo, $valor, $valor_minimo, $validade)
    {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO cupons (codigo, tipo, valor, valor_minimo, validade) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Sanitiza e formata os dados, se quiser pode validar aqui também

        $stmt->execute([
            $codigo,
            $tipo,
            $valor,
            $valor_minimo,
            $validade
        ]);
    }

    public static function buscarTodos() {
        $pdo = Database::getConnection();

        $stmt = $pdo->query("SELECT * FROM cupons ORDER BY validade DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

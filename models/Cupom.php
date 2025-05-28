<?php
require_once 'Database.php';

class Cupom {
    public static function buscarPorCodigo($codigo) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM cupons WHERE codigo = ? AND validade >= CURDATE()");
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

<?php
require_once __DIR__ . '/../models/Database.php';

class WebhookController {
    public function receber() {
        $data = json_decode(file_get_contents('php://input'), true);

        $pedido_id = $data['id'] ?? null;
        $status = $data['status'] ?? null;

        if (!$pedido_id || !$status) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados inválidos']);
            return;
        }

        $pdo = Database::getConnection();

        if ($status === 'cancelado') {
            $stmt = $pdo->prepare("DELETE FROM pedidos WHERE id = ?");
            $stmt->execute([$pedido_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
            $stmt->execute([$status, $pedido_id]);
        }

        echo json_encode(['sucesso' => true]);
    }
}

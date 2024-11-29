<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['username'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografa a senha
    
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$usuario, $email, $senha]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') { // Verifica erro de duplicidade (chave única)
            echo json_encode(['success' => false, 'message' => 'Usuário ou email já existe']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar: ' . $e->getMessage()]);
        }
    }
}

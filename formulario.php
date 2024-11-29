<?php
// Configurações do banco de dados
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'chacara_eventos';

// Conectando ao banco de dados
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $telefone = $_POST['telefone'] ?? null;
    $tipo_evento = $_POST['tipo_evento'] ?? null;
    $data = $_POST['data'] ?? null;
    $num_pessoas = $_POST['num_pessoas'] ?? null;
    $mensagem = $_POST['mensagem'] ?? null;

    // Prepara o SQL de inserção
    $stmt = $conn->prepare("
        INSERT INTO contatos (nome, email, telefone, tipo_evento, data, num_pessoas, mensagem) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    // Liga os parâmetros
    $stmt->bind_param("sssssis", $nome, $email, $telefone, $tipo_evento, $data, $num_pessoas, $mensagem);

    // Executa o SQL e verifica o resultado
    if ($stmt->execute()) {
        echo "Formulário enviado com sucesso!";
    } else {
        echo "Erro ao enviar formulário: " . $stmt->error;
    }

    // Fecha a declaração e a conexão
    $stmt->close();
}

$conn->close();
?>

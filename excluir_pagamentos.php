<?php
// excluir_pagamentos.php

// Configurações do banco de dados
include 'conexao.php';

// Verifica se o ID do pagamento foi enviado corretamente via GET

$id_pagamento = (int) $_GET['id_pagamento']; // Sanitiza o ID


// Supondo que você tenha a informação do usuário logado via sessão
session_start();
if (!isset($_SESSION['id_usuario'])) {
    die("Usuário não autenticado.");
}
$id_usuario = $_SESSION['id_usuario'];

// Prepara e executa a query de atualização
$sql = "UPDATE pagamentos 
        SET oculto = 1, id_usuario = :id_usuario, data_exclusao = NOW() 
        WHERE id_pagamento = :id_pagamento";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_pagamento', $id_pagamento, PDO::PARAM_INT);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

if ($stmt->execute()) {
    // Redireciona após sucesso
    header("Location: pagamentos_main.php");
    exit;
} else {
    echo "Erro ao alterar registro.";
}
?>


<?php
// processa_incluir_forma_pagamentos.php
include 'conexao.php'; // conectamos o banco de dados
$descricao_forma = $_POST['descricao_forma'];

try {
    $sql = "INSERT INTO forma_pagamentos (descricao_forma) VALUES (:descricao_forma)";
    $stmt = $pdo->prepare($sql); // Adicionei esta linha para preparar a declaração SQL
    $stmt->bindParam(':descricao_forma', $descricao_forma);

    if ($stmt->execute()) {
        header("Location:forma_pagamentos_main.php");
    } else {
        echo "Erro ao inserir registro.";
    }
} catch (PDOException $e) {
    // Excessão, onde é exibido o erro segundo o PHP
    echo "Erro: " . $e->getMessage();
}
?>
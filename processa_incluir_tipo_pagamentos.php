<?php
// processa_incluir_tipo_pagamentos.php
include 'conexao.php'; // conectamos o banco de dados
$descricao_tipo = $_POST ['descricao_tipo'];

try {
$sql = "INSERT INTO tipo_pagamentos (descricao_tipo) VALUES (:descricao_tipo)";
$stmt = $pdo->prepare($sql); // Adicionei esta linha para preparar a declaração SQL
$stmt->bindParam('descricao_tipo', $descricao_tipo);

if ($stmt->execute()) {
    header("Location:fornecedores_main.php");
}
else {
    echo "Erro ao inserir registro.";
}
} catch (PDOException $e) {
    // Excessão, onde é exibido o erro segundo o PHP
    echo "Erro: " . $e->getMessage();
}


?>
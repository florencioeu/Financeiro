<?php
// processa_editar_forma_pagamentos.php
include 'conexao.php'; // Conectamos ao banco de dados
$id_forma_pagto = $_POST['id_forma_pagto']; // Chave {Não é alterada}
$descricao_forma = $_POST['descricao_forma'];
try {
    $sql = "UPDATE forma_pagamentos SET
        descricao_forma = :descricao_forma
        where id_forma_pagto = :id_forma_pagto";
    $stmt = $pdo->prepare($sql); // Prepara a declaração SQL
    $stmt->bindParam(':id_forma_pagto', $id_forma_pagto, PDO::PARAM_INT);
    $stmt->bindParam(':descricao_forma', $descricao_forma);
    if ($stmt->execute()) {
        header("Location: forma_pagamentos_main.php"); // Retorna para a página de consulta
    } else {
        echo "Erro ao alterar registro.";
    }
} catch (PDOException $e) {
    // Exceção, onde é exibido o erro segundo o PHP
    echo "Erro: " . $e->getMessage();
}
?>
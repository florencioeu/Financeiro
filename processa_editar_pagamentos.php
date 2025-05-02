<?php
include 'conexao.php';  // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pagamento = $_POST['id_pagamento'];
    $data_vcto = $_POST['data_vcto'];
    $id_fornecedor = $_POST['id_fornecedor'];
    $descricao = $_POST['descricao'];
    $id_tipo_pagto = $_POST['id_tipo_pagto'];
    $id_forma_pagto = $_POST['id_forma_pagto'];
    $valor = $_POST['valor'];

    // SQL para atualizar o pagamento
    $sql = "UPDATE pagamentos SET 
                data_vcto = :data_vcto,
                id_fornecedor = :id_fornecedor,
                descricao = :descricao,
                id_tipo_pagto = :id_tipo_pagto,
                id_forma_pagto = :id_forma_pagto,
                valor = :valor
            WHERE id_pagamento = :id_pagamento";

    $stmt = $pdo->prepare($sql);

    // Bind dos parâmetros
    $stmt->bindParam(':data_vcto', $data_vcto);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':id_tipo_pagto', $id_tipo_pagto);
    $stmt->bindParam(':id_forma_pagto', $id_forma_pagto);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':id_pagamento', $id_pagamento);

    // Executa a query e redireciona com o status
    if ($stmt->execute()) {
        header("Location: pagamentos_main.php?status=success&acao=editar");
    } else {
        header("Location: pagamentos_main.php?status=error&acao=editar");
    }
    exit;
}
?>

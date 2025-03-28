<?php
// processa_editar_pagamentos.php
include 'conexao.php'; // Conectamos ao banco de dados
$id_pagamento = $_POST['id_pagamento']; // Chave {Não é alterada}
$id_fornecedor = $_POST['id_fornecedor'];
$data_vcto = $_POST['data_vcto'];
$descricao = $_POST['descricao'];
$id_forma_pagto = $_POST['id_forma_pagto'];
$id_tipo_pagto = $_POST['id_tipo_pagto'];
$valor = $_POST['valor']; ;
// try = tentar
try {
    //  Query de alteração
    $sql = "UPDATE pagamentos SET data_vcto = :data_vcto, id_fornecedor = :id_fornecedor,  descricao = :descricao, id_forma_pagto = :id_forma_pagto, id_tipo_pagto = :id_tipo_pagto, valor = :valor where id_pagamento = :id_pagamento";
    // Preparação para o PDO
    $stmt = $pdo->prepare($sql); // Prepara a declaração SQL
    $stmt->bindParam(':id_pagamento', $id_pagamento, PDO::PARAM_INT);
    $stmt->bindParam(':data_vcto', $data_vcto);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':id_forma_pagto', $id_forma_pagto);
    $stmt->bindParam(':id_tipo_pagto', $id_tipo_pagto);
    $stmt->bindParam(':valor', $valor);
    // executa a query
    if ($stmt->execute()) {
        // retorna para a lista dos pagamentos
        header("Location: pagamentos_main.php"); // Retorna para a página de consulta
    } else {
        echo "Erro ao alterar registro.";
    }
} catch (PDOException $e) {
    // Exceção, onde é exibido o erro segundo o PHP
    echo "Erro: " . $e->getMessage();
}
?>
<?php
include 'conexao.php';
$id_pagamento = $_POST['id_pagamento'];
$data_pagto = $_POST['data_pagto'];
$valor_pago = $_POST['valor_pago'];
// try = tentar
try {
    //  Query de alteração
    $sql = "UPDATE pagamentos SET data_pagto = :data_pagto, valor_pago = :valor_pago where id_pagamento = :id_pagamento";
    // Preparação para o PDO
    $stmt = $pdo->prepare($sql); // Prepara a declaração SQL
    $stmt->bindParam(':id_pagamento', $id_pagamento, PDO::PARAM_INT); 
    $stmt->bindParam(':data_pagto', $data_pagto);
    $stmt->bindParam(':valor_pago', $valor_pago);
    // executa a query
    // Se a execução for bem sucedida
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
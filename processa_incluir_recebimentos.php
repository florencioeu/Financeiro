<?php
include 'conexao.php'; // Conexão com o banco de dados

// Obtém os valores do formulário
$data_vcto = isset($_POST['data_vcto']) ? $_POST['data_vcto'] : '';
$id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
$descricao = $_POST['descricao']; 
$valor = $_POST['valor']; 
$id_forma_recebimento = $_POST['id_forma_recebimento']; 
    // Insere o registro no banco
    $sql = "INSERT INTO recebimentos (id_cliente, data_vcto, valor, descricao, id_forma_recebimento) VALUES (:id_cliente, :data_vcto, :valor, :descricao, :id_forma_recebimento)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':data_vcto', $data_vcto);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':id_forma_recebimento', $id_forma_recebimento);
    
    if (!$stmt->execute()) {
        echo "Erro ao inserir registro.";
    }
    
// Redireciona após a inserção
header("Location: recebimentos_main.php");
exit;
?>
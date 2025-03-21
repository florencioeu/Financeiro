<?php
// excluir_fornecedores.php
include 'conexao.php'; // Conectamos ao banco de dados

$id_fornecedor = $_GET['id_fornecedor'];

$sql = "DELETE FROM fornecedores where id_fornecedores=id_fornecedor";

$stmt = $pdo->prepare($sql); // Prepara a declaração SQL
$stmt->bindParam('id_fornecedor', $id_fornecedor, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: fornecedores_main.php");
}
?>
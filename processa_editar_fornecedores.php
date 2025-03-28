<?php
// processa_editar_fornecedores.php
include 'conexao.php'; // Conectamos ao banco de dados

$id_fornecedor = $_POST['id_fornecedor'];
$cpf_cnpj = $_POST['cpf_cnpj'];
$nome_fornecedor = $_POST['nome_fornecedor'];
$celular = $_POST['celular'];
$email = strtolower($_POST['email']);
$cep = $_POST['cep'];
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$contato = $_POST['contato'];

try {
    $sql = "UPDATE fornecedores SET 
        cpf_cnpj = :cpf_cnpj, 
        nome_fornecedor = :nome_fornecedor,
        celular = :celular,
        email = :email,
        cep = :cep,
        logradouro = :logradouro,
        numero = :numero,
        complemento = :complemento,
        bairro = :bairro,
        cidade = :cidade,
        estado = :estado,
        contato = :contato
        where id_fornecedor = :id_fornecedor";

    $stmt = $pdo->prepare($sql); // Prepara a declaração SQL
    $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
    $stmt->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt->bindParam(':nome_fornecedor', $nome_fornecedor);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':complemento', $complemento);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':contato', $contato);

    if ($stmt->execute()) {
        header("Location: fornecedores_main.php");
    } else {
        echo "Erro ao alterar registro.";
    }
} catch (PDOException $e) {
    // Exceção, onde é exibido o erro segundo o PHP
    echo "Erro: " . $e->getMessage();
}
?>
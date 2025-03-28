<?php
// processa_incluir_fornecedores.php
include 'conexao.php'; // conectamos o banco de dados
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
    $sql = "INSERT INTO fornecedores (cpf_cnpj, nome_fornecedor, celular, email, cep, logradouro, numero, complemento, bairro, cidade, estado, contato) VALUES (:cpf_cnpj, :nome_fornecedor, :celular, :email, :cep,:logradouro, :numero, :complemento, :bairro, :cidade, :estado, :contato)";
    $stmt = $pdo->prepare($sql); // Adicionei esta linha para preparar a declaração SQL
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
        header("Location:fornecedores_main.php");
    } else {
        echo "Erro ao inserir registro.";
    }
} catch (PDOException $e) {
    // Excessão, onde é exibido o erro segundo o PHP
    echo "Erro: " . $e->getMessage();
}
?>
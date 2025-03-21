<?php
// processa_editar_usuarios.php
include 'conexao.php'; // Conectamos ao banco de dados
$id_usuario = $_POST['id_usuario']; // Chave {Não é alterada}
$nome_usuario = $_POST['nome_usuario'];
$email = $_POST['email'];
$foto = $_POST['foto']
try {
    $sql = "UPDATE usuarios SET
        nome_usuario = :nome_usuario
        where id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql); // Prepara a declaração SQL
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':nome_usuario', $nome_usuario);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':foto', $foto, PDO::PARAM_BLOB);
    if ($stmt->execute()) {
        header("Location: usuarios_main.php"); // Retorna para a página de consulta
    } else {
        echo "Erro ao alterar registro.";
    }
} catch (PDOException $e) {
    // Exceção, onde é exibido o erro segundo o PHP
    echo "Erro: " . $e->getMessage();
}
?>
<?php
include 'conexao.php'; // Conexão com o banco de dados

$id_usuario = $_POST['id_usuario']; // Chave primária {Não é alterada}
$nome_usuario = $_POST['nome_usuario'];
$email = $_POST['email'];

try {
    // Monta a query base
    $sql = "UPDATE usuarios SET nome_usuario = :nome_usuario, email = :email";

    // Verifica se uma nova foto foi enviada e adiciona à SQL
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $sql .= ", foto = :foto";
    }

    $sql .= " WHERE id_usuario = :id_usuario";

    $stmt = $pdo->prepare($sql); // Prepara a SQL

    // Bind dos parâmetros básicos
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':nome_usuario', $nome_usuario, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    // Se uma nova foto foi enviada, processamos o arquivo
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']); // Obtém os dados binários
        $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB); // Insere no banco como BLOB
    }

    // Executa a query
    if ($stmt->execute()) {
        header("Location: usuarios_main.php"); // Retorna à página principal
        exit();
    } else {
        echo "Erro ao alterar registro.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

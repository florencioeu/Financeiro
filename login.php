<?php
session_start(); // Inicia a sessão
// Quando se inicia uma sessão, estamos preparando
// para enviar alguns parâmetros para outra página.
// Vamos enviar o id e o email do usuário para o principal.php
// Dizendo então que está logado. "Fator de segurança"
include 'conexao.php';
$usuario = $_POST['email'];
$senhausuario = $_POST['senha']; 
try {
    // Preparar a consulta SQL
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    // Vincular os parâmetros corretamente
    $stmt->bindParam(':email', $usuario, PDO::PARAM_STR);
     // Executar a consulta
    $stmt->execute();
     // Buscar os resultados
    $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuarioEncontrado) {
        $id_usuario = $usuarioEncontrado['id_usuario'];
        $hashed_password = $usuarioEncontrado['senha'];
        $nome_usuario = $usuarioEncontrado['nome_usuario'];
        // Verificar se a senha está correta
        if (password_verify($senhausuario, $hashed_password)) {
            // Armazenar os dados na sessão
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['nome_usuario'] = $nome_usuario;

            // Redirecionar para principal.php
            header('location:principal.php');
            exit();
        }
    }
    // Se a senha for inválida ou usuário não encontrado
    header('location:usuario_recusado.php');
    exit();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

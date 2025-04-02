<?php
session_start(); // Inicia a sessão
// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('location:usuario_recusado.php');
    exit();
}
// Obtém os dados da sessão
$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome_usuario'];
$foto = $_SESSION['foto'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<style>
        body {
            background-image: url('https://static.vecteezy.com/ti/vetor-gratis/t2/8167404-fundo-de-tecnologia-de-gradacao-simples-vetor.jpg');
            background-repeat: no-repeat;
            background-size: cover; /* Ajusta a imagem para cobrir todo o fundo */
            background-position: center; /* Centraliza a imagem no fundo */
        }
    </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Financeiro</title>
</head>
<body>
    <?php
    include 'menu.php';
    ?> 
    <center>  
    <div class="container">
        <?php
            echo "<h2>Bem-vindo, $nome_usuario! <h2>";
        ?>
    </div>
    </center> 
</body>
</html>
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
<?php
// logoff.php
session_start(); // Inicia a sessão, se ainda não estiver iniciada
session_unset(); // Remove todas as variáveis de sessão
session_destroy(); // Destrói a sessão

// Remove o cookie da sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
   );
}

// Redireciona para a página de login
header("Location: index.php");
exit();
?>

<!-- editar_usuarios.php -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários - Edição</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php
    // Conexão banco de dados
    include 'conexao.php';
    // Chama o Menu
    include 'menu.php';
    // Parametro identificador do usuário
    $id_usuario = $_GET['id_usuario']; 
    // Consulta com select na tabela c/ parametro
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario"; 
    // Preparando a consulta método PDO
    $stmt = $pdo->prepare($sql); 
    // Transformando uma variável vulnerável para segura
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT); // Atente o tipo do campo (aqui INT)
    $stmt->execute(); 
    // Carrega os registros em um array
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($usuario) {
        // trazemos os dados para as variáveis
        $id_usuario = $usuario['id_usuario'];
        $nome_usuario = $usuario['nome_usuario'];
        $email = $usuario['email'];
        $foto = $usuario['foto'];
    }
    ?>
    <div class="container">
    <form action="processa_editar_usuarios.php" method="post">
        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario ?>">
        <label for="nome_usuario">Nome do usuário</label>
        <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" value="<?php echo $nome_usuario ?>" required>
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo $email ?>" required>
        <label for="foto">Foto do Usuário</label>
        <input type="file" id="foto" name="foto" class="form-control" value="<?php echo $foto ?>">
        <button type="submit" id="botao" class="btn btn-primary">Alterar</button>        
    </form>
    </div>
    <!-- Carregando bibliotecas corretamente -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js">
    </script>
</body>
</html>

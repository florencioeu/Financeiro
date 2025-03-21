<!-- editar_forma_pagamentos.php -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma pagamento - Edição</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php
    include 'conexao.php';
    include 'menu.php';
    $id_forma_pagto = $_GET['id_forma_pagto'];
    $sql = "SELECT * FROM forma_pagamentos WHERE id_forma_pagto = :id_forma_pagto";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_forma_pagto', $id_forma_pagto, PDO::PARAM_INT);
    $stmt->execute();
    $forma_pagto = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if ($forma_pagto) {
        $id_forma_pagto = $forma_pagto['id_forma_pagto'];
        $descricao_forma = $forma_pagto['descricao_forma'];
    }
    ?>
    <div class="container">
    <form action="processa_editar_forma_pagamentos.php" method="post">
        <input type="hidden" id="id_forma_pagto" name="id_forma_pagto" value="<?php echo $id_forma_pagto ?>">
        <label for="descricao_forma">Forma Pagamento</label>
        <input type="text" id="descricao_forma" name="descricao_forma" class="form-control"
        placeholder="Entre com o nome" value="<?php echo $descricao_forma ?>" required>
        <button type="submit" id="botao" class="btn btn-primary">Alterar</button>        
    </form>
    </div>
    <!-- Carregando bibliotecas corretamente -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js">
    </script>
</body>
</html>
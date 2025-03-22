<!-- incluir_forma_pagamentos.php -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma Pagamento - Inclusão</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php
        include 'menu.php';  // incluímos o menu nesse PHP
    ?> 
    <div class="container">
    <form action="processa_incluir_forma_pagamentos.php" method="post">
        <label for="descricao_forma">Descrição</label>
        <input type="text" id="descricao" name="descricao_forma" class="form-control" 
        placeholder="Entre com a descrição" required> 

        <button type="submit" id="botao" class="btn btn-primary">Incluir</button>        
    </form>
    </div>
    <!-- Carregando bibliotecas corretamente -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js">
    </script>
</body>
</html>

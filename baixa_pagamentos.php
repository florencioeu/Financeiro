<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baixa de pagamento</title>
    <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
 
    <?php
    include 'conexao.php';
    include 'menu.php';
 
    // Verifica se o parâmetro foi passado na URL
    if (isset($_GET['id_pagamento']) && is_numeric($_GET['id_pagamento'])) {
        $id_pagamento = $_GET['id_pagamento'];
        // Preparando a consulta SQL para evitar SQL Injection
        $sql = "SELECT * FROM pagamentos WHERE id_pagamento = :id_pagamento";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_pagamento', $id_pagamento, PDO::PARAM_INT);
        $stmt->execute();
        $resultado_baixa = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificando se o resultado existe para evitar erros
        if ($resultado_baixa) {
            // A data do pagamento será carregado com a data do vencimento
            $data_pagto = htmlspecialchars($resultado_baixa['data_vcto']);
            // O Valor do pagamento sera carregado com o valor original
            $valor_pago = htmlspecialchars($resultado_baixa['valor']);  
        } else {
            $data_pagto = '';
            $valor_pago = '';
        }
    } else {
        $data_pagto = '';
        $valor_pago = '';
        echo "<div class='alert alert-danger'>ID de pagamento inválido.</div>";
    }
    // encontrado o pagamento e já carregado tudo nas variáreis, preparamos o form para baixar. Teremos o id_pagamento invisível, a data_pagto e o valor_pago
    ?>
 <div class="container">
    <h1>Baixa de pagamento</h1>
    <form action="processa_baixa_pagamentos.php" method="post">
        <input type="hidden" id="id_pagamento" name="id_pagamento" value="<?php echo($id_pagamento); ?>">
        <label for="data_pagto">Data do Pagamento</label>
        <input type="date" id="data_pagto" name="data_pagto" value="<?php echo($data_pagto); ?>" class="form-control">
        <label for="valor_pago">Valor do Pagamento</label>
        <input type="text" id="valor_pago" name="valor_pago" value="<?php echo($valor_pago); ?>" class="form-control">
        <button type="submit" id="botao" class="btn btn-primary">Baixar</button>      
    </form>
</div>
</body>
</html>
 
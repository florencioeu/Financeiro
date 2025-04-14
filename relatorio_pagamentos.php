<!-- relatorio_pagamentos.php -->
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório contas pagas</title>
    <!-- link para o bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- link para os icones -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 </head>
 <body>
    <?php 
    // include do menu e da conexão com banco de dados
    include("menu.php");
    include("conexao.php");
    ?>
    <div class="container">
    <!-- A impressão se dará no link abaixo -->    
    <form action="impressao_pagamentos.php" method="post" target="_blank">
        <label for="data_inicial">Data Inicial</label>
        <!-- pedir a data inicial -->
        <input type="date" name="data_inicial" id="data_inicial" class="form-control" value="<?php echo htmlspecialchars($data_inicial); ?>">
        <!-- pedir a data final -->
        <label for="data_final">Data Final</label>
        <input type="date" name="data_final" id="data_final" class="form-control" value="<?php echo htmlspecialchars($data_final); ?>">
        <!-- Botão para impressão -->
        <button type="submit" id="botao" class="btn btn-primary"><i class="material-icons">printer</i>Imprimir</button>
    </form>
    </div>
 </body>
 </html>
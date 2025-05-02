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
    <style>
        /* Ajustando o padding para o botão */
        #botao {
            padding-left: 5px;  /* Reduzindo o espaço à esquerda do ícone */
            padding-right: 10px; /* Diminui o espaço à direita do ícone */
        }
    </style>
</head>
<body>
    <?php 
    // include do menu e da conexão com banco de dados
    include("menu.php");
    include("conexao.php");
    ?>
    <div class="container">
        <!-- Título do relatório, alinhado à esquerda e com tamanho aumentado -->
        <h1 style="font-size: 22px; font-weight: bold; margin-bottom: 20px; text-align: left;">Relatório de Contas Pagas</h1> 
        <hr>
        <!-- A impressão se dará no link abaixo -->    
        <form action="impressao_pagamentos.php" method="post" target="_blank">
            <!-- Rótulo em negrito para Data Inicial -->
            <label for="data_inicial" style="font-weight: bold;">Data Inicial</label>
            <!-- pedir a data inicial -->
            <input type="date" name="data_inicial" id="data_inicial" class="form-control" value="<?php echo htmlspecialchars($data_inicial); ?>">
            
            <!-- Rótulo em negrito para Data Final -->
            <label for="data_final" style="font-weight: bold;">Data Final</label>
            <input type="date" name="data_final" id="data_final" class="form-control" value="<?php echo htmlspecialchars($data_final); ?>">

            <!-- Espaço adicional após o campo data_final -->
            <div style="margin-bottom: 15px;"></div> <!-- Adicionando espaço aqui -->

            <!-- Botão para impressão -->
            <button type="submit" id="botao" class="btn btn-primary"><i class="material-icons"></i>Imprimir</button>
        </form>
    </div>
</body>
</html>
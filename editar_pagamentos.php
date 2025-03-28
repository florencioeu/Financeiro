<!DOCTYPE html>
<!-- editar_pagamentos.php -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar pagamento</title>
</head>
<body>
    <?php
        include 'menu.php';  // incluímos o menu nesse PHP
    ?>
    <div class="container">
         
    <?php
      include 'conexao.php'; // Incluimos a conexão
      $id_pagamento = $_GET['id_pagamento'];
      // echo''.$id_pagamento.'';
      // pegamos o parametro do id_pagamento para fazer a consulta abaixo
      $sql="select * from pagamentos where id_pagamento=:id_pagamento";
      // Preparação da consulta em PDO
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id_pagamento', $id_pagamento, PDO::PARAM_INT);
      // Executa a query (consulta)
      $stmt->execute();
      $resultado_pagamentos = $stmt->fetch(PDO::FETCH_ASSOC);
      // Trazendo os campos da tabela e inserindo em variáveis
      $data_vcto = $resultado_pagamentos['data_vcto'];
      // Foi dado outro nome ao id_fornecedor para não conflitar na hora ce comparar no seletor
      $id_fornecedor2 = $resultado_pagamentos['id_fornecedor'];
      $descricao = $resultado_pagamentos['descricao'];
      $id_tipo_pagto = $resultado_pagamentos['id_tipo_pagto'];
    ?>
    <form action="processa_editar_pagamentos.php" method="post">
        <label for="data_vcto">Data de Vencimento</label>
        <input type="date" id="data_vcto" name="data_vcto" value="<?php echo $data_vcto;?>" class="form-control">
 
        <label for="nome_fornecedor">Nome do Fornecedor</label>
        <select name="id_fornecedor" id="id_fornecedor" class="form-control">
            <option value="0">--Selecione o Fornecedor --</option>  
            <?php  
            try {
            // consulta na tabela    
            $sql = "SELECT * FROM fornecedores ORDER BY nome_fornecedor";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            // laço para trazer linha a linha (row)
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_fornecedor = htmlspecialchars($row['id_fornecedor']);
                $nome_fornecedor = $row['nome_fornecedor'];
                // criada a variavel $localizou para caso o id do fornecedor da tabela pagamentos ser igual ao que está na tabela fornecedores, inserir a palavra selected que trava a opção onde queremos.
                $localizou="";
                if ($id_fornecedor2 == $row['id_fornecedor']) {
                    $localizou='selected';
                }
                echo "<option value='$id_fornecedor' $localizou>$nome_fornecedor</option>";
            }
             } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
         ?>
        </select>
 
        <label for="descricao">Descrição do Pagamento</label>
        <input type="text" id="descricao" value="<?php echo $descricao;?>" name="descricao"
        class="form-control">
 
        <label for="id_tipo_pagto">Tipo do pagamento</label>
        <select name="id_tipo_pagto" id="id_tipo_pagto" class="form-control">
            <option value="0">--Selecione o Tipo --</option>  
            <?php  
            try {
            // consulta na tabela    
            $sql = "SELECT * FROM tipo_pagamentos ORDER BY descricao_tipo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            // laço para trazer linha a linha (row)
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_tipo_pagto = htmlspecialchars($row['id_tipo_pagto']);
                $descricao_tipo = $row['descricao_tipo'];
                echo "<option value='$id_tipo_pagto'>$descricao_tipo</option>";
            }
             } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
         ?>
        </select>  
 
        <label for="id_forma_pagto">Forma do pagamento</label>
        <select name="id_forma_pagto" id="id_forma_pagto" class="form-control">
            <option value="0">--Selecione a Forma Pagto --</option>  
            <?php  
            try {
            // consulta na tabela    
            $sql = "SELECT * FROM forma_pagamentos ORDER BY descricao_forma";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            // laço para trazer linha a linha (row)
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_forma_pagto = htmlspecialchars($row['id_forma_pagto']);
                $descricao_forma = $row['descricao_forma'];
                echo "<option value='$id_forma_pagto'>$descricao_forma</option>";
            }
             } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
         ?>
        </select>  
 
        <label for="valor">Valor</label>
        <input type="text" id="valor" name="valor"
        class="form-control">        
 
        <label for="parcelas">N.Parcelas</label>
        <input type="number" id="parcelas" name="parcelas" min="1" max="12"
        class="form-control">
 
        <label for="baixa">Baixa pagamento?</label>
        <input type="checkbox" id="baixa" name="baixa" value="1">
        <br><br>
        <button type="submit" id="botao" class="btn btn-primary">Incluir</button>
    </form>
    </div>
</body>
</html>
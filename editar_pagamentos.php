<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar pagamento</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include 'menu.php';  // Inclui o menu ?>
    <div class="margens">

    <?php
    include 'conexao.php';
    $id_pagamento = $_GET['id_pagamento'];
    $sql = "SELECT * FROM pagamentos WHERE id_pagamento=:id_pagamento";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_pagamento', $id_pagamento, PDO::PARAM_INT);
    $stmt->execute();
    $resultado_pagamentos = $stmt->fetch(PDO::FETCH_ASSOC);

    // Preenche os campos com os valores do banco de dados
    $data_vcto = $resultado_pagamentos['data_vcto'];
    $id_fornecedor2 = $resultado_pagamentos['id_fornecedor'];
    $descricao = $resultado_pagamentos['descricao'];
    $id_tipo_pagto2 = $resultado_pagamentos['id_tipo_pagto'];
    $id_forma_pagto2 = $resultado_pagamentos['id_forma_pagto'];
    $valor = $resultado_pagamentos['valor'];
    ?>

    <form action="processa_editar_pagamentos.php" method="post">
        <label for="data_vcto">Data de Vencimento</label>
        <input type="date" id="data_vcto" name="data_vcto" value="<?php echo $data_vcto;?>" class="form-control">
        <label for="id_fornecedor">Nome do Fornecedor</label>
        <select name="id_fornecedor" id="id_fornecedor" class="form-control">
            <option value="0">--Selecione o Fornecedor --</option>  
            <?php
            try {
                $sql = "SELECT * FROM fornecedores ORDER BY nome_fornecedor";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_fornecedor = htmlspecialchars($row['id_fornecedor']);
                    $nome_fornecedor = $row['nome_fornecedor'];
                    $selected = ($id_fornecedor2 == $row['id_fornecedor']) ? 'selected' : '';
                    echo "<option value='$id_fornecedor' $selected>$nome_fornecedor</option>";
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
            ?>
        </select>
        <label for="descricao">Descrição do Pagamento</label>
        <input type="text" id="descricao" value="<?php echo $descricao;?>" name="descricao" class="form-control">
        <label for="id_tipo_pagto">Tipo do pagamento</label>
        <select name="id_tipo_pagto" id="id_tipo_pagto" class="form-control">
            <option value="0">--Selecione o Tipo --</option>  
            <?php
            try {
                $sql = "SELECT * FROM tipo_pagamentos ORDER BY descricao_tipo";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_tipo_pagto = htmlspecialchars($row['id_tipo_pagto']);
                    $descricao_tipo = $row['descricao_tipo'];
                    $selected = ($id_tipo_pagto2 == $row['id_tipo_pagto']) ? 'selected' : '';
                    echo "<option value='$id_tipo_pagto' $selected>$descricao_tipo</option>";
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
                $sql = "SELECT * FROM forma_pagamentos ORDER BY descricao_forma";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_forma_pagto = htmlspecialchars($row['id_forma_pagto']);
                    $descricao_forma = $row['descricao_forma'];
                    $selected = ($id_forma_pagto2 == $row['id_forma_pagto']) ? 'selected' : '';
                    echo "<option value='$id_forma_pagto' $selected>$descricao_forma</option>";
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
            ?>
        </select>
        <label for="valor">Valor</label>
        <input type="text" id="valor" name="valor" value="<?php echo $valor ?>" class="form-control">
        <input type="hidden" id="id_pagamento" name="id_pagamento" value="<?php echo $id_pagamento ?>">
        <br><br>
        <button type="submit" id="botao" class="btn btn-primary">Alterar</button>
    </form>
    </div>
</body>
</html>

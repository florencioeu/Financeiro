<!DOCTYPE html>
<!-- incluir_recebimentos.php -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas a receber</title>
</head>
<body>
    <div class="container">
    <?php
        include 'menu.php';  // incluímos o menu nesse PHP
    ?>         
    <?php
      include 'conexao.php'; // Incluimos a conexão
    ?> 
    <form action="processa_incluir_recebimentos.php" method="post">
        <label for="data_vcto">Data de Vencimento</label>
        <input type="date" id="data_vcto" name="data_vcto" class="form-control">
 
        <label for="nome_cliente">Nome do Cliente</label>
        <select name="id_cliente" id="id_cliente" class="form-control">
            <option value="0">--Selecione o Cliente--</option>  
            <?php  
            try {
            // consulta na tabela    
            $sql = "SELECT * FROM clientes ORDER BY nome_cliente";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            // laço para trazer linha a linha (row)
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id_cliente = htmlspecialchars($row['id_cliente']);
                $nome_cliente = $row['nome_cliente'];
                echo "<option value='$id_cliente'>$nome_cliente</option>";
            }
             } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
         ?>
        </select>

        <label for="descricao">Descrição do Recebimento</label>
        <input type="text" id="descricao" name="descricao" 
        class="form-control">
        <label for="id_forma_recebimento">Forma do Recebimento</label>
        <select name="id_forma_recebimento" id="id_forma_recebimento" class="form-control">
            <option value="0">--Selecione a Forma Recebimento --</option>
            <option value="1">Cartão de Crédito</option>
            <option value="2">Cartão de Débito</option>
            <option value="3">PIX</option>  
            <option value="4">Dinheiro</option>
            <option value="5">Título Bancário</option>
          </select>  
        <label for="valor">Valor</label>
        <input type="text" id="valor" name="valor" 
        class="form-control">        
        <br><br>
        <button type="submit" id="botao" class="btn btn-primary">Incluir</button>
    </form>
    </div>
</body>
</html>
<!-- editar_fornecedores.php -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - Edição</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php
    include 'conexao.php';
    include 'menu.php';
    $id_fornecedor = $_GET['id_fornecedor']; 
    $sql = "SELECT * FROM fornecedores WHERE id_fornecedor = :id_fornecedor"; 
    $stmt = $pdo->prepare($sql); 
    $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT); 
    $stmt->execute(); 
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($fornecedor) {
        $id_fornecedor = $fornecedor['id_fornecedor'];
        $nome_fornecedor = $fornecedor['nome_fornecedor'];
        $cpf_cnpj = $fornecedor['cpf_cnpj'];
        $celular = $fornecedor['celular'];
        $email = $fornecedor['email'];
        $cep = $fornecedor['cep'];
        $logradouro = $fornecedor['logradouro'];
        $numero = $fornecedor['numero'];
        $complemento = $fornecedor['complemento'];
        $bairro = $fornecedor['bairro'];
        $cidade = $fornecedor['cidade'];
        $estado = $fornecedor['estado'];
        $contato = $fornecedor['contato'];
    }
    ?>
    <div class="container">
    <form action="processa_editar_fornecedores.php" method="post">
        <input type="hidden" id="id_fornecedor" name="id_fornecedor" value="<?php echo $id_fornecedor ?>">


        <label for="cpfcnpj">CPF/CNPJ</label>
        <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control cpfOuCnpj" 
        placeholder="Entre com o CPF/CNPJ" value="<?php echo $cpf_cnpj ?>" required> 
        
        <label for="nome_fornecedor">Nome Fornecedor</label>
        <input type="text" id="nome_fornecedor" name="nome_fornecedor" class="form-control" 
        placeholder="Entre com o nome" value="<?php echo $nome_fornecedor ?>" required>

        <label for="celular">Celular</label>
        <input type="text" id="celular" name="celular" class="form-control" 
        placeholder="Entre com o Celular" value="<?php echo $celular ?>"> 

        <label for="email">E-mail</label> 
        <input type="text" id="email" name="email" class="form-control" 
        placeholder="Entre com o E-mail" value="<?php echo $email ?>">     

        <label for="cep">CEP</label> 
        <input type="text" id="cep" name="cep" class="form-control" 
        placeholder="Entre com o CEP"  value="<?php echo $cep ?>">

        <label for="logradouro">Endereço</label> 
        <input type="text" id="logradouro" name="logradouro" class="form-control" 
        placeholder="Entre com o Endereço" value="<?php echo $logradouro ?>">

        <label for="numero">Número</label> 
        <input type="text" id="numero" name="numero" class="form-control" 
        placeholder="Entre com o Número" value="<?php echo $numero ?>"> 

        <label for="complemento">Complemento</label> 
        <input type="text" id="complemento" name="complemento" class="form-control" 
        placeholder="Entre com o Complemento" value="<?php echo $complemento ?>"> 

        <label for="bairro">Bairro</label> 
        <input type="text" id="bairro" name="bairro" class="form-control" 
        placeholder="Entre com o Bairro" value="<?php echo $bairro ?>"> 

        <label for="cidade">Cidade</label>    
        <input type="text" id="cidade" name="cidade" class="form-control" 
        placeholder="Entre com a Cidade" value="<?php echo $cidade ?>">

        <label for="estado">Estado</label> 
        <input type="text" id="estado" name="estado" class="form-control" 
        placeholder="Entre com o Estado"  value="<?php echo $estado ?>">

        <label for="contato">Nome do Contato</label> 
        <input type="text" id="contato" name="contato" class="form-control" 
        placeholder="Entre com o nome do Contato" value="<?php echo $contato ?>">                                          

        <button type="submit" id="botao" class="btn btn-primary">Alterar</button>        
    </form>
    </div>
    <!-- Carregando bibliotecas corretamente -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js">

    </script>

    <script type="text/javascript">
        var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }

    $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);
    </script>
   
</body>
</html>

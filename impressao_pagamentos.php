<!-- impressao_pagamentos.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressão do contas pagas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body onLoad="self.print();">
    <?php
    include("conexao.php");
    $data_inicial = $_POST["data_inicial"];
    $data_final = $_POST["data_final"];
    
    $sql = "SELECT * FROM pagamentos 
    INNER JOIN fornecedores ON pagamentos.id_fornecedor = fornecedores.id_fornecedor 
    INNER JOIN tipo_pagamentos ON pagamentos.id_tipo_pagto = tipo_pagamentos.id_tipo_pagto 
    WHERE 1=1 and valor_pago > 0";

    if (!empty($data_inicial) && !empty($data_final)) {
        $sql .= " AND data_pagto BETWEEN '$data_inicial' AND '$data_final'";
    }
    $sql .= " ORDER BY data_pagto";
    
    $stmt = $pdo->prepare($sql);
   
    $stmt->execute();
    ?>
    <img src="https://cdna.artstation.com/p/assets/images/images/005/172/886/large/joao-pedro-oliveira-logo.jpg?1489030448" width="150px" alt="">
    <h1>Relatório de contas pagas</h1>
    <h2>De: <?php echo date("d/m/Y", strtotime($data_inicial)); ?> Ate: <?php echo date("d/m/Y", strtotime($data_final)); ?></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fornecedor</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Dt.Pagto</th>
                <th>Valor Pago</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        $contador = 0;
        $total = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
            $contador = $contador+1;
             ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_pagamento']); ?>
                <input type="hidden" name="id_pagamento<?php echo($contador); ?>" id="id_pagamento<?php echo($contador); ?>" value="<?php echo htmlspecialchars($row['id_pagamento']); ?>"></td>
                <td><?php echo htmlspecialchars($row['nome_fornecedor']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao_tipo']); ?></td>
                <td><?php echo date("d/m/Y", strtotime($row['data_pagto'])); ?></td>
                <td style="text-align: right;"><?php echo "R$ ". number_format($row['valor_pago'], 2, ",", "."); ?></td>
                <?php $total = $total + $row['valor_pago'] ?>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <hr>
    <p style="text-align: right;"><?php echo "Total dos pagamentos: R$ ". number_format($total, 2, ",", "."); ?></p>
    <p style="text-align: right;"><?php echo "Total de registros: " . $contador ?></p>
</body>
</html>
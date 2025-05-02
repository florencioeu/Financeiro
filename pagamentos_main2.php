<?php
include 'conexao.php'; 
include 'menu.php'; 

$data_inicial = isset($_POST['data_inicial']) ? $_POST['data_inicial'] : '';
$data_final = isset($_POST['data_final']) ? $_POST['data_final'] : '';

$sql = "SELECT * FROM pagamentos 
        INNER JOIN fornecedores ON pagamentos.id_fornecedor = fornecedores.id_fornecedor 
        INNER JOIN tipo_pagamentos ON pagamentos.id_tipo_pagto = tipo_pagamentos.id_tipo_pagto 
        WHERE 1=1";

if (!empty($data_inicial) && !empty($data_final)) {
    $sql .= " AND data_vcto BETWEEN :data_inicial AND :data_final";
}

$sql .= " ORDER BY data_vcto";

$stmt = $pdo->prepare($sql);

if (!empty($data_inicial) && !empty($data_final)) {
    $stmt->bindParam(':data_inicial', $data_inicial);
    $stmt->bindParam(':data_final', $data_final);
}

$stmt->execute();
?>

<link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="container">
    <form action="pagamentos_main.php" method="post"> 
        <div class="row">
            <div class="col-sm">
                <label for="data_inicial">Data Inicial</label>
                <input type="date" name="data_inicial" id="data_inicial" class="form-control" value="<?php echo htmlspecialchars($data_inicial); ?>">
            </div>
            <div class="col-sm">
                <label for="data_final">Data Final</label>
                <input type="date" name="data_final" id="data_final" class="form-control" value="<?php echo htmlspecialchars($data_final); ?>">
            </div>
            <div class="col-sm">
                <br>
                <button type="submit" id="botao" class="btn btn-primary">Pesquisar</button>
            </div>
        </div>  
    </form> 

    <br>
    <a href="incluir_pagamentos.php" class="btn btn-primary">Novo Pagamento</a>
    <br><br> 
    <form action="baixa_lotes.php">  
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fornecedor</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Dt.Vcto</th>
                <th>Valor</th>
                <th>Editar</th>
                <th>Excluir</th>
                <th>Baixar</th>
                <th>Lote</th>
            </tr>
        </thead>
        <tbody>
         
        <?php 
        $contador = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
            $contador = $contador+1;
            
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_pagamento']); ?></td>
                <td><?php echo htmlspecialchars($row['nome_fornecedor']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao_tipo']); ?></td>
                <td><?php echo date("d/m/Y", strtotime($row['data_vcto'])); ?></td>
                <td><?php echo number_format($row['valor'], 2, ",", "."); ?></td>
                <td><a href="editar_pagamentos.php?id_pagamento=<?php echo $row['id_pagamento']; ?>" class="btn btn-primary"><i class="material-icons">edit</i></a></td>
                <td><a href="#" onclick="confirmarExclusao(<?php echo $row['id_pagamento']; ?>)" class="btn btn-danger"><i class="material-icons">delete</i></a></td>
                <td>
                    <a href="baixa_pagamentos.php?id_pagamento=<?php echo $row['id_pagamento']; ?>"  
                       class="btn btn-secondary">
                        <i class="material-icons">attach_money</i>
                    </a>
                </td>
                <td>
                   <input type="checkbox" name="check<?php echo ($contador); ?>" id="check<?php echo ($contador); ?>" class="form-control"> 
                   <!--check<?php echo ($contador); ?>-->
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    
    <button type="submit" id="botao" class="btn btn-primary">Baixar Lote</button>
    </form>
    <hr>
    <div class="row">
 
        <div class="col-sm">
        <h3>Resumo por tipo de Despesa</h3>
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Tipo Despesa</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>          
        <?php
            // consulta relacionada tabela tipo de pagamentos com pagamentos
            $sql2 = "SELECT tipo_pagamentos.descricao_tipo,sum(valor) as total FROM pagamentos inner join tipo_pagamentos on pagamentos.id_tipo_pagto=tipo_pagamentos.id_tipo_pagto WHERE 1=1";
            if (!empty($data_inicial) && !empty($data_final)) {
              // consulta entra faixa de datas
              $sql2 .= " AND data_vcto BETWEEN :data_inicial AND :data_final";
            }
            // Agrupando por tipo de pagamentos
            $sql2 .= " group by tipo_pagamentos.id_tipo_pagto";
            $stmt2 = $pdo->prepare($sql2);
            if (!empty($data_inicial) && !empty($data_final)) {
                $stmt2->bindParam(':data_inicial', $data_inicial);
                $stmt2->bindParam(':data_final', $data_final);
            }
            $stmt2->execute();
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
             <td><?php echo htmlspecialchars($row['descricao_tipo']); ?></td>
             <td><?php echo number_format($row['total'], 2, ",", "."); ?></td>
            </tr>  
        <?php endwhile; ?>
        </tbody>
        </table>
        </div>
        <div class="col-sm">
            <?php include 'pagamentos_grafico.php'; ?>
        </div>        
    </div>    

</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
function confirmarBaixa(id_pagamento) {
    $('#confirmBaixa').modal('show');
    document.getElementById('id_pagamento').value = id_pagamento;
    document.getElementById('confirmBaixaBtn').onclick = function() {
        window.location.href = "pagamentos_main.php?id_pagamento=" + id_pagamento;
    };
}
</script>

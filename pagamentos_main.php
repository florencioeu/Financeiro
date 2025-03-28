<?php
// Inclui os arquivos de conexão com o banco de dados e o menu da aplicação
include '../conexao.php'; 
include '../menu.php'; 

// Verifica se os valores foram enviados pelo formulário e os captura
// Se não forem enviados, atribui uma string vazia para evitar erros
$data_inicial = isset($_POST['data_inicial']) ? $_POST['data_inicial'] : '';
$data_final = isset($_POST['data_final']) ? $_POST['data_final'] : '';

// Monta a query para buscar pagamentos e suas relações com fornecedores e tipos de pagamento
$sql = "SELECT * FROM pagamentos 
        INNER JOIN fornecedores ON pagamentos.id_fornecedor = fornecedores.id_fornecedor 
        INNER JOIN tipo_pagamentos ON pagamentos.id_tipo_pagto = tipo_pagamentos.id_tipo_pagto 
        WHERE 1=1"; // O "WHERE 1=1" permite adicionar filtros dinamicamente depois
// Se ambas as datas foram informadas, adicionamos um filtro de intervalo de datas na consulta - BETWEN = Entre  - IF = Se 
if (!empty($data_inicial) && !empty($data_final)) {
    $sql .= " AND data_vcto BETWEEN :data_inicial AND :data_final";
}
// Ordenamos os resultados pela data de vencimento
// O ponto e o sinal de igual estão concatenando a variável $sql
$sql .= " ORDER BY data_vcto";

// Prepara a consulta para evitar SQL Injection
$stmt = $pdo->prepare($sql);

// Se as datas foram informadas, fazemos a ligação dos parâmetros para evitar injeção de SQL
if (!empty($data_inicial) && !empty($data_final)) {
    $stmt->bindParam(':data_inicial', $data_inicial);
    $stmt->bindParam(':data_final', $data_final);
}

// Executa a consulta
$stmt->execute();
?>
<link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="container">
    <!-- Formulário para entrada de datas de pesquisa -->
    <form action="pagamentos_main.php" method="post"> 
        <div class="row">
            <div class="col-sm">
                <label for="data_inicial">Data Inicial</label>
                <!-- Campo para selecionar a data inicial -->
                <input type="date" name="data_inicial" id="data_inicial" class="form-control" value="<?php echo htmlspecialchars($data_inicial); ?>">
            </div>
            <div class="col-sm">
                <label for="data_final">Data Final</label>
                <!-- Campo para selecionar a data final -->
                <input type="date" name="data_final" id="data_final" class="form-control" value="<?php echo htmlspecialchars($data_final); ?>">
            </div>
            <div class="col-sm">
                <br>
                <!-- Botão para submeter a pesquisa -->
                <button type="submit" id="botao" class="btn btn-primary">Pesquisar</button>
            </div>
        </div>  
    </form> 

    <br>
    <!-- Link para adicionar um novo pagamento -->
    <a href="incluir_pagamentos.php" class="btn btn-primary">Novo Pagamento</a>
    <br><br> 
    
    <!-- Tabela para exibir os pagamentos filtrados -->
    <table id="" class="table table-striped">
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
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_pagamento']); ?></td>
                <td><?php echo htmlspecialchars($row['nome_fornecedor']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao_tipo']); ?></td>
                <!-- Formata a data para o formato brasileiro -->
                <td><?php echo date("d/m/Y", strtotime($row['data_vcto'])); ?></td>
                <!-- Formata o valor para exibição com duas casas decimais -->
                <td><?php echo number_format($row['valor'], 2, ",", "."); ?></td>
                <!-- Botão para editar o pagamento -->
                <td><a href="editar_pagamentos.php?id_pagamento=<?php echo htmlspecialchars($row['id_pagamento']); ?>" class="btn btn-primary"><i class="material-icons">edit</i></a></td>
                <!-- Botão para excluir o pagamento -->
                <td><a href="#" onclick="confirmarExclusao(<?php echo htmlspecialchars($row['id_pagamento']); ?>)" class="btn btn-danger"><i class="material-icons">delete</i></a></td>
                <!-- Botão para baixar -->
                <td><a href="#" onclick="confirmarBaixa(<?php echo htmlspecialchars($row['id_pagamento']); ?>)" 
                class="btn btn-secondary"><i class="material-icons">attach_money</i></a></td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
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
    
    <!-- Inicio modal da baixa do pagamento -->

<div class="modal fade" id="confirmBaixa" tabindex="-1" role="dialog" 
  aria-labelledby="confirmBaixaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmBaixaLabel">Baixar Pagamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="Data do pagamento"></label>
        <input type="date" id="data_pagto" name="data_pagto" class="form-control" >
        <label for="Valor do pagamento"></label>
        <input type="text" id="valor_pago" name="valor_pago" class="form-control" >       
      </div>
      <div class="modal-footer">
        <!-- O data-dismiss="modal", simplesmente fechará o modal -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <!-- Note o nome do botão que está no id: confirmBaixaBtn
         Quando pressionado irá acionar o javascript que acionará a exclusão -->
        <button type="button" class="btn btn-danger" id="confirmBaixaBtn">Baixar</button>
      </div>
    </div>
  </div>
</div>     
    <!-- Final modal da baixa do pagamento -->    



</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#example');
</script>


<script>
    // Comantário no Javascript e PHP
    function confirmarBaixa(id) {
        $('#confirmBaixa').modal('show');
         document.getElementById('confirmBaixaBtn').onclick = function() {
            window.location.href = "baixa_pagamentos.php?id_pagamento=" + id;
        };
    }
</script>
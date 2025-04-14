<?php
include 'conexao.php'; 
include 'menu.php'; 

$data_inicial = isset($_POST['data_inicial']) ? $_POST['data_inicial'] : '';
$data_final = isset($_POST['data_final']) ? $_POST['data_final'] : '';

$sql = "SELECT * FROM pagamentos 
        INNER JOIN fornecedores ON pagamentos.id_fornecedor = fornecedores.id_fornecedor 
        INNER JOIN tipo_pagamentos ON pagamentos.id_tipo_pagto = tipo_pagamentos.id_tipo_pagto 
        WHERE 1=1 and valor_pago=0 and oculto=0";

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


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">  
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
<script>
        // Comantário no Javascript e PHP
    function confirmarExclusao(id) {
        $('#confirmModal').modal('show');
            document.getElementById('confirmDeleteBtn').onclick = function() {
            window.location.href = "excluir_pagamentos.php?id_pagamento=" + id;
         };
    }
</script>

<div class="margens">
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
                <button type="submit" id="botao" class="btn btn-primary"><i class="material-icons">search</i>Pesquisar</button>
            </div>
            <div class="col-sm" style="text-align: right;">
                <br>
                <a href="incluir_pagamentos.php" class="btn btn-primary"><i class="material-icons">add</i> Novo Pagamento</a>
            </div>            
        </div>  
    </form> 
    <hr>

    <form action="baixa_pagamentos_lotes.php" method="post">  
    <table id="myTable" class="table table-striped table-bordered dt-responsive nowrap">
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
                <td><?php echo htmlspecialchars($row['id_pagamento']); ?>

                <input type="hidden" name="id_pagamento<?php echo($contador); ?>" id="id_pagamento<?php echo($contador); ?>" value="<?php echo htmlspecialchars($row['id_pagamento']); ?>">
            
            </td>
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
                   <input type="checkbox" name="check<?php echo ($contador); ?>" id="check<?php echo ($contador); ?>" class="form-control" value="1"> 
                   <!--check<?php echo ($contador); ?>-->
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <div style="text-align: right;">
    <input type="hidden" name="total" id="total" value="<?php echo($contador); ?>"> 
    <hr>
    <button type="submit" id="botao" class="btn btn-primary">Baixar Lote</button>
    </div>
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
            $sql2 = "SELECT tipo_pagamentos.descricao_tipo,sum(valor) as total FROM pagamentos inner join tipo_pagamentos on pagamentos.id_tipo_pagto=tipo_pagamentos.id_tipo_pagto WHERE 1=1 and valor_pago=0";
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
        <div class="col-sm" style="text-align: center;">
            <h3>Dashboard</h3>
            <?php include 'pagamentos_grafico.php'; ?>
        </div>        
    </div>
    
<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" 
  aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmar Exclusão</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja excluir este pagamento?
      </div>
      <div class="modal-footer">
        <!-- O data-dismiss="modal", simplesmente fechará o modal -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <!-- Note o nome do botão que está no id: confirmDeleteBtn
         Quando pressionado irá acionar o javascript que acionará a exclusão -->
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Excluir</button>
      </div>
    </div>
  </div>
</div>


</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
                },
                pageLength: 10,
                order: [[0, 'asc']],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]]
            });
        });
    </script>




<script>
function confirmarBaixa(id_pagamento) {
    $('#confirmBaixa').modal('show');
    document.getElementById('id_pagamento').value = id_pagamento;
    document.getElementById('confirmBaixaBtn').onclick = function() {
        window.location.href = "pagamentos_main.php?id_pagamento=" + id_pagamento;
    };
}
</script>

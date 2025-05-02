<!-- forma_pagamentos_main -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma de pagamentos</title>
    <link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">  
    <!-- Comentário no HTML -->    
    <script>
        // Comantário no Javascript e PHP
        function confirmarExclusao(id) {
            $('#confirmModal').modal('show');
            document.getElementById('confirmDeleteBtn').onclick = function() {
                window.location.href = "excluir_forma_pagamentos.php?id_forma_pagto=" + id;
            };
        }
    </script>
</head>
<body>
<?php
    include 'conexao.php'; // Incluímos o arquivo de conexão
    include 'menu.php';  // incluímos o menu nesse PHP
?>  
<div class="margens">
<a href="incluir_forma_pagamentos.php" class="btn btn-primary">Nova forma Pagamento</a>
<br><br> 
<table id="myTable" class="table table-striped table-bordered dt-responsive nowrap">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Descrição</th>
      <th scope="col">Editar</th>
      <th scope="col">Excluir</th>
    </tr>
  </thead>
  <tbody>
  <?php
        $sql = "SELECT * FROM forma_pagamentos order by descricao_forma"; // Consulta a tabela
        $stmt = $pdo->query($sql); // Executa a consulta usando PDO
        // Laço para trazer os dados da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_forma_pagto = $row['id_forma_pagto'];
            $descricao_forma = $row['descricao_forma'];
   ?>
    <tr>
      <td><?php echo htmlspecialchars($id_forma_pagto); ?></td>
      <td><?php echo htmlspecialchars($descricao_forma); ?></td>
      <td><a href="editar_forma_pagamentos.php?id_forma_pagto=<?php echo 
      htmlspecialchars($id_forma_pagto); ?>" 
      class="btn btn-primary">Editar</a></td>
      <td><a href="#" onclick="confirmarExclusao(<?php echo htmlspecialchars($id_forma_pagto); ?>)" 
      class="btn btn-danger">Excluir</a></td>
    </tr>
    <?php
        }
    ?>
  </tbody>
</table>

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
        Tem certeza que deseja excluir essa forma de pagto?
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
<br><br><br>

<?php
include 'rodape.php';
?>  
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 
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
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
                },
                pageLength: 10,
                order: [[0, 'asc']],
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]]
            });
        });
    </script>

</body>
</html>

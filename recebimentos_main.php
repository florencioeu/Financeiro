
<?php

 
// Inclui os arquivos de conexão com o banco de dados e o menu da aplicação
include 'conexao.php'; 
include 'menu.php'; 

// Verifica se os valores foram enviados pelo formulário e os captura
// Se não forem enviados, atribui uma string vazia para evitar erros
$data_inicial = isset($_POST['data_inicial']) ? $_POST['data_inicial'] : '';
$data_final = isset($_POST['data_final']) ? $_POST['data_final'] : '';

// Monta a query para buscar recebimentos e suas relações com clientes e tipos de recebimento
$sql = "SELECT * FROM recebimentos 
        INNER JOIN clientes ON recebimentos.id_Cliente = clientes.id_Cliente 
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

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">  
<link rel="stylesheet" type="text/css" href="style.css">



<div class="margens">
    <!-- Formulário para entrada de datas de pesquisa -->
    <form action="recebimentos_main.php" method="post"> 
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
                <button type="submit" id="botao" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                    <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/>
                    </svg>
                    Pesquisar
                </button>

            </div>
        </div>  
    </form> 

    <br>
    <!-- Link para adicionar um novo recebimento -->
    <a href="incluir_recebimentos.php" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
    <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/>
    </svg>
     Novo recebimento
    </a>

    <br><br> 
    
    <!-- Tabela para exibir os recebimentos filtrados -->
    <table id="myTable" class="table table-striped table-bordered dt-responsive nowrap">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Dt.Vcto</th>
                <th>Valor</th>
                <th>Editar</th>
                <th>Excluir</th>

            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_recebimento']); ?></td>
                <td><?php echo htmlspecialchars($row['nome_cliente']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                <!-- Formata a data para o formato brasileiro -->
                <td><?php echo date("d/m/Y", strtotime($row['data_vcto'])); ?></td>
                <!-- Formata o valor para exibição com duas casas decimais -->
                <td><?php echo number_format($row['valor'], 2, ",", "."); ?></td>
                <!-- Botão para editar o recebimento -->
                <td>
                <a href="editar_recebimentos.php?id_recebimento=<?php echo htmlspecialchars($row['id_recebimento']); ?>" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                </svg>
                Editar
                </a>
                </td>

                <!-- Botão para excluir o recebimento -->
                <td>
                <a href="#" onclick="confirmarExclusao(<?php echo htmlspecialchars($row['id_recebimento']); ?>)" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                </svg>
                Excluir
                </a>
                </td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script

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

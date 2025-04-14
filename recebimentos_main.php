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

<div class="container">
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
                <button type="submit" id="botao" class="btn btn-primary">Pesquisar</button>
            </div>
        </div>  
    </form> 

    <br>
    <!-- Link para adicionar um novo recebimento -->
    <a href="incluir_recebimentos.php" class="btn btn-primary">Novo recebimento</a>
    <br><br> 
    
    <!-- Tabela para exibir os recebimentos filtrados -->
    <table class="table table-striped">
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
                <td><a href="editar_recebimentos.php?id_recebimento=<?php echo htmlspecialchars($row['id_recebimento']); ?>" class="btn btn-primary">Editar</a></td>
                <!-- Botão para excluir o recebimento -->
                <td><a href="#" onclick="confirmarExclusao(<?php echo htmlspecialchars($row['id_recebimento']); ?>)" class="btn btn-danger">Excluir</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- CSS do bootstrap, título do relatório -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<div class="container">

<img src="logo_senac.png" width="200px" alt="">
<br><br>
<h2>Relatório de fluxo de Caixa</h2>    
<?php
// Conexão com banco de dados
include 'conexao.php';
// iniamos a criação de uma tabela temporaria juntando os recebimentos e pagamentos. Somamos entrada e saida dia a dia para depois inserir os saldos diários
$sql = "CREATE TEMPORARY TABLE fluxo_caixa AS
        SELECT data_vcto,
               SUM(CASE WHEN origem = 'recebimentos' THEN COALESCE(valor, 0) ELSE 0 END) AS entrada,
               SUM(CASE WHEN origem = 'pagamentos' THEN COALESCE(valor, 0) ELSE 0 END) AS saida
        FROM (
            SELECT CAST(data_vcto AS DATE) AS data_vcto, COALESCE(valor, 0) AS valor, 'recebimentos' AS origem FROM recebimentos
            UNION ALL
            SELECT CAST(data_vcto AS DATE) AS data_vcto, COALESCE(valor, 0) AS valor, 'pagamentos' AS origem FROM pagamentos
        ) AS combined
        GROUP BY data_vcto";
 
// Prepara a consulta para evitar SQL Injection
$stmt = $pdo->prepare($sql);
 
// Executa a consulta
if ($stmt->execute()) {
    // Consulta para obter os dados da tabela temporária
    $query = "SELECT * FROM fluxo_caixa";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
   
    // Verifica se há resultados
    if ($stmt->rowCount() > 0) {
        // variável de saldo inicial
        $saldo=0;
        ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Saldo</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
 
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            //laço para exibir os registros
            ?>
            <!-- data do vencimento formatada para dd/mm/aaaa -->
            <td><?php echo date("d/m/Y", strtotime($row['data_vcto'])); ?></td>
            <!-- Valor das entradas formatadas em reais -->
            <td><?php echo number_format($row['entrada'], 2, ",", "."); ?></td>
            <!-- Valor das Saidas formatadas em reais -->
            <td><?php echo number_format($row['saida'], 2, ",", "."); ?></td>
            <?php
            // Calculando o saldo do dia (saldo anterior + entrada do dia - saida do dia)
            $saldo=$saldo+$row['entrada']-$row['saida'];
            ?>
            <td><?php echo(number_format($saldo, 2, ",", "."))?></td>
            </tr>
            <?php
            // Fecha o laço para ir para o próximo dia (registro)
        endwhile;
        ?>
                </tbody>
            </table>
        <?php
    } else {
        echo "<p>Nenhum resultado encontrado.</p>";
    }
} else {
    echo "<p>Erro ao executar a consulta.</p>";
}
?>
<!-- irá carregar o relatório para o video e impressora -->
<body onLoad="self.print();"></body>
</div>

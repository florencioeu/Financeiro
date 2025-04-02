<?php
   include 'conexao.php'; 
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo Pagamento', 'Totais'],

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
             while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)): 
          ?>
          ['<?php echo($row['descricao_tipo']) ?>', <?php echo($row['total']) ?>],

          <?php endwhile; ?>
        ]);

        var options = {
          title: 'Pagamentos por periodo',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
  <body>
  <div id="piechart_3d" style="width: 550px; height: 300px; margin: 0 auto; display: block;">
  </div>

  </body>
</html>
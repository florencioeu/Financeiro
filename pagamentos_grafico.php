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
                 $sql2 = "SELECT tipo_pagamentos.descricao_tipo,sum(valor) as total FROM pagamentos inner join tipo_pagamentos on pagamentos.id_tipo_pagto=tipo_pagamentos.id_tipo_pagto WHERE 1=1";
          
                 if (!empty($data_inicial) && !empty($data_final)) {
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
          ['<?php echo htmlspecialchars($row['descricao_tipo']); ?>', <?php 
          echo number_format($row['total'], 2, ",", "."); ?>],

          <?php endwhile; ?>
          ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
  </body>
</html>
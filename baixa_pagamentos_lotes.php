<?php
include("conexao.php");
$total = $_POST["total"];
// pagamos o total dos registros para a variavel $total
for ($i = 1; $i <= $total; $i++) {
    // Laço de 1 até o $total
    // Peguei o id do pagamento
    $id_pagamento = $_POST["id_pagamento$i"];
    // Verifica se o checkbox foi clicado, ou seja, o valor dele tem que ser = 1 e não pode estar vazio
    if (isset($_POST["check$i"]) && $_POST["check$i"] == 1) {
        // Só irá baixar que estiver clicado
        // a data do pagamento vai ser igual a data do vencimento e o valor do pagamento vai set igual ao valor original
        $sql = "update pagamentos set data_pagto=data_vcto, valor_pago=valor where id_pagamento=$id_pagamento";
        $stmt = $pdo->prepare($sql);
        // Executa a query individualmente
        $stmt->execute();
        // Retorna a lista dos pagamentos (contas a pagar)
      
    } 
}
header("Location: pagamentos_main.php");
?>
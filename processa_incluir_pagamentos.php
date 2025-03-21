<?php	
$data_vcto = isset($_POST['data_vcto']) ? $_POST['data_vcto'] : '';
$parcelas = isset($_POST['parcelas']) ? (int) $_POST['parcelas'] : 0;
$id_fornecedor = isset($_POST['id_fornecedor']) ? $_POST['id_fornecedor'] : '';
$descricao = $_POST['descricao']; 
$valor = $_POST['valor']; 
$id_tipo_pagto = $_POST['id_tipo_pagto']; 
$id_forma_pagto = $_POST['id_forma_pagto']; 

// Converte a data para um objeto DateTime
$data = DateTime::createFromFormat('Y-m-d', $data_vcto);
$dia_original = $data->format('d'); // Guarda o dia original

if ($data) {
    for ($i = 1; $i <= $parcelas; $i++) {
        // Obtém o mês e o ano atual
        $mes = $data->format('m');
        $ano = $data->format('Y');

        // Exibe a data atual (pode descomentar se precisar ver a data durante o loop)
        // echo $data->format('Y-m-d') . "<br/>";

        try {
            // Usando a data calculada no lugar de $data_vcto
            $sql = "INSERT INTO pagamentos (id_fornecedor, data_vcto, valor, descricao, id_tipo_pagto, id_forma_pagto) 
                    VALUES (:id_fornecedor, :data_vcto, :valor, :descricao, :id_tipo_pagto, :id_forma_pagto)";

            $stmt = $pdo->prepare($sql); // Preparando a consulta SQL

            // Vinculando os parâmetros
            $stmt->bindParam(':id_fornecedor', $id_fornecedor);
            $stmt->bindParam(':data_vcto', $data->format('Y-m-d'));  // Aqui usamos a data calculada
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':id_tipo_pagto', $id_tipo_pagto);
            $stmt->bindParam(':id_forma_pagto', $id_forma_pagto);

            if ($stmt->execute()) {
                // Redireciona para outra página se a inserção for bem-sucedida
                header("Location: pagamentos_main.php");
            } else {
                echo "Erro ao inserir registro.";
            }
        } catch (PDOException $e) {
            // Exceção em caso de erro na execução
            echo "Erro: " . $e->getMessage();
        }

        // Adiciona um mês à data para calcular a próxima parcela
        $data->modify('+1 month');

        // Verifica o último dia do mês para evitar ultrapassar o limite
        $ultimo_dia_mes = cal_days_in_month(CAL_GREGORIAN, $data->format('m'), $data->format('Y'));

        // Ajusta a data para o último dia do mês caso o dia ultrapasse o limite
        if ($data->format('d') > $ultimo_dia_mes) {
            $data->setDate($data->format('Y'), $data->format('m'), $ultimo_dia_mes);
        }
    }
} else {
    echo "Data inválida!";
}
?>

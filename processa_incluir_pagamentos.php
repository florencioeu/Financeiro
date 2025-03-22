<?php
include 'conexao.php'; // Conexão com o banco de dados

// Obtém os valores do formulário
$data_vcto = isset($_POST['data_vcto']) ? $_POST['data_vcto'] : '';
$parcelas = isset($_POST['parcelas']) ? (int) $_POST['parcelas'] : 0;
$id_fornecedor = isset($_POST['id_fornecedor']) ? $_POST['id_fornecedor'] : '';
$descricao = $_POST['descricao']; 
$valor = $_POST['valor']; 
$id_tipo_pagto = $_POST['id_tipo_pagto']; 
$id_forma_pagto = $_POST['id_forma_pagto']; 

// Converte a data para um objeto DateTime
$data = DateTime::createFromFormat('Y-m-d', $data_vcto);
if (!$data) {
    echo "Data inválida!";
    exit;
}

$dia_original = $data; // Guarda o dia original
$dia = $dia_original->format('d'); // Corrigido
$mes = $dia_original->format('m'); // Corrigido
$ano = $dia_original->format('Y'); // Corrigido
$data_vcto_parcela = $ano . "-" . $mes . "-" . $dia;
for ($i = 1; $i <= $parcelas; $i++) {
    
    // Insere o registro no banco
    $sql = "INSERT INTO pagamentos (id_fornecedor, data_vcto, valor, descricao, id_tipo_pagto, id_forma_pagto) 
            VALUES (:id_fornecedor, :data_vcto, :valor, :descricao, :id_tipo_pagto, :id_forma_pagto)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor);
    $stmt->bindParam(':data_vcto', $data_vcto_parcela);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':id_tipo_pagto', $id_tipo_pagto);
    $stmt->bindParam(':id_forma_pagto', $id_forma_pagto);
    
    if (!$stmt->execute()) {
        echo "Erro ao inserir registro.";
    }
    
// Adiciona um mês corretamente
$mes = $mes + 1;
if ($mes > 12) {
    $mes = 1;
    $ano = $ano + 1;
}

// Verifica se é fevereiro e ajusta o dia se necessário
if ($mes == 2 && $dia > 28) {
    // Verifica se é um ano bissexto
    if (($ano % 4 == 0 && $ano % 100 != 0) || ($ano % 400 == 0)) {
        $data_vcto_parcela = $ano . "-" . $mes . "-29";
    } else {
        $data_vcto_parcela = $ano . "-" . $mes . "-28";
    }
} else {
    $data_vcto_parcela = $ano . "-" . $mes . "-" . $dia;
}

     
}

// Redireciona após a inserção
header("Location: pagamentos_main.php");
exit;
?>
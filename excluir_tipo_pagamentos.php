<?php
// excluir_tipo_pagamentos.php
include 'conexao.php'; // Conectamos ao banco de dados
 
$id_tipo_pagto = $_GET['id_tipo_pagto'];
 
$sql = "DELETE FROM tipo_pagamentos WHERE id_tipo_pagto = :id_tipo_pagto";
 
try {
    $stmt = $pdo->prepare($sql); // Prepara a declaração SQL
    $stmt->bindParam(':id_tipo_pagto', $id_tipo_pagto, PDO::PARAM_INT);
    $stmt->execute(); // Executa a exclusão
 
    header("Location: tipo_pagamentos_main.php");
    exit(); // Certifica que o script para aqui após o redirecionamento
} catch (PDOException $e) {
    // Verifica se o erro é devido a uma restrição de chave estrangeira
    if ($e->getCode() == '23000') {
        echo "<script>
                alert('Erro: Não é possível excluir esta tipo de pagamento pois está associada a outros registros.');
                window.location.href='tipo_pagamentos_main.php';
              </script>";
    } else {
        echo "Erro ao excluir: " . $e->getMessage(); // Mensagem genérica para outros erros
    }
}
?>
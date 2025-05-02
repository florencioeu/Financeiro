<?php
include 'conexao.php'; // Conectamos ao banco de dados
$id_forma_pagto = $_POST['id_forma_pagto']; // Chave {Não é alterada}
$descricao_forma = $_POST['descricao_forma'];

$sucesso = false; // flag para saber se foi bem-sucedido

try {
    $sql = "UPDATE forma_pagamentos SET 
        descricao_forma = :descricao_forma 
        WHERE id_forma_pagto = :id_forma_pagto";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_forma_pagto', $id_forma_pagto, PDO::PARAM_INT); 
    $stmt->bindParam(':descricao_forma', $descricao_forma);
    if ($stmt->execute()) {
        $sucesso = true;
    } else {
        $mensagemErro = "Erro ao alterar registro.";
    }
} catch (PDOException $e) {
    $mensagemErro = "Erro: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Forma de Pagamento</title>
    <link rel="stylesheet" 
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Modal de sucesso -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalLabel">Sucesso</h5>
          </div>
          <div class="modal-body">
            A forma de pagamento foi alterada com sucesso.
          </div>
          <div class="modal-footer">
            <a href="forma_pagamentos_main.php" class="btn btn-primary">OK</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de erro -->
    <?php if (!$sucesso): ?>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="modalLabelErro" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalLabelErro">Erro</h5>
          </div>
          <div class="modal-body">
            <?php echo htmlspecialchars($mensagemErro); ?>
          </div>
          <div class="modal-footer">
            <a href="forma_pagamentos_main.php" class="btn btn-danger">Voltar</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            <?php if ($sucesso): ?>
                $('#successModal').modal('show');
            <?php else: ?>
                $('#errorModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>
</html>

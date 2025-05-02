<?php
// Inclui os arquivos de conexão com o banco de dados e o menu da aplicação
include 'conexao.php'; 
include 'menu.php'; 

// Recupera o ID do recebimento passado pela URL
$id_recebimento = isset($_GET['id_recebimento']) ? $_GET['id_recebimento'] : '';

// Se o ID não for fornecido, redireciona para a página principal
if (empty($id_recebimento)) {
    header("Location: recebimentos_main.php");
    exit();
}

// Busca os dados do recebimento no banco de dados com base no ID
$sql = "SELECT * FROM recebimentos WHERE id_recebimento = :id_recebimento";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_recebimento', $id_recebimento);
$stmt->execute();

// Verifica se o recebimento foi encontrado
$recebimento = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$recebimento) {
    echo "Recebimento não encontrado.";
    exit();
}

// Inicializa as variáveis para preencher os campos do formulário
$descricao = $recebimento['descricao'];
$data_vcto = $recebimento['data_vcto'];
$valor = $recebimento['valor'];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera os dados do formulário
    $descricao = $_POST['descricao'];
    $data_vcto = $_POST['data_vcto'];
    $valor = $_POST['valor'];

    // Atualiza os dados no banco de dados
    $sql = "UPDATE recebimentos SET descricao = :descricao, data_vcto = :data_vcto, valor = :valor WHERE id_recebimento = :id_recebimento";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':data_vcto', $data_vcto);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':id_recebimento', $id_recebimento);

    if ($stmt->execute()) {
        // Redireciona para a página de listagem após a atualização
        header("Location: recebimentos_main.php");
        exit();
    } else {
        echo "Erro ao atualizar os dados.";
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">Editar Recebimento</h2>

    <!-- Formulário de edição -->
    <form action="editar_recebimentos.php?id_recebimento=<?php echo htmlspecialchars($id_recebimento); ?>" method="POST" class="p-4 border rounded shadow-sm bg-light">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-3">
                <label for="descricao" class="form-label text-info">Descrição</label>
                <input type="text" name="descricao" id="descricao" class="form-control border-primary" value="<?php echo htmlspecialchars($descricao); ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="data_vcto" class="form-label text-info">Data de Vencimento</label>
                <input type="date" name="data_vcto" id="data_vcto" class="form-control border-primary" value="<?php echo htmlspecialchars($data_vcto); ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="valor" class="form-label text-info">Valor</label>
                <input type="text" name="valor" id="valor" class="form-control border-primary" value="<?php echo number_format($valor, 2, ',', '.'); ?>" required>
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-success px-4">Salvar Alterações</button>
            <a href="recebimentos_main.php" class="btn btn-danger px-4">Cancelar</a>
        </div>
    </form>
</div>
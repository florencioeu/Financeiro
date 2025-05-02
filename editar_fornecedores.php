<!-- editar_fornecedores.php -->
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - Edição</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
include 'conexao.php';
include 'menu.php';
$id_fornecedor = $_GET['id_fornecedor'];
$sql = "SELECT * FROM fornecedores WHERE id_fornecedor = :id_fornecedor";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
$stmt->execute();
$fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

if ($fornecedor) {
    extract($fornecedor);
}
?>
<div class="margens">
    <div class="form-row">
        <div class="card-body">
            <h4 class="mb-4">Editar Fornecedor</h4>
            <form action="processa_editar_fornecedores.php" method="post">
                <input type="hidden" name="id_fornecedor" value="<?php echo $id_fornecedor ?>">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>CPF/CNPJ</label>
                        <input type="text" name="cpf_cnpj" class="form-control cpfOuCnpj" value="<?php echo $cpf_cnpj ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nome Fornecedor</label>
                        <input type="text" name="nome_fornecedor" class="form-control" value="<?php echo $nome_fornecedor ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Celular</label>
                        <input type="text" name="celular" class="form-control" value="<?php echo $celular ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control" value="<?php echo $cep ?>">
                    </div>

                    <div class="form-group col-md-8">
                        <label>Endereço</label>
                        <input type="text" name="logradouro" class="form-control" value="<?php echo $logradouro ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Número</label>
                        <input type="text" name="numero" class="form-control" value="<?php echo $numero ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Complemento</label>
                        <input type="text" name="complemento" class="form-control" value="<?php echo $complemento ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control" value="<?php echo $bairro ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label>Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="<?php echo $cidade ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Estado</label>
                        <input type="text" name="estado" class="form-control" value="<?php echo $estado ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nome do Contato</label>
                    <input type="text" name="contato" class="form-control" value="<?php echo $contato ?>">
                </div>

                <button type="submit" class="btn btn-primary">Alterar</button>
                <a href="fornecedores_main.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
<?php
include 'rodape.php';
?>  
<!-- Scripts -->
    <!-- Carregando bibliotecas corretamente -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>

    <script type="text/javascript">
        var options = {
            onKeyPress: function (cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }
        
        $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);
        
        // Função para buscar CEP via API do ViaCEP
        $(document).ready(function() {
            $("#cep").blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep.length === 8) {
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/", function(dados) {
                        if (!("erro" in dados)) {
                            $("#logradouro").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#estado").val(dados.uf);
                        } else {
                            alert("CEP não encontrado.");
                        }
                    });
                }
            });
        });

// Função para buscar CNPJ na API do minhareceita.org
$(document).ready(function() {
    $("#cpf_cnpj").blur(function() {
        var cpf_cnpj = $(this).val().replace(/\D/g, ""); // Remove caracteres não numéricos

        if (cpf_cnpj.length === 14) { // CNPJ válido sem pontuação
            $.getJSON(`https://minhareceita.org/${cpf_cnpj}`, function(dados) {
                if (!dados.erro) {
                    $("#nome_fornecedor").val(dados.razao_social || "");
                    $("#logradouro").val((dados.descricao_tipo_de_logradouro || "") + " " + (dados.logradouro || ""));
                    $("#cep").val(dados.cep || "");
                    $("#cidade").val(dados.municipio || "");
                    $("#estado").val(dados.uf || "");
                    $("#bairro").val(dados.bairro || "");
                    $("#numero").val(dados.numero || "");
                    $("#complemento").val(dados.complemento || "");
                    $("#contato").val(dados.nome_socio || "");
                } else {
                    alert("CNPJ não encontrado.");
                }
            }).fail(function() {
                alert("Erro ao consultar a API.");
            });
        }
    });
});

    </script>
</body>
</html>

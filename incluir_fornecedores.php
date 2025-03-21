<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - Inclusão</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7z27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php
        include 'menu.php';  // incluímos o menu nesse PHP
    ?> 
    <div class="container">
        <form action="processa_incluir_fornecedores.php" method="post">
            <label for="cpfcnpj">CPF/CNPJ - <span style="color: red;">Somente os números</span></label>
            <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control cpfOuCnpj" 
            placeholder="Entre com o CPF/CNPJ" required> 
            
            <label for="nome_fornecedor">Nome Fornecedor</label>
            <input type="text" id="nome_fornecedor" name="nome_fornecedor" class="form-control" 
            placeholder="Entre com o nome" required>

            <label for="celular">Celular</label>
            <input type="text" id="celular" name="celular" class="form-control" 
            placeholder="Entre com o Celular"> 

            <label for="email">E-mail</label> 
            <input type="text" id="email" name="email" class="form-control" 
            placeholder="Entre com o E-mail">     

            <label for="cep">CEP - <span style="color: red;">Somente os números</span></label>
            <input type="text" id="cep" name="cep" class="form-control" onblur="formatarCEP(this)"
            placeholder="Entre com o CEP">

            <label for="logradouro">Endereço</label> 
            <input type="text" id="logradouro" name="logradouro" class="form-control" 
            placeholder="Entre com o Endereço">

            <label for="numero">Número</label> 
            <input type="text" id="numero" name="numero" class="form-control" 
            placeholder="Entre com o Número"> 

            <label for="complemento">Complemento</label> 
            <input type="text" id="complemento" name="complemento" class="form-control" 
            placeholder="Entre com o Complemento"> 

            <label for="bairro">Bairro</label> 
            <input type="text" id="bairro" name="bairro" class="form-control" 
            placeholder="Entre com o Bairro"> 

            <label for="cidade">Cidade</label>    
            <input type="text" id="cidade" name="cidade" class="form-control" 
            placeholder="Entre com a Cidade">

            <label for="estado">Estado</label> 
            <input type="text" id="estado" name="estado" class="form-control" 
            placeholder="Entre com o Estado">

            <label for="contato">Nome do Contato</label> 
            <input type="text" id="contato" name="contato" class="form-control" 
            placeholder="Entre com o nome do Contato">                                          

            <button type="submit" id="botao" class="btn btn-primary">Incluir</button>        
        </form>
    </div>

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
        // converte o JSON para os inputs que declaramos no form
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
      // converte o JSON para os inputs que declaramos no form
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

    // função para mascaramento do CEP após digitado, pra inserir o tracinho
    function formatarCEP(input) { 
    let valor = input.value.replace(/\D/g, ""); // Remove tudo que não for número
    if (valor.length > 5) {
        valor = valor.substring(0, 5) + "-" + valor.substring(5, 8);
    }
    input.value = valor;
    }
</script>

    </script>
</body>
</html>

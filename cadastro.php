<html>
<head>
  <meta charset="utf-8">
  <title>Cadastro de Usuário- Inclusão</title>
  <!-- CSS only -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div style="padding: 10px"> <!-- um pequeno espaço acima -->
<div class="container" style="width: 400px; text-align: center; margin: auto;">
    <!-- largura, centralizado e margem automatica -->
<img src="https://logodix.com/logo/1872111.png" width="250px">  
<h3>Cadastro de Usuários</h3>
<br>
<form action="processa_incluir_usuario.php" method="post">
  <div class="form-group">
      <label>Nome do Usuário</label>
      <input type="text" name="nome_usuario" id="nome_usuario"
      class="form-control" required autocomplete="off" placeholder="Nome Completo">
  </div>
  <div class="form-group">
      <label>E-mail</label>
      <input type="email" name="email" id="email" class="form-control"
      required autocomplete="off" placeholder="E-mail Usuário">
  </div>
  <div class="form-group">
      <label>Senha do Usuário</label>
      <input type="password" name="senha" id="senha" class="form-control"
       required autocomplete="off" placeholder="Senha Usuário">
  </div>
  <div class="form-group">
      <label>Repetir senha</label>
      <input type="password" name="senhausuario2" class="form-control"
      required autocomplete="off" placeholder="Repetir senha usuario"
      oninput="validaSenha(this)">
      <small>A senha deve ser igual a de cima.</small>
  </div>
  <div style="text-align: right;">
    <button type="submit" id="botao" class="btn btn-sm btn-primary">Gravar</button>
  </div>
</form>
</div>
</div>
 
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
 
<script>
function validaSenha (input){
  if (input.value != document.getElementById('senha').value) {
    input.setCustomValidity('Repita a senha corretamente');
  } else {
    input.setCustomValidity('');
  }
}
</script>
 
</body>
</html>
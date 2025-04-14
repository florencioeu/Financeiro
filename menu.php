<?php 
session_start(); // Inicia a sessão
// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('location:usuario_recusado.php');
    exit();
}
// Obtém os dados da sessão
$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome_usuario'];
$foto = $_SESSION['foto'];
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brad" href="principal.php">
  <img src="https://cdna.artstation.com/p/assets/images/images/005/172/886/large/joao-pedro-oliveira-logo.jpg?1489030448" width="150px" alt="">
  </a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="principal.php">Home <span class="sr-only">(página atual)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cadastros
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="fornecedores_main.php">Fornecedores</a>
          <a class="dropdown-item" href="clientes_main.php">Clientes</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="tipo_pagamentos_main.php">Tipo Pagamentos</a>
          <a class="dropdown-item" href="forma_pagamentos_main.php">Forma Pagamentos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="usuarios_main.php">Usuários</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pagamentos_main.php">Contas a Pagar</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" href="recebimentos_main.php">Contas a Receber</a>
      </li>            
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Relatórios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="relatorio_pagamentos.php">Pagamentos</a>
          <a class="dropdown-item" href="#">Recebimentos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="relatorio_fluxo.php" >Fluxo de Caixa</a>
         
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logoff.php">Sair do sistema</a>
      </li>      
    </ul>
  
  </div>

</nav>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .login-container {
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #fff;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
        }
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .centralizado {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Centraliza verticalmente na tela inteira */
        }        
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">

    <div class="centralizado">
    <div class="login-container">
  
        <img src="https://logodix.com/logo/1872111.png" width="200px" alt="Logotipo" class="logo">
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group password-wrapper">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p class="text-center mt-3">
                <a href="cadastro.php">Cadastrar novo usuário</a>
            </p>
        </form>
    </div>
    </div>
    <script>
        function togglePassword() {
            var senha = document.getElementById("senha");
            var icon = document.querySelector(".toggle-password i");
            if (senha.type === "password") {
                senha.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                senha.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

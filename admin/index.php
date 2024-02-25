<?php
require_once 'clsLogin-Cadastro.php';
$u = new user;
$u->conectar();


if(isset($_POST['entrar'])) {
    $nome = $_POST['usuario'];
    $senha = $_POST['senha'];

    if (!empty($nome) && !empty($senha)) {
        if ($u->msgErro == "") {
            if ($u->logar($nome, $senha)) {
                echo "<script language='javascript'>alert('Logado Com sucesso');</script>";
                echo "<script language='javascript'>window.location='menu.php';</script>";

            } else {
                
                echo "<script language='javascript'>alert('nao foi possivel logar');</script>";
            }
        } else {
            echo "Erro: " . $u->msgErro;
        }
    }
}
           
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">

</head>

<body>
    <div class="page">
        <form method="POST" class="formLogin">
            <h1>Login</h1>
            <p>Digite os seus dados de acesso no campo abaixo.</p>
            <label for="usuario" name="usuario">Usuário</label>
            <input type="usuario" name="usuario" placeholder="Digite seu usuario" autofocus="true" />
            <label for="senha">Senha</label>
            <input type="password" name="senha" placeholder="Digite sua senha" />
            <a href="cadastro.php">Criar Cadastro</a>
            <input type="submit" name="entrar" class="btn" />
        </form>
    </div>

</body>

</html>
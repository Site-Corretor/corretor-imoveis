<?php

require_once 'clsLogin-Cadastro.php';

$u = new User;
$u->conectar();
$codigoSeg = $u->seguranca();

if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $codigo = $_POST['codigo'];

    if ($codigo == $codigoSeg[0]['seguranca']) {
        if (!empty($nome) && !empty($email) && !empty($senha)) {
            if ($u->msgErro == "") {
                if ($u->cadastrar($nome, $senha, $email)) {
                    echo "<script language='javascript'>alert('Cadastrado Com sucesso');</script>";
                    echo "<script language='javascript'>window.location='index.php';</script>";
                } else {
                    echo "Erro ao cadastrar";
                }
            } else {
                echo "Erro: " . $u->msgErro;
            }
        }
    } else {
        echo "<script language='javascript'>alert('Codigo Invalido');</script>";
        echo "<script language='javascript'>window.location='cadastro.php';</script>";}
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico">

    <title>Formulario responsivo com html e css</title>
</head>

<body>
    <div class="box">
        <div class="img-box">
            <img src="img-formulario.png">
        </div>
        <div class="form-box">
            <h2>Criar Conta</h2>
            <p> Já é um membro? <a href="index.php"> Login </a> </p>
            <form method="post">
                <div class="input-group">
                    <label for="nome"> Usuario</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite o seu Usuario" required>
                </div>
                <div class="input-group w50">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>
                <div class="input-group w50">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" placeholder="codigo" required>
                </div>
                <div class="input-group w50">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Digite o seu email" required>
                </div>
                <div class="input-group">
                    <button type="submit">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>
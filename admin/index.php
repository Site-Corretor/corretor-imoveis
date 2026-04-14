<?php
require_once 'clsLogin-Cadastro.php';
$u = new user;
$u->conectar();

$mensagemErro = "";
$mensagemSucesso = "";

if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso') {
    $mensagemSucesso = "Cadastro realizado com sucesso. Agora você já pode entrar.";
}

if (isset($_POST['entrar'])) {
    $nome = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    if (!empty($nome) && !empty($senha)) {
        if ($u->msgErro == "") {
            if ($u->logar($nome, $senha)) {
                header("Location: menu.php");
                exit;
            } else {
                $mensagemErro = "Não foi possível logar. Verifique usuário e senha.";
            }
        } else {
            $mensagemErro = "Erro: " . $u->msgErro;
        }
    } else {
        $mensagemErro = "Preencha usuário e senha.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel Administrativo</title>

    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/login.css?v=2">
</head>

<body>
    <main class="admin-login-page">
        <section class="admin-login-wrapper">
            <div class="admin-login-brand">
                <div class="admin-login-brand-overlay"></div>
                <div class="admin-login-brand-content">
                    <img src="../imagens/logo-ricardo.png?v=2" alt="Ricardo Souza Imóveis" class="admin-login-logo">

                    <span class="admin-login-badge">Painel administrativo</span>

                    <h1>Gerencie imóveis, cadastros e informações do site com mais controle.</h1>

                    <p>
                        Acesse o painel para cadastrar imóveis, atualizar informações e manter o site sempre organizado.
                    </p>
                </div>
            </div>

            <div class="admin-login-form-area">
                <form method="POST" class="admin-login-form">
                    <span class="admin-form-label-top">Acesso restrito</span>
                    <h2>Entrar no painel</h2>
                    <p>Digite seus dados de acesso para continuar.</p>

                    <?php if (!empty($mensagemErro)) { ?>   
                        <div class="auth-alert auth-alert-error">
                            <?php echo $mensagemErro; ?>
                        </div>
                    <?php } ?>

                    <div class="admin-input-group">
                        <label for="usuario">Usuário</label>
                        <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário" autofocus>
                    </div>

                    <div class="admin-input-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha">
                    </div>

                    <div class="admin-login-links">
                        <a href="cadastro.php">Criar cadastro</a>
                    </div>

                    <button type="submit" name="entrar" class="admin-login-btn">Entrar</button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
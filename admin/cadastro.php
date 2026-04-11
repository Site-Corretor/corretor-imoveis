<?php
session_start();
require_once 'clsLogin-Cadastro.php';

$u = new User;
$u->conectar();
$codigoSeg = $u->seguranca();

$mensagemErro = "";
$mostrarModalSucesso = false;

if (isset($_SESSION['cadastro_sucesso'])) {
    $mostrarModalSucesso = true;
    unset($_SESSION['cadastro_sucesso']);
}

if (isset($_POST['nome'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $codigo = trim($_POST['codigo']);

    $codigoValido = false;

    if (!empty($codigoSeg) && isset($codigoSeg[0]['seguranca'])) {
        $codigoValido = ($codigo == $codigoSeg[0]['seguranca']);
    }

    if (!$codigoValido) {
        $mensagemErro = "Código inválido.";
    } else {
        if (!empty($nome) && !empty($email) && !empty($senha)) {
            if ($u->msgErro == "") {
                $resultadoCadastro = $u->cadastrar($nome, $senha, $email);

                if ($resultadoCadastro === true) {
                    $_SESSION['cadastro_sucesso'] = true;
                    header("Location: cadastro.php");
                    exit;
                } else {
                    $mensagemErro = $resultadoCadastro;
                }
            } else {
                $mensagemErro = "Erro: " . $u->msgErro;
            }
        } else {
            $mensagemErro = "Preencha todos os campos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Painel Administrativo</title>

    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cadastro.css">
</head>

<body>
    <main class="admin-register-page">
        <section class="admin-register-wrapper">
            <div class="admin-register-brand">
                <div class="admin-register-brand-overlay"></div>
                <div class="admin-register-brand-content">
                    <img src="../imagens/logo-ricardo.png" alt="Ricardo Souza Imóveis" class="admin-register-logo">

                    <span class="admin-register-badge">Área administrativa</span>

                    <h1>Crie um novo acesso para o painel de gerenciamento.</h1>

                    <p>
                        Use esta área para cadastrar um novo usuário autorizado a acessar o sistema administrativo do site.
                    </p>
                </div>
            </div>

            <div class="admin-register-form-area">
                <form method="post" class="admin-register-form">
                    <span class="admin-form-label-top">Novo cadastro</span>
                    <h2>Criar conta</h2>
                    <p>Preencha os dados abaixo para liberar um novo acesso ao painel.</p>

                    <?php if (!empty($mensagemErro)) { ?>
                        <div class="cadastro-alerta-erro">
                            <?php echo htmlspecialchars($mensagemErro); ?>
                        </div>
                    <?php } ?>

                    <div class="admin-input-group">
                        <label for="nome">Usuário</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite o usuário" required>
                    </div>

                    <div class="admin-input-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite a senha" required>
                    </div>

                    <div class="admin-input-group">
                        <label for="codigo">Código de segurança</label>
                        <input type="text" id="codigo" name="codigo" placeholder="Digite o código" required>
                    </div>

                    <div class="admin-input-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite o e-mail" required>
                    </div>

                    <div class="admin-register-links">
                        <p>Já possui acesso? <a href="index.php">Entrar no painel</a></p>
                    </div>

                    <button type="submit" class="admin-register-btn">Cadastrar</button>
                </form>
            </div>
        </section>
    </main>

    <?php if ($mostrarModalSucesso) { ?>
        <div class="auth-modal-overlay active">
            <div class="auth-modal-box">
                <h3>Cadastro realizado</h3>
                <p>Usuário cadastrado com sucesso.</p>

                <div class="auth-modal-actions">
                    <a href="index.php" class="auth-modal-btn">OK</a>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

</html>
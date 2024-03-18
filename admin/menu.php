<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location: index.php");
    exit;
}
require_once 'clsControle.php';
$u = new user;
$u->conectar();

$casasCadastradas = $u->VisualizarImoveis();
$cadaDestaque = $u->casaDestaque();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela principal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #fafafa;
    }

    #sidebar {
        min-width: 250px;
        max-width: 250px;
        background: #7386D5;
        color: #fff;
        transition: all 0.3s;
    }

    #sidebar.active {
        margin-left: -250px;
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background: #6d7fcc;
    }

    #sidebar ul.components {
        padding: 20px 0;
        border-bottom: 1px solid #47748b;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.1em;
        display: block;
        color: #fff;
    }

    #sidebar ul li a:hover {
        background: #fff;
        color: #7386D5;
    }

    #content {
        width: 100%;
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
    }

    .card {
        background-color: #7386D5;
        color: #fff;
        margin-bottom: 20px;
    }

    .card-header,
    .card-footer {
        background-color: #6d7fcc;
        color: #fff;
    }

    @media (max-width: 768px) {
        #sidebar {
            margin-left: -250px;
        }

        #sidebar.active {
            margin-left: 0;
        }
    }
    </style>
</head>

<body>
    <div class="wrapper d-flex">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Principal</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="https://ricardosouzaimoveis.com.br/" target="_blank">Site</a>
                </li>
                <li>
                    <a href="cadastrarCasa.php" target="_blank">Cadastrar Imóvel</a>
                </li>

                <li>
                    <a href="logoff.php">Sair</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header"><i class="fas fa-book-open"></i> Imóveis Cadastrados</div>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo count($casasCadastradas) ?></h3>
                        </div>
                        <div class="card-footer text-right">
                            <a href="casasCadastradas.php" class="btn btn-light">
                                Abrir <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
    </script>
</body>

</html>
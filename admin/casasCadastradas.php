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

if (isset($_POST['pesquisar'])) {
    $codigo = $_POST['pesquisar'];
    $casaPesquisada = $u->VisualizarImoveisUnico($codigo);
    if (empty($casaPesquisada)) {
        echo "<script language='javascript'>alert('Casa não encontrada');</script>";
        echo "<script language='javascript'>window.location.href='casasCadastradas.php';</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Casas Registradas</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            margin: 20px 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 80%;
        }

        .table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            text-decoration: none;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .table .btn-primary:hover {
            background-color: #0056b3;
        }

        .search-bar {
            padding: 20px;
        }

        .search-input {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="search-bar">
            <form method="post" action="casasCadastradas.php">
                <input type="text" name="pesquisar" class="search-input" placeholder="Pesquise Pelo Codigo">
                <button type="submit" value="pesquisar" class="search-button">Pesquisar</button>
                <?php
                if (empty($casaPesquisada)) { ?>
                    <a href="menu.php" class="search-button">Voltar</a>
                <?php } else { ?>
                    <a href="casasCadastradas.php"  value="pesquisar" class="search-button">Voltar</a>
                <?php }
                ?>

            </form>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Destaque</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($casaPesquisada)) { ?>
                    <?php if (!empty($casasCadastradas)) { ?>
                        <?php for ($i = 0; $i < count($casasCadastradas); $i++) { ?>
                            <?php if ($casasCadastradas[$i]['ativo'] == '1') { ?>
                                <tr>
                                    <td scope="row"><?php echo $casasCadastradas[$i]['codigo']; ?></td>
                                    <td scope="row"><?php echo $casasCadastradas[$i]['titulo']; ?></td>
                                    <td scope="row"><?php echo $casasCadastradas[$i]['destaque']; ?></td>
                                    <td><a class="btn btn-primary" target="_blank" href="editarCasa.php?codigo=<?php echo $casasCadastradas[$i]['codigo']; ?>">Editar</a></td>
                                    <td><a class="btn btn-danger" target="_blank" href="excluirCasa.php?codigo=<?php echo $casasCadastradas[$i]['codigo']; ?>">Excluir</a></td>
                                </tr>
                    <?php }
                        }
                    }
                } else { ?>
                    <tr>
                        <td scope="row"><?php echo $casaPesquisada['codigo']; ?></td>
                        <td scope="row"><?php echo $casaPesquisada['titulo']; ?></td>
                        <td scope="row"><?php echo $casaPesquisada['destaque']; ?></td>
                        <td><a class="btn btn-primary" target="_blank" href="editarCasa.php?codigo=<?php echo $casaPesquisada['codigo']; ?>">Editar</a></td>
                        <td><a class="btn btn-danger" target="_blank" href="excluirCasa.php?codigo=<?php echo $casaPesquisada['codigo']; ?>">Excluir</a></td>
                    </tr>

                <?php } ?>
                <?php
                if (!empty($casaPesquisada)) { ?>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
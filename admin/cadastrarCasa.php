<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location: index.php");
    exit;
}
require_once 'clsControle.php';
$u = new user;
$u->conectar();
$casaDestaque  = $u->casaDestaque();

if (isset($_POST['cadastrar'])) {
    $titulo = $_POST['titulo'];
    $tipoImovel = $_POST['tipoImovel'];
    /*$total_area = $_POST['total-area'];
    $dormitorios = $_POST['dormitorios'];
    $banheiros = $_POST['banheiros'];
    $vagas = $_POST['vagas'];*/
    $descricao1 = $_POST['descricao1'];
    $descricao2 = $_POST['descricao2'];
    $descricao3 = $_POST['descricao3'];
    $preco = $_POST['preco'];
    $cidade = $_POST['cidade'];
    $destaque = $_POST['destaque'];

    if ($tipoImovel == "escolha") {
        echo "<script language='javascript'>alert('É necessario escolher o tipo de imovel');</script>";
    } else {
        if ($u->msgErro == "") {
            if ($destaque == "nao") {
                $codigo = $u->cadastrarImovel($titulo, $tipoImovel, $descricao1, $descricao2, $descricao3, /*$total_area, $dormitorios, $banheiros, $vagas,*/ $preco, $cidade, $destaque);
                if ($codigo) {
                    print_r($codigo);
                    echo "<script language='javascript'>alert('Salvo Com Sucesso');</script>";
                    echo "<script language='javascript'>window.location.href='imagem.php?codigo=$codigo';</script>";
                } else {
                    echo "<script language='javascript'>alert('Não foi possivel cadastrar imovel.');</script>";
                }
            } else {
                if (count($casaDestaque) >= 6) {
                    echo "<script language='javascript'>alert('Você ultrapassou o limite de imoveis em destaque.');</script>";
                } else {
                    $codigo = $u->cadastrarImovel($titulo, $tipoImovel, $descricao1, $descricao2, $descricao3, /*$total_area, $dormitorios, $banheiros, $vagas,*/ $preco, $cidade, $destaque);
                    if ($codigo) {
                        echo "<script language='javascript'>alert('Salvo Com Sucesso');</script>";
                        echo "<script language='javascript'>window.location.href='imagem.php?codigo=$codigo';</script>";
                    } else {
                        echo "<script language='javascript'>alert('Não foi possivel cadastrar imovel.');</script>";
                    }
                }
            }
        } else {
            echo "Erro: " . $u->msgErro;
        }
    }
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Imóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body class="bg-light">
    <div class="container my-4">
        <form method="post">
            <a href="menu.php" class="btn btn-primary mt-3 mb-3">Voltar</a>

            <div class="row">
                <div class="col-md-8">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" placeholder="Título" name="titulo">
                </div>

                <!--<div class="col-md-4">
                    <label for="total-area" class="form-label">Total de Área</label>
                    <input type="text" class="form-control" name="total-area" placeholder="Total de Área">
            </div>

            <div class="col-md-4">
                <label for="dormitorios" class="form-label">Dormitórios</label>
                <input type="text" class="form-control" name="dormitorios" placeholder="Dormitórios">
            </div>

            <div class="col-md-4">
                <label for="banheiros" class="form-label">Banheiros</label>
                <input type="text" class="form-control" name="banheiros" placeholder="Banheiros">
            </div>-->

                <div class="col-md-4">
                    <label for="tipo-imovel" class="form-label">Tipo de Imóvel</label>
                    <select class="form-control" name="tipoImovel">
                        <option value="escolha">Escolha um Imóvel</option>
                        <option value="residencia">Residência</option>
                        <option value="comercio">Comércio</option>
                        <option value="industria">Indústria</option>
                        <option value="terreno">Terreno</option>
                    </select>

                </div>
                <!--<div class="col-md-4">
                    <label for="vagas" class="form-label">Vagas</label>
                    <input type="text" class="form-control" name="vagas" placeholder="Vagas">
            </div>-->

                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 1</label>
                    <input type="text" class="form-control" name="descricao1" placeholder="Descrição">
                </div>
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 2</label>
                    <input type="text" class="form-control" name="descricao2" placeholder="Descrição">
                </div>
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 3</label>
                    <input type="text" class="form-control" name="descricao3" placeholder="Descrição">
                </div>
                <div class="col-md-4">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="text" class="form-control" name="preco" placeholder="Preço">
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" name="cidade" placeholder="Cidade">
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Imóvel Destaque</label>
                    <select class="form-control" name="destaque">
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3" name="cadastrar">Cadastar Imóvel</button>
        </form>
    </div>
</body>

</html>
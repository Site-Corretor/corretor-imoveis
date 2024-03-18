<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location: index.php");
    exit;
}
$codigo = $_GET['codigo'];

require_once 'clsControle.php';
$u = new user;
$u->conectar();
$editarCasa  = $u->EditarCasa($codigo);
$casaDestaque  = $u->casaDestaque();


if (isset($_POST['editar'])) {
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


    if ($u->msgErro == "") {
        if ($destaque == "nao") {
            if ($u->EditarImovel($codigo, $titulo, $tipoImovel, $descricao1, $descricao2, $descricao3, /*$total_area, $dormitorios, $banheiros, $vagas,*/ $preco, $cidade, $destaque)) {
                echo "<script language='javascript'>alert('Salvo Com Sucesso');</script>";
                echo "<script language='javascript'>window.location.href='casasCadastradas.php';</script>";
            } else {
                echo "<script language='javascript'>alert('Não foi possivel cadastrar imovel.');</script>";
            }
        } else {
            if (is_array($destaque) && count($destaque) >= 6) {
                echo "<script language='javascript'>alert('Você ultrapassou o limite de imoveis em destaque.');</script>";
            } else {
                if ($u->EditarImovel($codigo, $titulo, $tipoImovel, $descricao1, $descricao2, $descricao3, /*$total_area, $dormitorios, $banheiros, $vagas,*/ $preco, $cidade, $destaque)) {
                    echo "<script language='javascript'>alert('Salvo Com Sucesso');</script>";
                    echo "<script language='javascript'>window.location.href='casasCadastradas.php';</script>";
                } else {
                    echo "<script language='javascript'>alert('Não foi possivel cadastrar imovel.');</script>";
                }
            }
        }
    } else {
        echo "Erro: " . $u->msgErro;
    }
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico">

</head>

<body class="bg-light">
    <div class="container my-4">
        <form method="post">
            <a href="casasCadastradas.php" class="btn btn-primary mt-3 mb-3">Voltar</a>

            <div class="row">
                <div class="col-md-8">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" placeholder="Título" name="titulo" value="<?php echo $editarCasa[0]['titulo']; ?>">
                </div>

                <!--<div class="col-md-4">
                    <label for="total-area" class="form-label">Total de Área</label>
                    <input type="text" class="form-control" name="total-area" placeholder="Total de Área"
                        value="<?php echo $editarCasa[0]['total_area']; ?>">
            </div>

            <div class="col-md-4">
                <label for="dormitorios" class="form-label">Dormitórios</label>
                <input type="text" class="form-control" name="dormitorios" placeholder="Dormitórios"
                    value="<?php echo $editarCasa[0]['dormitorios']; ?>">
            </div>

            <div class="col-md-4">
                <label for="banheiros" class="form-label">Banheiros</label>
                <input type="text" class="form-control" name="banheiros" placeholder="Banheiros"
                    value="<?php echo $editarCasa[0]['banheiros']; ?>">
            </div>-->

                <div class="col-md-4">
                    <label for="tipo-imovel" class="form-label">Tipo de Imóvel</label>
                    <select class="form-control" name="tipoImovel" value="<?php echo $editarCasa[0]['tipo_imovel']; ?>">
                        <option> <?php echo $editarCasa[0]['tipo_imovel']; ?></option>
                        <option value="residencia">Residência</option>
                        <option value="comercio">Comércio</option>
                        <option value="industria">Indústria</option>
                        <option value="terreno">Terreno</option>
                    </select>

                </div>
                <!--<div class="col-md-4">
                    <label for="vagas" class="form-label">Vagas</label>
                    <input type="text" class="form-control" name="vagas" placeholder="Vagas"
                        value="<?php echo $editarCasa[0]['vagas']; ?>">
                </div>-->
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 1</label>
                    <input type="text" class="form-control" name="descricao1" placeholder="Descrição" value="<?php echo $editarCasa[0]['descricao1']; ?>">
                </div>
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 2</label>
                    <input type="text" class="form-control" name="descricao2" placeholder="Descrição" value="<?php echo $editarCasa[0]['descricao2']; ?>">
                </div>
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 3</label>
                    <input type="text" class="form-control" name="descricao3" placeholder="Descrição" value="<?php echo $editarCasa[0]['descricao3']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="text" class="form-control" name="preco" placeholder="Preço" value="<?php echo $editarCasa[0]['preco']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" name="cidade" placeholder="Cidade" value="<?php echo $editarCasa[0]['cidade']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Imóvel Destaque</label>
                    <select class="form-control" name="destaque">
                        <option> <?php echo $editarCasa[0]['destaque']; ?></option>
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3" name="editar">Salvar Imóvel</button>
            <a href="imagem.php?codigo=<?php echo $codigo ?>" class="btn btn-primary mt-3" target="_blank">Imagens</a>
        </form>
    </div>
</body>

</html>
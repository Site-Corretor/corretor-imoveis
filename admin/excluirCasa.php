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
$VisualizarCasa  = $u->VisualizarCasa($codigo);
$editarCasa  = $u->ExcluiCasa($codigo);

if (isset($_POST['excluir'])) {
    if ($u->msgErro == "") {
        $u->ExcluiCasa($codigo);
        echo "<script language='javascript'>alert('Excluido com sucesso');</script>";
        echo "<script language='javascript'>window.location.href='casasCadastradas.php';</script>";
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
    <title>Excluir Imóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body class="bg-light">
    <div class="container my-4">
        <form method="post">
            <a href="casasCadastradas.php" class="btn btn-primary mt-3 mb-3">Voltar</a>

            <div class="row">
                <div class="col-md-8">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" placeholder="Título" name="titulo"
                        value="<?php echo $VisualizarCasa[0]['titulo'];   ?>" disabled>
                </div>

                <!--<div class="col-md-4">
                    <label for="total-area" class="form-label">Total de Área</label>
                    <input type="text" class="form-control" name="total-area" placeholder="Total de Área"
                        value="<?php echo $VisualizarCasa[0]['total_area']; ?>" disabled>
                </div>

                <div class="col-md-4">
                    <label for="dormitorios" class="form-label">Dormitórios</label>
                    <input type="text" class="form-control" name="dormitorios" placeholder="Dormitórios"
                        value="<?php echo $VisualizarCasa[0]['dormitorios']; ?>" disabled>
                </div>

                <div class="col-md-4">
                    <label for="banheiros" class="form-label">Banheiros</label>
                    <input type="text" class="form-control" name="banheiros" placeholder="Banheiros"
                        value="<?php echo $VisualizarCasa[0]['banheiros']; ?>" disabled>
                </div>-->

                <div class="col-md-4">
                    <label for="tipo-imovel" class="form-label">Tipo de Imóvel</label>
                    <select class="form-control" name="tipoImovel"
                        value="<?php echo $VisualizarCasa[0]['tipo_imovel']; ?>" disabled>
                        <option> <?php echo $VisualizarCasa[0]['tipo_imovel']; ?></option>
                        <option value="residencia">Residência</option>
                        <option value="comercio">Comércio</option>
                        <option value="industria">Indústria</option>
                        <option value="terreno">Terreno</option>
                    </select>

                </div>
                <!--<div class="col-md-4">
                    <label for="vagas" class="form-label">Vagas</label>
                    <input type="text" class="form-control" name="vagas" placeholder="Vagas"
                        value="<?php echo $VisualizarCasa[0]['vagas']; ?>" disabled>
                </div>-->

                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 1</label>
                    <input type="text" class="form-control" name="descricao1" placeholder="Descrição"
                        value="<?php echo $VisualizarCasa[0]['descricao1']; ?>" disabled>
                </div>
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 2</label>
                    <input type="text" class="form-control" name="descricao2" placeholder="Descrição"
                        value="<?php echo $VisualizarCasa[0]['descricao2']; ?>" disabled>
                </div>
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição 3</label>
                    <input type="text" class="form-control" name="descricao3" placeholder="Descrição"
                        value="<?php echo $VisualizarCasa[0]['descricao3']; ?>" disabled>
                </div>
                <div class="col-md-4">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="text" class="form-control" name="preco" placeholder="Preço"
                        value="<?php echo $VisualizarCasa[0]['preco']; ?>" disabled>
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" name="cidade" placeholder="Cidade"
                        value="<?php echo $VisualizarCasa[0]['cidade']; ?>" disabled>
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Imóvel Destaque</label>
                    <select class="form-control" name="destaque" disabled>
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3" name="excluir">Excluir Imóvel</button>

        </form>
    </div>
</body>

</html>
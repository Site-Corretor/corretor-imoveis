<?php
require_once 'clsPrincipal.php';
$u = new Principal;
$u->conectar();
   
$visualizar = $u->visualizar();

$temTerrenos = false;
foreach ($visualizar as $imovel) {
    if ($imovel['tipo_imovel'] == 'terreno') {
        $temTerrenos = true;
        break;
    }
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricardo Souza - Corretor de Imóveis</title>
</head>

<body>
    <header>
        <div class="center">
            <div class="logo">
                <a href="index.php"><img src="imagens/logo-ricardo.png" width=145px height=70px> </a>
            </div>
            <!--logo-->
            <div class="menu">
                <a href="geral.php">
                    Imóveis
                </a>
                <a href="contato.php">
                    Contato
                </a>
            </div>
            <!--menu-->
        </div>
        <!--center-->
    </header>

    <div class="tipos-imoveis">
        <a href="filtroResidencias.php" class="botao-filtro">
            <div class="opcoes borda-ops fundo-ops">Residências</div>
        </a>
        <a href="filtroComercios.php" class="botao-filtro">
            <div class="opcoes borda-ops fundo-ops">Comércios</div>
        </a>
        <a href="filtroIndustrias.php" class="botao-filtro">
            <div class="opcoes borda-ops fundo-ops">Indústrias</div>
        </a>
        <a href="filtroTerrenos.php" class="botao-filtro">
            <div class="opcoes borda-ops fundo-ops">Terrenos</div>
        </a>
    </div>

    <section class="main">
        <h2 class="nome-lista">Terrenos disponíveis</h2>
        <div class="house-list">
            <?php 
            if($temTerrenos){
            
                for($i=0;$i<count($visualizar);$i++){
                    if($visualizar[$i]['tipo_imovel']=='terreno'){
                        $imagem = $u->imagem($visualizar[$i]['codigo']);
                        if ($visualizar[$i]['ativo'] == 1) {
                        ?>

            <div class="house">
                <?php echo '<img src="https://ricardosouzaimoveis.com.br/admin/upload/' .$imagem['img'] . '"
                                alt="Pré-visualização da imagem">';?>
                <div class="house-details">
                    <h3 class="casa-descricao"><?php echo $visualizar[$i]['titulo']?></h3>
                    <p class="texto-descricao"><?php echo $visualizar[$i]['cidade']?></p>
                    <!--<p class="descricao-casa"><i
                            class="fas fa-ruler-combined favicon"></i><?php echo $visualizar[$i]['total_area']?>m²</p>
                    <p class="descricao-casa"><i
                            class="fas fa-bed favicon"></i><?php echo $visualizar[$i]['dormitorios']?> dormitórios</p>
                    <p class="descricao-casa"><i
                            class="fas fa-restroom favicon"></i><?php echo $visualizar[$i]['banheiros']?> banheiros</p>
                    <p class="descricao-casa"><i
                            class="fas fa-warehouse favicon"></i><?php echo $visualizar[$i]['vagas']?> vagas de garagem
                    </p>-->
                    <wbr>
                    <p class="casa-descricao"><b><?php echo $visualizar[$i]['preco'] ?></b></p>
                    <p class="border-descrica-casa"></p>
                    <a href=<?php echo "'imovel.php?codigo=".$visualizar[$i]['codigo']."'"?>><button
                            class="house-button">Saber Mais</button></a>
                </div>
            </div>
            <?php
                }
                }
                }
            }else{
            ?>

            <div class="error-image">
                <img src="imagens/Icones/error.png" height=200px>
                <h2 class="nome-lista">Infelizmente não temos nenhum terreno disponível no momento</h2>
            </div>

            <?php
            }
            ?>
        </div>

        <div class="centralizar-conteudo">
            <a href="index.php"><button class="voltar-button">Início</button></a>
            <a href="geral.php"><button class="voltar-button">Voltar</button></a>
        </div>

        <div class="roda-pe">
            <div class="logo">
                <a href="index.php"><img src="imagens/logo-ricardo.png" width=120px height=60px></a>
            </div>
            <div class="separa">
                <img src="https://admin01.imobibrasil.net/t20/imagensc/rodape_ic-separa.png" alt="">
            </div>
            <div class="itens">
                <a href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank">
                    <img src="imagens/Icones/whatsapp.png" width=40px height=40px>
                </a>
                <p>(11) 97035-5935</p>
            </div>
            <div class="separa">
                <img src="https://admin01.imobibrasil.net/t20/imagensc/rodape_ic-separa.png" alt="">
            </div>
            <div class="itens">
                <a href="https://www.instagram.com/ricardonsouzaimoveis" target="_blank">
                    <img src="imagens/Icones/instagram.png" width=40px height=40px>
                </a>
                <p>@ricardonsouzaimoveis</p>
            </div>
        </div>

    </section>
    <!--main-->

    <footer>
        <p>&copy; 2023. Todos os direitos reservados.</p>
    </footer>

</body>
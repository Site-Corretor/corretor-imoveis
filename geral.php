<?php
require_once 'clsPrincipal.php';
$u = new Principal;
$u->conectar();
   
$visualizar = $u->visualizar();

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

    <h1 class="sonho">Encontre o imóvel dos seus sonhos</h1>

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
        <div class="house-list">
            <?php 
            for($i=0;$i<count($visualizar);$i++){
                $imagem = $u->imagem($visualizar[$i]['codigo']);
            ?>
            <div class="house">
                <?php echo '<img src="https://ricardosouzacorretor.com.br/admin/upload/' .$imagem['img'] . '"
                    alt="Pré-visualização da imagem">';?>
                <div class="house-details">
                    <h3 class="casa-descricao"><?php echo $visualizar[$i]['titulo']?></h3>
                    <p class="texto-descricao"><?php echo $visualizar[$i]['cidade']?></p>
                    <p class="descricao-casa"><i
                            class="fas fa-ruler-combined favicon"></i><?php echo $visualizar[$i]['total_area']?>m²</p>
                    <p class="descricao-casa"><i
                            class="fas fa-bed favicon"></i><?php echo $visualizar[$i]['dormitorios']?> dormitórios</p>
                    <p class="descricao-casa"><i
                            class="fas fa-restroom favicon"></i><?php echo $visualizar[$i]['banheiros']?> banheiros</p>
                    <p class="descricao-casa"><i
                            class="fas fa-warehouse favicon"></i><?php echo $visualizar[$i]['vagas']?> vagas de garagem
                    </p>
                    <p class="border-descrica-casa"></p>
                    <a href=<?php echo "'imovel.php?codigo=".$visualizar[$i]['codigo']."'"?>><button
                            class="house-button">Saber Mais</button></a>
                </div>
            </div>
            <?php
                }
            
            ?>
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
                <img src="imagens/Icones/lupa.png" width=40px height=40px>
                <p>Venda</p>
                <p>Locação</p>
                <p>Terrenos</p>
            </div>
        </div>
    </section>
    <!--main-->

    <footer>
        <p>&copy; 2023. Todos os direitos reservados.</p>
    </footer>

</body>
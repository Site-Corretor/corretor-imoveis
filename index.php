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
    <div class="linha-horinzontal"></div>
    <div class=" slider-container">
        <!--div que pegar os elementos que vao dentro-->
        <div class="slider">
            <!--div para cada elemento.-->
            <div>
                <img src="imagens/fotocapa.jpg" alt="casa 1">
            </div>
        </div>
    </div>
    <section class="main">
        <div class="center">
            <div class="main-chamada">
                <h2>Referência em imóveis de alto padrão, <br /> galpões e áreas industriais</h2>
                <p>Atuamos com vendas e locações de imóveis em toda região da Grande São Paulo e Litoral</p>

            </div>
            <!--main-chamada-->
        </div>
        <!--center-->

        <div class="atuacoes">

            <div class="atuacao">
                <a href="filtroResidencias.php" class="botao-filtro">
                    <i class="icon-atuacao"><img src="imagens/Icones/residencia_icon.png" width=60px height=60px></i>
                    <h2>Residencial</h2>
                    <p>Diversas opções de casas e apartamentos</p>
                </a>
            </div>

            <div class="atuacao">
                <a href="filtroComercios.php" class="botao-filtro">
                    <i class="icon-atuacao"><img src="imagens/Icones/comercio_icon.png" width=60px height=60px></i>
                    <h2>Comercial</h2>
                    <p>Encontre o espaço ideal para o seu negócio</p>
                </a>
            </div>
            <div class="atuacao">
                <a href="filtroIndustrias.php" class="botao-filtro">
                    <i class="icon-atuacao"><img src="imagens/Icones/industria_icon.png" width=60px height=60px></i>
                    <h2>Industrial</h2>
                    <p>Galpões que atendem a necessidade da sua empresa</p>
                </a>
            </div>
            <div class="atuacao">
                <a href="filtroTerrenos.php" class="botao-filtro">
                    <i class="icon-atuacao"><img src="imagens/Icones/terreno_icon.png" width=60px height=60px></i>
                    <h2>Terrenos</h2>
                    <p>Diversas opções lotes residenciais e áreas industriais</p>
                </a>
            </div>
        </div>
        <!--atuacoes-->

        <div class="main-chamada">
            <a href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank"><button>Entrar em
                    contato</button></a>
        </div>

        <h1 class="destaque">Destaques</h1>

        <div class="house-list">
            <?php 
            for($i=0;$i<count($visualizar);$i++){
                if($visualizar[$i]['destaque']=='sim'){
                $imagem = $u->imagem($visualizar[$i]['codigo']);
            ?>
            <div class="house">
                <?php echo '<img src="https://ricardosouzacorretor.com.br/admin/upload/' .$imagem['img'] . '"
                    alt="Pré-visualização da imagem">';?>
                <div class="house-details">
                    <h3 class="casa-descricao"><?php echo $visualizar[$i]['titulo']?></h3>
                    <p class="texto-descricao"><?php echo $visualizar[$i]['cidade']?></p>
                    <p class="descricao-casa"><i
                            class="fas fa-ruler-combined favicon"></i><?php echo $visualizar[$i]['total_area']?></p>
                    <p class="descricao-casa"><i
                            class="fas fa-bed favicon"></i><?php echo $visualizar[$i]['dormitorios']?>
                    </p>
                    <p class="descricao-casa"><i
                            class="fas fa-restroom favicon"></i><?php echo $visualizar[$i]['banheiros']?></p>
                    <p class="descricao-casa"><i
                            class="fas fa-warehouse favicon"></i><?php echo $visualizar[$i]['vagas']?>
                    </p>
                    <p class="border-descrica-casa"></p>
                    <a href=<?php echo "'imovel.php?codigo=".$visualizar[$i]['codigo']."'"?>><button
                            class="house-button">Saber Mais</button></a>
                </div>
            </div>
            <?php
            }
            }
        ?>
            <a href="geral.php"><button class="house-button">Veja Mais</button></a>
        </div>
        <img class="sombrasepara" src="imagens/sombra.png" width="800" height="11">

        <!-- <div class="sobre">
            <img class="foto"
                src="https://patriciaamaralcorretora.com.br/wp-content/uploads/2023/08/Patricia-Amaral.jpg"
                alt="Pessoa">
            <div class="descricao">
                <h3>Ricardo Souza - CRECI: 218535</h3>
                <p>Carlos Fontana é conhecido por dar palestra que abalam a estrutura do marketing
                    tradicional.Prepara-se para sair
                    do evento com uma nova visão do que é posivel ser feito para o seu negócio decolar.
                </p>
                <p>
                    Formado em Marketing pela Universidade de XYZ e fundador da MarkUp, a empresa vencedora dos
                    úiltimos
                    5 prêmios MarketingBr.
                </p>
            </div>
        </div> -->
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

</html>
<script src="script.js"></script>
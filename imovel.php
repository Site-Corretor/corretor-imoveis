<?php
require_once 'clsPrincipal.php';
$u = new Principal;
$u->conectar();

$visualizar = $u->visualizar();

$codigo = $_GET['codigo'];
$imovel = $u->imovel($codigo);
$imagem = $u->imagem($codigo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="short cut icon" type="image/x-icon" href="imagens/logo-ricardo.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descrição da casa</title>
    <style>
        .img-g-casa img {

            width: 100%;
            height: auto;
            max-width: 600px;
            margin: 0 auto;

        }

        /* Responsivo para telas médias e pequenas */
        @media only screen and (max-width: 768px) {
            .main-casa {
                text-align: center;
            }

            .casa {
                /* Centralize o texto */
                text-align: center;
                padding-left: calc((100% - 600px) / 2);
            }

            .img-g-casa img {
                display: none;
            }


            .galeria img {
                width: 100%;
                height: auto;
            }

            .descricao-casa-separada h2 {
                font-size: 24px;
            }

            .descricao-casa-separada h3,
            .descricao-casa-separada p {
                font-size: 16px;
            }

            .descricao-texto-casa-separada {
                font-size: 14px;
            }

            .voltar-button {
                padding: 8px 40px;
            }

            .conteudo-centralizado {
                text-align: center;
            }

            .main-casa .casa h1 {
                text-align: center;
                margin-bottom: 20px;
            }

            /* 
            .img-g-casa img {
                width: 100%;
                max-width: 600px;
                height: auto;
                margin: 0 auto;
            } */

            .galeria a {
                width: 50%;
                box-sizing: border-box;
            }

            .galeria.descricao-casa-separada {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .galeria img {
                width: 100%;
                height: auto;
            }

            .modal .modal-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .modal .prev,
            .modal .next {
                font-size: 24px;
                color: white;
                background-color: rgba(0, 0, 0, 0.5);
                cursor: pointer;
                top: 25%;
                transform: translateY(-50%);
                z-index: 1;
            }

            .modal .prev {
                left: 10px;
                /* Ajustamos a posição para o lado esquerdo */
            }

            .modal .next {
                right: 10px;
                /* Ajustamos a posição para o lado direito */
            }

        }
    </style>
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
    <div class="container conteudo-centralizado">
        <section class="main-casa">
            <div class="casa">
                <h1>
                    <?php echo $imovel['titulo'] ?>
                </h1>
            </div>
            <div class="img-g-casa">
                <?php echo '<img src="https://ricardosouzaimoveis.com.br/admin/upload/' . $imagem['img'] . '"
        alt="Pré-visualização da imagem" >'; ?>
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
                    <p>WhatsApp</p>
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
        <div class="galeria-container">
            <div class="galeria descricao-casa-separada">

                <?php
                $images = [];
                $imagensGerais = $u->tdsImagem($codigo);

                if ($imagensGerais) {
                    foreach ($imagensGerais as $imagemGeral) {
                        $images[] = 'https://ricardosouzaimoveis.com.br/admin/upload/' . $imagemGeral['img'];

                ?>
                        <a href="https://ricardosouzaimoveis.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>" onclick="openModal('https://ricardosouzaimoveis.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>'); return false;">
                            <img src="https://ricardosouzaimoveis.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>" alt="Pré-visualização da imagem" class="thumbnail">
                        </a>
                <?php
                    }
                }
                ?>
            </div>
        </div>


        <div id="myModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <span class="prev" onclick="changeImage(-1)">&#10094;</span>
            <span class="next" onclick="changeImage(1)">&#10095;</span>
            <img id="modalImage" class="modal-content">
        </div>


        <div class="descricao-casa-separada">
            <h3>DESCRIÇÃO DO IMÓVEL</h3><wbr>
            <h3 class="descricao-texto-casa-separada"><?php echo $imovel['titulo'] ?>
            </h3>
            <!--<p class="descricao-texto-casa-separada"><?php echo $imovel['total_area'] ?>m²</p>-->
            <p class="descricao-texto-casa-separada"><?php echo $imovel['descricao1'] ?></p>
            <p class="descricao-texto-casa-separada"><?php echo $imovel['descricao2'] ?></p>
            <p class="descricao-texto-casa-separada"><?php echo $imovel['descricao3'] ?></p>
            <p class="descricao-texto-casa-separada"><?php echo $imovel['cidade'] ?></p>
            <!--<p class="descricao-texto-casa-separada">
                <?php echo $imovel['dormitorios'] ?>
                dormitórios |
                <?php echo $imovel['banheiros'] ?>
                banheiros |
                <?php echo $imovel['vagas'] ?>
                vagas de garagem
            </p>-->
            <p class="descricao-texto-casa-separada"><b><?php echo $imovel['preco'] ?></b></p>
        </div>



        <div class="descricao-casa-separada">
            <h3>CENTRAL DE NEGÓCIOS</h3><wbr>
            <p class="descricao-texto-casa-separada">
                Para ter mais informações sobre este imóvel ligue:
            </p>
            <p class="descricao-texto-casa-separada">
                Ricardo Souza: (11) 97035-5935 <a href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank">
                    <img src="imagens/Icones/whatsapp.png" width=13px height=13px>
                </a>
            </p>
            <p class="descricao-texto-casa-separada">
                Victor Martins: (11) 95423-3209 <a href="https://api.whatsapp.com/send?phone=5511954233209" target="_blank">
                    <img src="imagens/Icones/whatsapp.png" width=13px height=13px>
                </a>
            </p>
            <p class="descricao-texto-casa-separada">
                Email: ricardosouzanegocios@gmail.com
            </p>
            <p class="descricao-texto-casa-separada">
                Arujá - São Paulo
            </p>

        </div>
        <div class="centralizar-conteudo">
            <a href="index.php"><button class="voltar-button">Início</button></a>
            <a href="geral.php"><button class="voltar-button">Voltar</button></a>
        </div>

    </div>
    <footer>
        <p>&copy; 2023. Todos os direitos reservados.</p>
    </footer>
</body>

<script>
    var images = <?php echo json_encode($images); ?>;
    var currentImageIndex = 0;

    function openModal(imageUrl) {
        var modal = document.getElementById("myModal");
        var modalImage = document.getElementById("modalImage");
        currentImageIndex = images.indexOf(imageUrl);
        modal.style.display = "block";
        modalImage.src = imageUrl;
    }

    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    function changeImage(n) {
        currentImageIndex += n;

        // Verifica se atingiu o limite inferior
        if (currentImageIndex < 0) {
            currentImageIndex = images.length - 1;
        }
        // Verifica se atingiu o limite superior
        else if (currentImageIndex >= images.length) {
            currentImageIndex = 0;
        }

        var modalImage = document.getElementById("modalImage");
        modalImage.src = images[currentImageIndex];
    }
</script>


</html>
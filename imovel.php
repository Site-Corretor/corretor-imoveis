<?php
require_once 'clsPrincipal.php';
$u = new Principal;
$u->conectar();
   
$visualizar = $u->visualizar();

$codigo = $_GET['codigo'];
$imovel = $u->imovel($codigo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descrição da casa</title>
    <style>

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
    <div class="container">
        <section class="main-casa">

            <div class="casa">
                <h1>
                    <?php echo $imovel['titulo']?>
                </h1>
            </div>
            <div class="img-g-casa">
                <img src="../../imagens/Residencias/CA001/25AA536A-5687-47F9-8B31-71FC6A96B16F.JPG" alt="" width=915px
                    height=450px>
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
        <div class="galeria-container">
            <div class="galeria">
                <a href="../../imagens/Residencias/CA001/25AA536A-5687-47F9-8B31-71FC6A96B16F.JPG"
                    onclick="openModal('../../imagens/Residencias/CA001/25AA536A-5687-47F9-8B31-71FC6A96B16F.JPG'); return false;">
                    <img src="../../imagens/Residencias/CA001/25AA536A-5687-47F9-8B31-71FC6A96B16F.JPG" alt="Imagem 1"
                        class="thumbnail">
                </a>
                <a href="../../imagens/Residencias/CA001/BDADD859-E1BB-4415-A19B-0F1760BB0FFB.JPG"
                    onclick="openModal('../../imagens/Residencias/CA001/BDADD859-E1BB-4415-A19B-0F1760BB0FFB.JPG'); return false;">
                    <img src="../../imagens/Residencias/CA001/BDADD859-E1BB-4415-A19B-0F1760BB0FFB.JPG" alt="Imagem 1"
                        class="thumbnail">
                </a>
                <a href="../../imagens/Residencias/CA001/851600BC-904C-4DB6-83A6-E71518CB9D4E.JPG"
                    onclick="openModal('../../imagens/Residencias/CA001/851600BC-904C-4DB6-83A6-E71518CB9D4E.JPG'); return false;">
                    <img src="../../imagens/Residencias/CA001/851600BC-904C-4DB6-83A6-E71518CB9D4E.JPG" alt="Imagem 1"
                        class="thumbnail">
                </a>
                <a href="../../imagens/Residencias/CA001/29F8ACFF-A169-47F0-9A76-2435E06B2109.JPG"
                    onclick="openModal('../../imagens/Residencias/CA001/29F8ACFF-A169-47F0-9A76-2435E06B2109.JPG'); return false;">
                    <img src="../../imagens/Residencias/CA001/29F8ACFF-A169-47F0-9A76-2435E06B2109.JPG" alt="Imagem 1"
                        class="thumbnail">
                </a>
                <a href="../../imagens/Residencias/CA001/353038A2-EC8F-4D85-8B8F-2724C547C097.JPG"
                    onclick="openModal('../../imagens/Residencias/CA001/353038A2-EC8F-4D85-8B8F-2724C547C097.JPG'); return false;">
                    <img src="../../imagens/Residencias/CA001/353038A2-EC8F-4D85-8B8F-2724C547C097.JPG" alt="Imagem 1"
                        class="thumbnail">
                </a>
                <a href="../../imagens/Residencias/CA001/99604075-DA29-4B09-8CEE-97C301E94D17.JPG"
                    onclick="openModal('../../imagens/Residencias/CA001/99604075-DA29-4B09-8CEE-97C301E94D17.JPG'); return false;">
                    <img src="../../imagens/Residencias/CA001/99604075-DA29-4B09-8CEE-97C301E94D17.JPG" alt="Imagem 1"
                        class="thumbnail">
                </a>
                <a href="../../imagens/Residencias/CA001/4212B51F-06C3-4B67-BCC1-918DF02F20B1.JPG"
                    onclick="openModal('../../imagens/Residencias/CA001/4212B51F-06C3-4B67-BCC1-918DF02F20B1.JPG'); return false;">
                    <img src="../../imagens/Residencias/CA001/4212B51F-06C3-4B67-BCC1-918DF02F20B1.JPG" alt="Imagem 1"
                        class="thumbnail">
                </a>
            </div>
        </div>
        <div id="myModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <span class="prev" onclick="changeImage(-1)">&#10094;</span>
            <span class="next" onclick="changeImage(1)">&#10095;</span>
            <img id="modalImage" class="modal-content">
        </div>


        <div class="descricao-casa-separada">
            <h2>DESCRIÇÃO DA CASA</h2>
            <h3 class="descricao-texto-casa-separada"><?php echo $imovel['titulo']?>
            </h3>
            <p class="descricao-texto-casa-separada"><?php echo $imovel['total_area']?>m²</p>
            <p class="descricao-texto-casa-separada"><?php echo $imovel['descricao']?></p>
            <p class="descricao-texto-casa-separada"><b>PREÇO: R$ <?php echo $imovel['preco']?></b></p>
        </div>



        <div class="descricao-casa-separada">
            <h2>CENTRAL DE NEGÓCIOS</h2>
            <p class="descricao-texto-casa-separada">
                Para ter mais informações sobre este imóvel ligue:
            </p>
            <p class="descricao-texto-casa-separada">
                Ricardo Souza: (11) 97035-5935
            </p>
            <p class="descricao-texto-casa-separada">
                Victor Martins: (11) 95423-3209
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
var currentImageIndex = 0;
var images = ["../../imagens/Residencias/CA001/25AA536A-5687-47F9-8B31-71FC6A96B16F.JPG",
    "../../imagens/Residencias/CA001/BDADD859-E1BB-4415-A19B-0F1760BB0FFB.JPG",
    "../../imagens/Residencias/CA001/851600BC-904C-4DB6-83A6-E71518CB9D4E.JPG",
    "../../imagens/Residencias/CA001/29F8ACFF-A169-47F0-9A76-2435E06B2109.JPG",
    "../../imagens/Residencias/CA001/353038A2-EC8F-4D85-8B8F-2724C547C097.JPG",
    "../../imagens/Residencias/CA001/99604075-DA29-4B09-8CEE-97C301E94D17.JPG",
    "../../imagens/Residencias/CA001/4212B51F-06C3-4B67-BCC1-918DF02F20B1.JPG"


]; // Preencha este array com os URLs das suas imagens

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
    if (currentImageIndex < 0) {
        currentImageIndex = images.length - 1;
    } else if (currentImageIndex >= images.length) {
        currentImageIndex = 0;
    }
    var modalImage = document.getElementById("modalImage");
    modalImage.src = images[currentImageIndex];
}
</script>

</html>
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
                <?php echo '<img src="https://ricardosouzacorretor.com.br/admin/upload/' .$imagem['img'] . '"
                    alt="Pré-visualização da imagem" width=915px height=450px>';?>
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
            <?php 
                for ($i = 0; $i < count($visualizar); $i++) {
                    $imagensGerais = $u->tdsImagem($visualizar[$i]['codigo']);
                        
                    if ($imagensGerais) {
                        foreach ($imagensGerais as $imagemGeral) {
            ?>
            <div class="galeria">
                <a href="https://ricardosouzacorretor.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>"
                    onclick="openModal('https://ricardosouzacorretor.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>'); return false;">
                    <img src="https://ricardosouzacorretor.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>"
                        alt="Pré-visualização da imagem" class="thumbnail">
                </a>
            </div>
            <?php
                        }
                    }
                }
            ?>


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
<!-- <script>
var currentImageIndex = 0;
var images = [
    "https://ricardosouzacorretor.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>"
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
</script> -->

<script>
var images = <?php echo json_encode($images); ?>; // Certifique-se de que $images é um array de URLs de imagens
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
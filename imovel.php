<?php
require_once 'clsPrincipal.php';
$u = new Principal;
$u->conectar();

$codigo = $_GET['codigo'];
$imovel = $u->imovel($codigo);
$imagem = $u->imagem($codigo);

$descricao = isset($imovel['descricao']) ? trim($imovel['descricao']) : '';

$cidade = isset($imovel['cidade']) ? $imovel['cidade'] : '';
$preco = isset($imovel['preco']) ? $imovel['preco'] : '';
$titulo = isset($imovel['titulo']) ? $imovel['titulo'] : '';

$dormitorios = isset($imovel['dormitorios']) ? $imovel['dormitorios'] : '';
$banheiros = isset($imovel['banheiros']) ? $imovel['banheiros'] : '';
$vagas = isset($imovel['vagas']) ? $imovel['vagas'] : '';
$total_area = isset($imovel['total_area']) ? $imovel['total_area'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="style.css?v=2" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="/css/all.min.css">

    <link rel="short cut icon" type="image/x-icon" href="imagens/logo-ricardo.ico?v=2">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do imóvel</title>
</head>

<body>
    <header>
        <div class="center">
            <div class="logo">
                <a href="index.php">
                    <img src="imagens/logo-ricardo.png?v=2" width="145" height="70" alt="Ricardo Souza Imóveis">
                </a>
            </div>

            <div class="menu">
                <a href="geral.php">Imóveis</a>
                <a href="sobre.php">Sobre Nós</a>
                <a href="contato.php">Contato</a>
                <a href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank" class="menu-cta">WhatsApp</a>
            </div>
        </div>
    </header>

    <main class="imovel-page">
        <div class="imovel-topo">
            <span class="section-label">Detalhes do imóvel</span>
            <h1><?php echo $titulo; ?></h1>
            <p class="imovel-local">
                <i class="fas fa-map-marker-alt"></i>
                <?php echo $cidade; ?>
            </p>
        </div>

        <div class="imovel-grid">
            <div class="imovel-coluna-principal">
                <div class="imovel-card">
                    <?php if ($imagem && !empty($imagem['img'])) { ?>
                        <img class="imovel-capa" src="https://ricardosouzaimoveis.com.br/admin/upload/<?php echo $imagem['img']; ?>" alt="Imagem principal do imóvel">
                        <!--<img class="imovel-capa" src="admin/upload/<?php echo $imagem['img']; ?>" alt="Imagem principal do imóvel">-->
                    <?php } else { ?>
                        <div class="imovel-capa-vazia">Imagem principal não disponível no momento</div>
                    <?php } ?>
                </div>

                <div class="imovel-card galeria-card">
                    <h3 class="galeria-titulo">Galeria de fotos</h3>
                    <div class="galeria-imagens">
                        <?php
                        $images = [];
                        $imagensGerais = $u->tdsImagem($codigo);

                        if ($imagensGerais) {
                            foreach ($imagensGerais as $imagemGeral) {
                                $images[] = 'https://ricardosouzaimoveis.com.br/admin/upload/' . $imagemGeral['img'];
                                //$images[] = 'admin/upload/' . $imagemGeral['img'];
                        ?>
                                <a href="https://ricardosouzaimoveis.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>" onclick="openModal('https://ricardosouzaimoveis.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>'); return false;">
                                    <img src="https://ricardosouzaimoveis.com.br/admin/upload/<?php echo $imagemGeral['img']; ?>" alt="Pré-visualização da imagem" class="thumbnail">
                                </a>
                                <!--<a href="admin/upload/<?php echo $imagemGeral['img']; ?>" onclick="openModal('admin/upload/<?php echo $imagemGeral['img']; ?>'); return false;">
                                    <img src="admin/upload/<?php echo $imagemGeral['img']; ?>" alt="Pré-visualização da imagem" class="thumbnail">
                                </a>-->
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="imovel-card">
                    <div class="box-conteudo">
                        <p class="descricao-titulo">Descrição do imóvel</p>

                        <div class="imovel-info-grid">
                            <?php if ($dormitorios !== '' && $dormitorios !== null) { ?>
                                <div class="imovel-info-item">
                                    <i class="fas fa-bed"></i>
                                    <span><?php echo $dormitorios; ?> dormitório(s)</span>
                                </div>
                            <?php } ?>

                            <?php if ($banheiros !== '' && $banheiros !== null) { ?>
                                <div class="imovel-info-item">
                                    <i class="fas fa-bath"></i>
                                    <span><?php echo $banheiros; ?> banheiro(s)</span>
                                </div>
                            <?php } ?>

                            <?php if ($vagas !== '' && $vagas !== null) { ?>
                                <div class="imovel-info-item">
                                    <i class="fas fa-car"></i>
                                    <span><?php echo $vagas; ?> vaga(s)</span>
                                </div>
                            <?php } ?>

                            <?php if ($total_area !== '' && $total_area !== null) { ?>
                                <div class="imovel-info-item">
                                    <i class="fas fa-ruler-combined"></i>
                                    <span><?php echo $total_area; ?> m²</span>
                                </div>
                            <?php } ?>

                        </div>

                        <?php if ($descricao !== '') { ?>
                            <p class="descricao-texto-casa-separada"><?php echo $descricao; ?></p>
                        <?php } else { ?>
                            <p class="descricao-texto-casa-separada">Descrição não informada no momento.</p>
                        <?php } ?>

                        <p class="preco-destaque"><?php echo 'R$ ' . number_format((float)$preco, 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>

            <div class="imovel-coluna-lateral">
                <div class="imovel-card box-negocios">
                    <div class="box-conteudo">
                        <p class="descricao-titulo">Central de negócios</p>
                        <h3 class="box-titulo">Fale com nossa equipe</h3>

                        <p class="descricao-texto-casa-separada">
                            Para ter mais informações sobre este imóvel, entre em contato:
                        </p>

                        <p class="descricao-texto-casa-separada">
                            <strong>Ricardo Souza:</strong> (11) 97035-5935
                            <a class="whatsapp-inline" href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank">
                                <img src="imagens/Icones/whatsapp.png" width="14" height="14" alt="WhatsApp">
                            </a>
                        </p>

                        <p class="descricao-texto-casa-separada">
                            <strong>Victor Martins:</strong> (11) 95423-3209
                            <a class="whatsapp-inline" href="https://api.whatsapp.com/send?phone=5511954233209" target="_blank">
                                <img src="imagens/Icones/whatsapp.png" width="14" height="14" alt="WhatsApp">
                            </a>
                        </p>

                        <p class="descricao-texto-casa-separada">
                            <strong>E-mail:</strong> ricardosouzanegocios@gmail.com
                        </p>

                        <p class="descricao-texto-casa-separada">
                            <strong>Localização:</strong> Arujá - São Paulo
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <span class="prev" onclick="changeImage(-1)">&#10094;</span>
            <span class="next" onclick="changeImage(1)">&#10095;</span>
            <img id="modalImage" class="modal-content" alt="Imagem ampliada">
        </div>

        <div class="imovel-acoes">
            <a href="index.php"><button class="voltar-button">Início</button></a>
            <a href="geral.php"><button class="voltar-button">Voltar</button></a>
        </div>
    </main>

    <footer class="footer-site">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <img src="imagens/logo-ricardo.png?v=2" width="160" alt="Ricardo Souza Imóveis">

                    <p class="footer-creci">CRECI 218535</p>

                    <div class="footer-contact-list">
                        <p>
                            <i class="fas fa-map-marker-alt"></i>
                            Av. Gov. Mário Covas Júnior, 2665 (Sala 1), Bairro do Portão - Arujá/SP - CEP: 07412-000
                        </p>

                        <p>
                            <a href="https://www.instagram.com/ricardonsouzaimoveis" target="_blank">
                            <i class="fab fa-instagram"></i>
                            ricardonsouzaimoveis</a>
                        </p>

                        <p>
                            <i class="fas fa-phone-alt"></i>
                            <a href="tel:11970355935">(11) 97035-5935</a> / 
                            <a href="tel:11954233209">(11) 95423-3209</a>
                        </p>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Empresa</h4>
                    <div class="footer-links">
                        <a href="sobre.php">Sobre Nós</a>
                        <a href="contato.php">Fale Conosco</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Imóveis</h4>
                    <div class="footer-links">
                        <a href="geral.php?tipo=residencia">Residencial</a>
                        <a href="geral.php?tipo=comercio">Comercial</a>
                        <a href="geral.php?tipo=industria">Industrial</a>
                        <a href="geral.php?tipo=terreno">Terrenos</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Serviços</h4>
                    <div class="footer-links">
                        <p>Venda</p>
                        <p>Locação</p>
                        <p>Administração</p>
                        <p>Suporte</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Ricardo Souza Imóveis. Todos os direitos reservados.</p>
                <p>Desenvolvido por Trimod Tech Solutions.</p>
            </div>
        </div>
    </footer>

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

            if (currentImageIndex < 0) {
                currentImageIndex = images.length - 1;
            } else if (currentImageIndex >= images.length) {
                currentImageIndex = 0;
            }

            var modalImage = document.getElementById("modalImage");
            modalImage.src = images[currentImageIndex];
        }
    </script>
</body>

</html>
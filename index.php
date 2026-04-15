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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link href="style.css?v=4" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="./css/all.min.css">

    <link rel="short cut icon" type="image/x-icon" href="imagens/logo-ricardo.ico?v=2">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricardo Souza - Corretor de Imóveis</title>
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

    <div class="slider-container">
        <div class="slider">
            <div class="slide-item">
                <img src="imagens/fotocapa.jpg" alt="Imagem principal do site">
                <div class="slide-overlay">
                    <div class="slide-content">
                        <span class="slide-badge">Atendimento especializado</span>
                        <h1>Referência em imóveis de alto padrão, galpões e áreas industriais</h1>
                        <p>Atuamos com vendas e locações de imóveis em toda a região da Grande São Paulo e Litoral, com atendimento próximo, estratégico e profissional.</p>
                        <div class="hero-buttons">
                            <a href="geral.php" class="hero-btn hero-btn-outline">Ver imóveis</a>
                            <a href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank" class="hero-btn">Entrar em contato</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="main">
        <div class="center">
            <div class="main-chamada">
                <span class="section-label">Especialidades</span>
                <h2>Encontre o imóvel ideal para morar, investir ou expandir seu negócio</h2>
                <p>Uma seleção completa de oportunidades residenciais, comerciais, industriais e terrenos em localizações estratégicas.</p>
            </div>
        </div>

        <div class="atuacoes">
            <div class="atuacao" onclick="window.location='geral.php?tipo=residencia'" style="cursor: pointer;">
                <a href="geral.php?tipo=residencia" class="botao-filtro">
                    <i class="icon-atuacao">
                        <img src="imagens/Icones/residencia_icon.png" width="60" height="60" alt="Residencial">
                    </i>
                    <h2>Residencial</h2>
                    <p>Diversas opções de casas e apartamentos para diferentes estilos de vida.</p>
                </a>
            </div>

            <div class="atuacao" onclick="window.location='geral.php?tipo=comercio'" style="cursor: pointer;">
                <a href="geral.php?tipo=comercio" class="botao-filtro">
                    <i class="icon-atuacao">
                        <img src="imagens/Icones/comercio_icon.png" width="60" height="60" alt="Comercial">
                    </i>
                    <h2>Comercial</h2>
                    <p>Encontre o espaço ideal para instalar, ampliar ou reposicionar seu negócio.</p>
                </a>
            </div>

            <div class="atuacao" onclick="window.location='geral.php?tipo=industria'" style="cursor: pointer;">
                <a href="geral.php?tipo=industria" class="botao-filtro">
                    <i class="icon-atuacao">
                        <img src="imagens/Icones/industria_icon.png" width="60" height="60" alt="Industrial">
                    </i>
                    <h2>Industrial</h2>
                    <p>Galpões e áreas que atendem às necessidades operacionais da sua empresa.</p>
                </a>
            </div>

            <div class="atuacao" onclick="window.location='geral.php?tipo=terreno'" style="cursor: pointer;">
                <a href="geral.php?tipo=terreno" class="botao-filtro">
                    <i class="icon-atuacao">
                        <img src="imagens/Icones/terreno_icon.png" width="60" height="60" alt="Terrenos">
                    </i>
                    <h2>Terrenos</h2>
                    <p>Diversas opções de lotes residenciais e áreas industriais para investimento.</p>
                </a>
            </div>
        </div>

        <div class="titulo-secao">
            <span class="section-label">Imóveis em destaque</span>
            <h1 class="destaque">Oportunidades selecionadas</h1>
            <p>Confira alguns dos imóveis em evidência no momento.</p>
        </div>

        <div class="house-list">
            <?php
            if ($visualizar && count($visualizar) > 0) {
                for ($i = 0; $i < count($visualizar); $i++) {
                    if ($visualizar[$i]['destaque'] == 'sim') {
                        $imagem = $u->imagem($visualizar[$i]['codigo']);
                        if ($visualizar[$i]['ativo'] == 1) {
            ?>
                            <div class="house" onclick="window.location='<?php echo 'imovel.php?codigo=' . $visualizar[$i]['codigo']; ?>'" style="cursor: pointer;">
                                <?php
                                if ($imagem && !empty($imagem['img'])) {
                                    echo '<img src="https://ricardosouzaimoveis.com.br/admin/upload/' . $imagem['img'] . '" alt="Pré-visualização do imóvel">';
                                    //echo '<img src="admin/upload/' . $imagem['img'] . '" alt="Pré-visualização do imóvel">';
                                } else {
                                    echo '<img src="imagens/fotocapa.jpg" alt="Imagem padrão do imóvel">';
                                }
                                ?>

                                <div class="house-details">
                                    <div class="house-info-topo">
                                        <span class="house-tag">Destaque</span>
                                    </div>

                                    <h3 class="casa-descricao"><?php echo $visualizar[$i]['titulo']; ?></h3>
                                    <p class="texto-descricao">
                                        <i class="fas fa-map-marker-alt favicon"></i>
                                        <?php echo $visualizar[$i]['cidade']; ?>
                                    </p>

                                    <p class="preco-imovel"><?php echo 'R$ ' . number_format((float)$visualizar[$i]['preco'], 2, ',', '.'); ?></p>
                                    <p class="border-descrica-casa"></p>

                                    <a href="<?php echo 'imovel.php?codigo=' . $visualizar[$i]['codigo']; ?>">
                                        <button class="house-button">Saber mais</button>
                                    </a>
                                </div>
                            </div>
            <?php
                        }
                    }
                }
            }
            ?>
        </div>

        <div class="button-container">
            <a href="geral.php">
                <button class="house-button-2">Ver todos os imóveis</button>
            </a>
        </div>

        <img class="sombrasepara" src="imagens/sombra.png" alt="Separador">
    </section>

    <footer class="footer-site">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-brand">

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
</body>

</html>
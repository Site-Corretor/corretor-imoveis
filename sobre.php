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

    <link rel="short cut icon" type="image/x-icon" href="imagens/logo-ricardo.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós</title>
</head>

<body>
    <header>
        <div class="center">
            <div class="logo">
                <a href="index.php"><img src="imagens/logo-ricardo.png" width="145" height="70" alt="Ricardo Souza Imóveis"></a>
            </div>

            <div class="menu">
                <a href="geral.php">Imóveis</a>
                <a href="sobre.php">Sobre Nós</a>
                <a href="contato.php">Contato</a>
                <a href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank" class="menu-cta">WhatsApp</a>
            </div>
        </div>
    </header>

    <main class="sobre-page">
        <div class="sobre-topo">
            <span class="section-label">Sobre nós</span>
            <h1>Confiança, experiência e atendimento próximo</h1>
            <p>Trabalhamos com foco em oferecer soluções imobiliárias com clareza, segurança e atenção aos detalhes, ajudando nossos clientes a encontrar oportunidades alinhadas aos seus objetivos.</p>
        </div>

        <div class="sobre-grid">
            <div class="sobre-card">
                <h2>Quem somos</h2>
                <h3>Atendimento imobiliário com visão estratégica</h3>

                <p>A Ricardo Souza Imóveis atua com imóveis residenciais, comerciais, industriais e terrenos, oferecendo suporte completo para compra, venda e locação.</p>

                <p>Nosso objetivo é proporcionar um atendimento próximo, transparente e eficiente, entendendo a necessidade de cada cliente e apresentando opções que realmente façam sentido.</p>

                <p>Mais do que intermediar negociações, buscamos construir relações de confiança, com acompanhamento responsável em cada etapa do processo.</p>
            </div>

            <div class="sobre-card">
                <h2>Diferenciais</h2>
                <h3>O que valorizamos no atendimento</h3>

                <div class="sobre-destaques">
                    <div class="sobre-mini-box">
                        <h4>Atendimento personalizado</h4>
                        <p>Cada cliente recebe orientação conforme seu perfil, objetivo e momento de compra, venda ou locação.</p>
                    </div>

                    <div class="sobre-mini-box">
                        <h4>Imóveis selecionados</h4>
                        <p>Trabalhamos com oportunidades residenciais, comerciais, industriais e terrenos em localizações estratégicas.</p>
                    </div>

                    <div class="sobre-mini-box">
                        <h4>Transparência em todo o processo</h4>
                        <p>Nosso compromisso é oferecer clareza nas informações e segurança durante toda a negociação.</p>
                    </div>
                </div>
            </div>
        </div>

        <section class="sobre-galeria">
            <div class="sobre-galeria-topo">
                <span class="section-label">Nosso espaço</span>
                <h2>Conheça um pouco do nosso ambiente</h2>
                <p>Uma visão do espaço onde recebemos clientes e conduzimos nosso atendimento com atenção e profissionalismo.</p>
            </div>

            <div class="sobre-galeria-grid">
                <div class="sobre-galeria-item">
                    <img src="imagens/escritorio-1.jpg" alt="Escritório - imagem 1">
                </div>
                <div class="sobre-galeria-item">
                    <img src="imagens/escritorio-2.jpg" alt="Escritório - imagem 2">
                </div>
                <div class="sobre-galeria-item">
                    <img src="imagens/escritorio-3.jpg" alt="Escritório - imagem 3">
                </div>
                <div class="sobre-galeria-item">
                    <img src="imagens/escritorio-4.jpg" alt="Escritório - imagem 4">
                </div>
            </div>
        </section>
    </main>

    <footer class="footer-site">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <img src="imagens/logo-ricardo.png" width="160" alt="Ricardo Souza Imóveis">

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
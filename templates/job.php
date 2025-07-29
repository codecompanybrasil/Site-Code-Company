<?php
    //$jobId = 35942729;
    $utils = new UtilsFunctions();
    $jobId = $utils->urlSearchParam($_SERVER["REQUEST_URI"]);
    if (!$jobId) {
        render("404.html");
        die();
    }
    $home = new Home(1);
    $result = $home->get("https://www.freelancer.com/api/projects/0.1/projects/".$jobId."?full_description=true&job_details=true&attachment_details=true");
    if ($result["status"] == "error") {
        render("404.html");
        die();
    }

    $userId = $result["result"]["owner_id"];
    $user = $home->get("https://www.freelancer.com/api/users/0.1/users/?users[]=".$userId."&country_details=true&reputation=true&status=true");

    if ($user["status"] == "error") {
        render("404.html");
        die();
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabalho - Equipe de Freelance</title>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/simple-header.css">
    <link rel="stylesheet" href="/css/job.css">
</head>
<body>
<header>
        <div class="logo">
            <a href="/">
                <img src="/images/logo_marca_branca.png" alt="Logo Code Company" class="logo">
                <h2>Freelance</h2>
                <span class="beta">Beta</span>
            </a>
        </div>
        <nav class="desktop-nav">
            <a href="/search" class="decoration-hover">Jobs</a>
            <a href="/freelance" target="_blank" class="decoration-hover">Freelance</a>
            <a href="/inbox" class="decoration-hover" target="_blank">Inbox</a>
            <!-- <a href="https://discord.com/api/oauth2/authorize?client_id=1066492672182853642&redirect_uri=http%3A%2F%2F127.0.0.1%3A3000%2Fauth%2F&response_type=token&scope=identify">
                <button class="login-discord neon">
                    <img src="images/discord-icon.png" alt="Discord Icon">
                    Login
                </button>
            </a> -->
            <!-- <a href="#">
                <img src="https://cdn.discordapp.com/avatars/810894152795553863/d8d98dd9b79ee5ef1a41614f8df4d2eb.png?size=1024" alt="Avatar do discord" id="avatar">
            </a> -->
        </nav>
        <nav class="android-nav">
            <img src="../images/menu.png" alt="Mais opções" id="android-menu">
            <div class="menu-android">
                <a href="/search" class="decoration-hover">Jobs</a>
                <a href="/freelance" target="_blank" class="decoration-hover">Freelance</a>
                <a href="/inbox" class="decoration-hover" target="_blank">Inbox</a>
                <!-- <a href="#">
                    <button class="login-discord neon">
                        <img src="images/discord-icon.png" alt="Discord Icon">
                        Login
                    </button>
                </a> -->
                <!-- <a href="#" class="decoration-hover">Minha Conta</a> -->
            </div>
        </nav>
    </header>
    <div class="job-header">
        <div class="faixa-header">
            <h1>
                <?php echo $result["result"]["title"]; ?>
                <img src="https:<?php echo $user["result"]["users"][$userId]["location"]["country"]["flag_url_cdn"]; ?>" alt="Imagem de bandeira do cliente">
            </h1>
            <img src="/images/salvar.png" id="salvar" alt="Icone para salvar o trabalho">
        </div>
        <div class="faixa-header">
            <p class="job-status-phone">
                <?php echo $result["result"]["frontend_project_status"]; ?>
            </p>
        </div>
        <div class="faixa-header">
            <nav>
                <a href="#" class="faixa-header-selected">
                    Detalhes
                </a>
                <a href="#" id="propostas">
                    Propostas
                </a>
            </nav>
            <p class="job-status"> <!--Awaiting Acceptance-->
                <?php echo $result["result"]["frontend_project_status"]; ?>
            </p>
        </div>
    </div>
    <main>
        <div class="job-content">
            <div class="job-details" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                <div class="job-details-section">
                    <h3>Detalhes do projeto</h3><!--$10.00 – 30.00 CAD-->
                    <h3>
                        <?php echo "$".$result["result"]["budget"]["minimum"].".00 - ".$result["result"]["budget"]["maximum"].".00 ".$result["result"]["currency"]["code"]; ?>
                    </h3>
                </div>
                <div class="job-details-content">
                    <p>
                        <?php echo str_replace("\n", "<br>", $result["result"]["description"]);?>
                    </p>
                    <br>
                    <h3>Habilidades Requisitadas</h3>
                    <div class="skills-select">
                        <?php
                            for ($i=0;$i<sizeof($result["result"]["jobs"]);$i++) {
                                $hab = $result["result"]["jobs"][$i];
                        ?>
                        <div class="skill">
                            <?php echo $hab["name"]; ?>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <br>
                    <h3>Link Freelancer.com</h3>
                    <a href="https://www.freelancer.com/projects/<?php echo $result["result"]["seo_url"];?>" class="link-job" target="_blank">https://www.freelancer.com/projects/<?php echo $result["result"]["seo_url"];?></a>
                    <?php
                        if ($result["result"]["attachments"]) {
                    ?>
                    <br>
                    <h3>Arquivos</h3>
                    <?php
                        for ($c=0;$c<sizeof($result["result"]["attachments"]);$c++) {
                    ?>
                    <a href="https://<?php echo $result["result"]["attachments"][$c]["url"]; ?>" target="_blank" class="arquivos"><?php echo $result["result"]["attachments"][$c]["filename"]; ?></a>
                    <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="job-bid">
                <div id="error-message">
                </div>
                <?php 
                    if ($result["result"]["status"] == "closed") {
                ?>
                    <div class="center">
                        <h2 class="big-padding">Projeto fechado para propostas</h2>
                    </div>
                <?php
                    } else {
                ?>
                    <div class="job-details" style="padding: 0;">
                        <div class="job-details-section">
                            <h3>Faça uma proposta!</h3>
                        </div>
                        <p>Você poderá editar sua oferta até que o projeto seja concedido a alguém.</p>
                    </div>
                    <form action="/api/bid" method="post">
                        <div class="center-proposals">
                            <div class="proposal">
                                <h3>Valor do Lance</h3>
                                <input type="number" name="bidAmount" id="bidAmount">
                                <span><?php echo $result["result"]["currency"]["code"]; ?></span>
                            </div>
                            <div class="proposal">
                                <h3>O projeto será entregue em</h3>
                                <input type="number" name="prazo" id="prazo">
                                <span>Days</span>
                            </div>
                        </div>
                        <p>Pagamento = $(Seu preço) - %15 de taxa</p>
                        <div class="center-proposal">
                            <div class="proposal">
                                <h3>Descreva sua proposta</h3>
                                <textarea name="proposta" id="proposta" placeholder="O que te faz o melhor candidato para esse projeto?" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <br>
                        <h3>Sugira um pagamento por tópicos</h3>
                        <p>Escreva um tópico explicando como irá fazer a tarefa</p> <!--<p>Escreva tópicos, ou apenas um tópico</p>-->
                        <div class="milestones">
                            <input type="text" name="tarefa" id="tarefa" placeholder="Tarefa">
                            <!-- <div class="price-milestone">
                                <span>$</span>
                                <input type="number" name="priceMilestone" id="priceMilestone">
                            </div> -->
                        </div>
                        <div class="submit-area">
                            <button id="submit">
                                <input type="submit" id="submit" value="Fazer proposta">
                            </button>
                        </div>
                    </form>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="about-client">
            <div class="job-details-section">
                <h3>Sobre o cliente</h3>
            </div>
            <div class="client-details">
                <div class="client-phrase">
                    <img src="/images/locations.png" alt="Icone para cidade">
                    <span>
                        <?php echo $user["result"]["users"][$userId]["location"]["city"];?>
                    </span>
                </div>
                <div class="client-phrase">
                    <img src="https:<?php echo $user["result"]["users"][$userId]["location"]["country"]["flag_url_cdn"]; ?>" alt="Flag do país do cliente" class="flag-emoji">
                    <span>
                        <?php echo $user["result"]["users"][$userId]["location"]["country"]["name"];?>
                    </span>
                </div>
                <!-- <div class="client-phrase">
                    <img src="/images/clock.png" alt="Icon de Relógio">
                    <span>Member since Oct 14, 2015</span>
                </div> -->
                <div class="client-phrase stars">
                    <?php
                        $stars = (int) ($user["result"]["users"][$userId]["reputation"]["entire_history"]["overall"]);
                        for ($i=0;$i<$stars;$i++) {
                    ?>
                        <img src="/images/star-filled.png" alt="Icon de estrela">
                    <?php
                        }
                        for ($i=0;$i<5-$stars;$i++) {
                    ?>
                        <img src="/images/star.png" alt="Icon de estrela">
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="client-phrase">
                <h3>Verificações do Cliente</h3>
            </div>
            <div class="client-details">
                <div class="client-phrase">
                    <img src="/images/<?php echo ( $user["result"]["users"][$userId]["status"]["identity_verified"] ? "correct.png" : "close.png"); ?>" alt="Icon que mostra o perfil do cliente">
                    <span>Identidade verificada</span>
                </div>
                <div class="client-phrase">
                    <img src="/images/<?php echo ( $user["result"]["users"][$userId]["status"]["payment_verified"] ? "correct.png" : "close.png"); ?>" alt="Icon que mostra o perfil do cliente">
                    <span>Pagamento verificado</span>
                </div>
                <div class="client-phrase">
                    <img src="/images/<?php echo ( $user["result"]["users"][$userId]["status"]["deposit_made"] ? "correct.png" : "close.png"); ?>" alt="Icon que mostra o perfil do cliente">
                    <span>Depósito verificado</span>
                </div>
                <div class="client-phrase">
                    <img src="/images/<?php echo ( $user["result"]["users"][$userId]["status"]["email_verified"] ? "correct.png" : "close.png"); ?>" alt="Icon que mostra o perfil do cliente">
                    <span>Email verificado</span>
                </div>
                <div class="client-phrase">
                    <img src="/images/<?php echo ( $user["result"]["users"][$userId]["status"]["profile_complete"] ? "correct.png" : "close.png"); ?>" alt="Icon que mostra o perfil do cliente">
                    <span>Perfil Completo</span>
                </div>
                <div class="client-phrase">
                    <img src="/images/<?php echo ( $user["result"]["users"][$userId]["status"]["phone_verified"] ? "correct.png" : "close.png"); ?>" alt="Icon que mostra o perfil do cliente">
                    <span>Telefone verificado</span>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="logo">
            <a href="/">
                <img src="/images/logo_marca_branca.png" alt="Logo Code Company" class="logo">
                <h2>Code Company</h2>
            </a>
        </div>
        <div id="contato">
            <h3>Redes sociais e contato</h3>
            <a href="https://www.instagram.com/codecompanybrasil/" class="item" target="_blank">
                <img src="/images/instagram.svg" alt="Email Icon" class="icon">
                <p>Instagram</p>
            </a>
            <a href="https://github.com/Code-Company" class="item" target="_blank">
                <img src="/images/github.svg" alt="Email Icon" class="icon">
                <p>Git Hub</p>
            </a>
            <a href="mailto:support@codecompany.org" class="item" target="_blank">
                <img src="/images/envelope.svg" alt="Email Icon" class="icon">
                <p>support@codecompany.org</p>
            </a>
        </div>
    </footer>
    <script src="/js/functions.js"></script>
    <script src="/js/job.js"></script>
    <script>
        const cookies = getCookies()
        var design = new DesignController()
        if (!cookies) {
            design.loginHeaderCelular(false)
            design.loginHeader(false)
        } else {
            requiringDiscord((response) => {
                console.log(response.id)
                design.loginHeader(true, response.avatar, response.id)
                design.loginHeaderCelular(true)
            }, cookies.user)
        }
    </script>
    <script>
        const bidAmount = document.getElementById("bidAmount")
        const prazo = document.getElementById("prazo")
        let minPrice = <?php echo $result["result"]["budget"]["minimum"]; ?>

        let maxPrice = <?php echo $result["result"]["budget"]["maximum"]; ?>
        
        bidAmount.value = maxPrice - minPrice
        prazo.value = 7
    </script>
</body>
</html>
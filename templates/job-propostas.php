<?php
    //$jobId = 35942729;
    $utils = new UtilsFunctions();
    $jobId = $utils->urlSearchParam($_SERVER["REQUEST_URI"]);
    if (!$jobId) {
        render("404.html");
        die();
    }
    $home = new Home(1);
    $result = $home->get("https://www.freelancer.com/api/projects/0.1/projects/".$jobId."?full_description=true");
    if ($result["status"] == "error") {
        render("404.html");
        die();
    }

    $bids = $home->get("https://www.freelancer.com/api/projects/0.1/bids/?projects[]=".$jobId."&user_avatar=true&user_preferred_details=true&user_country_details=true&project_details=true&corporate_users=true&user_details=true");
    if ($bids["status"] == "error") {
        render("404.html");
        die();
    }

    if ($_GET["page"]) {
        $lenJobPrint = ((int) ($_GET["page"]) - 1) * 8;
    } else {
        $lenJobPrint = 0;
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propostas - Equipe de Freelance</title>
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
            </h1>
            <img src="../../images/salvar.png" id="salvar" alt="Icone para salvar o trabalho">
        </div>
        <div class="faixa-header">
            <p class="job-status-phone">
                <?php echo $result["result"]["frontend_project_status"]; ?>
            </p>
        </div>
        <div class="faixa-header">
            <nav>
                <a href="#" id="detalhes">
                    Detalhes
                </a>
                <a href="#" class="faixa-header-selected" id="propostas">
                    Propostas
                </a>
            </nav>
            <p class="job-status">
                <?php echo $result["result"]["frontend_project_status"]; ?>
            </p>
        </div>
    </div>
    <main>
        <div class="job-content center">
            <?php
                for ($i=$lenJobPrint;$i<sizeof($bids["result"]["bids"]);$i++) {
                    if ($i == $lenJobPrint + 8) {
                        break;
                    }
                    $bid = $bids["result"]["bids"][$i];
                    $days = (int) ($bid["period"]);
                    $freelancer = $home->get("https://www.freelancer.com/api/users/0.1/users?users[]=".$bid["bidder_id"]."&country_details=true&reputation=true&status=true&sanction_details=true&profile_description=true&balance_details=true&display_info=true&preferred_details=true");
                    //$freelancerId = $bid["owner"]["id"];
                    $freelancerId = $bid["bidder_id"];
                    $stars = (int) ($freelancer["result"]["users"][$freelancerId]["reputation"]["entire_history"]["overall"]);
                    // var_dump($freelancer["result"]["users"][$freelancerId]["username"]);
                    // echo "<br><br>";
                    // echo "<pre style='margin-left: 800px;width: 100%;'>";
                    // print_r($freelancer["result"]["users"][$freelancerId]); //["preferred_freelancer"]
                    // echo "</pre>";
            ?>
            <div class="freelancers-area">
                <div class="freelancer">
                    <div class="freelancer-section">
                        <div style="display: flex;gap: 15px;justify-content: center;">
                            <a href="https://www.freelancer.com/u/<?php echo $freelancer["result"]["users"][$freelancerId]["username"]; ?>" class="photo-freelancer" target="_blank">
                                <img src="<?php echo "https:".$bids["result"]["users"][$freelancerId]["avatar_cdn"]; ?>" alt="Avatar do freelancer que fez a proposta">
                            </a>
                            <div class="freelancer-details">
                                <div class="title-freelancer-details">
                                    <h3><?php echo $freelancer["result"]["users"][$freelancerId]["display_name"]; ?></h3>
                                    <a href="https://www.freelancer.com/u/<?php echo $freelancer["result"]["users"][$freelancerId]["username"]; ?>" target="_blank" class="markup">@<?php echo $freelancer["result"]["users"][$freelancerId]["username"]; ?></a>
                                </div>
                                <div class="freelancer-classification">
                                    <div class="classification-group-phone" style="gap: 10px;">
                                        <div class="classification-group">
                                            <?php
                                                for ($c=0;$c<$stars;$c++) {
                                            ?>
                                            <img src="/images/star-filled.png" alt="Icon de estrelas do freelancer">
                                            <?php
                                                }
                                                for ($c=0;$c<5-$stars;$c++) {
                                            ?>
                                            <img src="/images/star.png" alt="Icon de estrelas do freelancer">
                                            <?php
                                                }
                                            ?>
                                            <span class="classification-value"><?php echo $stars; ?></span>
                                        </div>
                                        <div class="classification-group">
                                            <img src="../../images/chat.png" alt="Icon de mensagems do freelancer concorrente">
                                            <span class="classification-value">
                                                <?php echo $freelancer["result"]["users"][$freelancerId]["reputation"]["entire_history"]["reviews"]; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="classification-group-phone" style="gap: 10px;">
                                        <div class="classification-group">
                                            <img src="https:<?php echo $freelancer["result"]["users"][$freelancerId]["location"]["country"]["flag_url_cdn"]; ?>" alt="Icon do país do freelancer" class="country-emoji">
                                            <span><?php echo $freelancer["result"]["users"][$freelancerId]["location"]["country"]["name"]; ?></span>
                                        </div>
                                        <div class="freelancer-tags">
                                            <?php
                                                // var_dump($freelancer["result"]["users"][$freelancerId]["preferred_freelancer"]);
                                                if ($freelancer["result"]["users"][$freelancerId]["preferred_freelancer"]) {
                                                    echo '<img src="/images/preferred.svg" alt="Tag de freelancer preferido" class="preferred-tag">';
                                                }

                                                if ($freelancer["result"]["users"][$freelancerId]["corporate"]["status"] == "active") {
                                                    echo '<img src="/images/corporate.svg" alt="Tag de freelancer de corporação" class="corporate-tag">';
                                                }

                                                if ($freelancer["result"]["users"][$freelancerId]["status"]["freelancer_verified_user"]) {
                                                    echo '<img src="/images/verified.svg" alt="Tag de freelancer verificado" class="verified-tag">';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="price-area-phone">
                                    <?php 
                                        if (!$bid["sealed"]) {
                                    ?>
                                    <p class="title-price-area">$<?php echo $bid["amount"]." ".$result["result"]["currency"]["code"]; ?></p>
                                    <?php 
                                        }
                                    ?>
                                    <span>Em <?php echo "$days ";echo ($days > 1 ? "dias" : "dia"); ?></span>
                                </div>
                                <p class="freelancer-strong">
                                    <?php echo $freelancer["result"]["users"][$freelancerId]["tagline"]; ?>
                                </p>
                            </div>
                        </div>
                        <div class="price-area">
                            <?php 
                                if (!$bid["sealed"]) {
                            ?>
                            <p class="title-price-area">$<?php echo $bid["amount"]." ".$result["result"]["currency"]["code"]; ?></p>
                            <?php
                                }
                            ?>
                            <span>Em <?php echo "$days ";echo ($days > 1 ? "dias" : "dia"); ?></span>
                        </div>
                    </div>
                    <div class="freelancer-proposal">
                        <?php
                            if ($bid["sealed"]) {
                                echo '<div class="job-tag selado">Selado</div>';
                            } else {
                                echo $bid["description"];
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
            <div class="freelancer-pages">
                <?php
                    if (sizeof($bids["result"]["bids"]) < 8) {
                        $len = sizeof($bids["result"]["bids"]);
                    } else {
                        $len = sizeof($bids["result"]["bids"]) / 8;
                    }
                    for ($i=0;$i<$len;$i++) {
                ?>
                <div class="page-number"><?php echo $i + 1; ?></div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="about-client">
            <div class="bid-area">
                <div class="bid-section">
                    <p>Propostas</p>
                    <p class="bid-section-value">
                        <?php echo $result["result"]["bid_stats"]["bid_count"] ?>
                    </p>
                </div>
                <div class="bid-area-line"></div>
                <div class="bid-section">
                    <p>Lance médio</p>
                    <p class="bid-section-value">
                        <?php echo "$". (int) ($result["result"]["bid_stats"]["bid_avg"]) . " " . $result["result"]["currency"]["code"]; ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="logo">
            <a href="/">
                <img src="../../images/logo_marca_branca.png" alt="Logo Code Company" class="logo">
                <h2>Code Company</h2>
            </a>
        </div>
        <div id="contato">
            <h3>Redes sociais e contato</h3>
            <a href="https://www.instagram.com/codecompanybrasil/" class="item" target="_blank">
                <img src="../../images/instagram.svg" alt="Email Icon" class="icon">
                <p>Instagram</p>
            </a>
            <a href="https://github.com/Code-Company" class="item" target="_blank">
                <img src="../../images/github.svg" alt="Email Icon" class="icon">
                <p>Git Hub</p>
            </a>
            <a href="mailto:support@codecompany.org" class="item" target="_blank">
                <img src="../../images/envelope.svg" alt="Email Icon" class="icon">
                <p>support@codecompany.org</p>
            </a>
        </div>
    </footer>
    <script src="/js/functions.js"></script>
    <script src="/js/job.js"></script>
    <!-- <script>
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
    </script> -->
    <script>
        const pagesNumber = document.querySelectorAll(".page-number")
        const details = document.getElementById("detalhes")
        //const url = new URL(String(window.location.href))
        for (let c=0;c<pagesNumber.length;c++) {
            var child = pagesNumber[c]

            if (url.searchParams.has("page")) {
                var page = url.searchParams.get("page")
                if (child.innerHTML == page) {
                    child.classList.add("page-number-selected")
                }
            } else {
                if (child.innerHTML == "1") {
                    child.classList.add("page-number-selected")
                } 
            }

            child.addEventListener("click", (e) => {
                url.searchParams.delete("page")
                url.searchParams.append("page", c + 1)
                window.location.href = url.href
            })
        }

        details.href = `${url.origin}${url.pathname}/../details`

    </script>
</body>
</html>
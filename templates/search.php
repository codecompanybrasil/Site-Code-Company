<?php
    $home = new Home(1);
    $params = "";
    if (isset($_GET["q"])) {
        $params .= "&query=". $_GET["q"];
    }

    if (isset($_GET["type"])) {
        if ($_GET["type"] == "fixed") {
            $params .= "&type=fixed";
        } else if ($_GET["type"] == "hourly") {
            $params .= "&type=hourly";
        }
    }

    if (isset($_GET["page"])) {
        if (is_numeric($_GET["page"])) {
            if ($_GET["page"] > 1) {
                $params .= "&offset=" . ((int) ($_GET["page"]) * 8);
            }
        }
    }

    if (isset($_GET["country"])) {
        if ($_GET["country"] == "br") {
            $params .= "&countries[]=br";
        } else if ($_GET["country"] == "us") {
            $params .= "&countries[]=us";
        }
    }

    if (isset($_GET["min-fixed-price"])) {
        if (is_numeric($_GET["min-fixed-price"])) {
            $params .= "&min_avg_price=" . $_GET["min-fixed-price"];
        }
    }

    if (isset($_GET["max-fixed-price"])) {
        if (is_numeric($_GET["max-fixed-price"])) {
            $params .= "&max_avg_price=" . $_GET["max-fixed-price"];
        }
    }

    if (isset($_GET["min-hourly-price"])) {
        if (is_numeric($_GET["min-hourly-price"])) {
            $params .= "&min_avg_hourly_rate=" . $_GET["min-hourly-price"];
        }
    }

    if (isset($_GET["max-hourly-price"])) {
        if (is_numeric($_GET["max-hourly-price"])) {
            $params .= "&max_avg_hourly_rate=" . $_GET["max-hourly-price"];
        }
    }

    echo "https://www.freelancer.com/api/projects/0.1/projects/active/?limit=20&full_description=true&job_details=true&user_details=true&user_employer_reputation=true&compact=true&user_reputation=true&upgrade_details=true$params";
    $result = $home->get("https://www.freelancer.com/api/projects/0.1/projects/active/?limit=20&full_description=true&job_details=true&user_details=true&user_employer_reputation=true&compact=true&user_reputation=true&upgrade_details=true$params");
    if ($result["status"] == "error") {
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
    <title>Pesquisar - Equipe de Freelance</title>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/simple-header.css">
    <link rel="stylesheet" href="/css/search.css">
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
            <h1>Pesquisar jobs</h1>
        </div>
        <form action="/" method="get" class="faixa-header">
            <input type="search" name="search" id="search">
            <img src="/images/search.png" alt="Icone para pesquisar" id="search-submit">
            <img src="/images/filtro.png" alt="Icone para abrir o filtro" id="filtro-button">
        </form>
        <div class="faixa-header">
            <nav>
                <a href="#" class="faixa-header-selected">
                    Projetos
                </a>
                <img src="/images/search.png" alt="Icone para pesquisar" id="search-submit-phone">
            <img src="/images/filtro.png" alt="Icone para abrir o filtro" id="filtro-button-phone">
                <!-- <a href="#">
                    Propostas
                </a> -->
            </nav>
        </div>
    </div>
    <main>
        <div class="main-content">
            <div class="filter-area">
                <div class="filter-content">
                    <div class="filter-block-title">
                        <h2>Filtro</h2>
                        <button id="search-filter">
                            Procurar
                        </button>
                    </div>
                    <div class="filter-block">
                        <div class="filter-block-title">
                            <h3>Tipo do projeto</h3>
                            <button class="button-clear" id="clear-type-project">
                                Clear
                            </button>
                        </div>
                        <div class="filter-block-content">
                            <div class="checkbox">
                                <input type="checkbox" name="fixed-price" id="fixed-price">
                                <span>Preço fixo</span>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="hourly-rate" id="hourly-rate">
                                <span>Preço por hora</span>
                            </div>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-block-title">
                            <h3>Preço fixo</h3>
                            <button class="button-clear" id="clear-fixed-price">
                                Clear
                            </button>
                        </div>
                        <div class="filter-block-content">
                            <div class="price-box">
                                <span>min</span>
                                <div class="search-area">
                                    <span>$</span>
                                    <input type="number" id="min-fixed-price" placeholder="0">
                                    <span>USD</span>
                                </div>
                            </div>
                            <div class="price-box">
                                <span>max</span>
                                <div class="search-area">
                                    <span>$</span>
                                    <input type="number" id="max-fixed-price" placeholder="1500+">
                                    <span>USD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-block-title">
                            <h3>Preço por hora</h3>
                            <button class="button-clear" id="clear-hourly-price">
                                Clear
                            </button>
                        </div>
                        <div class="filter-block-content">
                            <div class="price-box">
                                <span>min</span>
                                <div class="search-area">
                                    <span>$</span>
                                    <input type="number" id="min-hourly-price" placeholder="0">
                                    <span>USD</span>
                                </div>
                            </div>
                            <div class="price-box">
                                <span>max</span>
                                <div class="search-area">
                                    <span>$</span>
                                    <input type="number" id="max-hourly-price" placeholder="80+">
                                    <span>USD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="filter-block">
                        <div class="filter-block-title">
                            <h3>Habilidades</h3>
                            <button class="button-clear">
                                Clear
                            </button>
                        </div>
                        <div class="filter-block-content">
                            <div class="search-area" style="align-items: center;display: flex;gap: 10px;">
                                <img src="../images/search.png" alt="Icon de busca">
                                <input type="text" name="skills-input" id="skills-input">
                            </div>
                        </div>
                    </div> -->
                    <div class="filter-block">
                        <div class="filter-block-title">
                            <h3>Linguagens</h3>
                            <button class="button-clear" id="clear-linguagem">
                                Clear
                            </button>
                        </div>
                        <div class="filter-block-content">
                            <div class="checkbox">
                                <input type="checkbox" name="br-lang" id="br-lang">
                                <span>Português</span>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="en-lang" id="en-lang">
                                <span>Inglês</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="job-area">
                <div class="result-area">
                    <h2>Resultados</h2>
                </div>
                <?php
                    if (sizeof($result["result"]["projects"]) == 0) {
                ?>
                <div class="line-division"></div>
                <div class="no-job">
                    <h3>Sem resultados</h3>
                </div>
                <?php
                    }
                ?>
                <?php
                    for ($i=0;$i<sizeof($result["result"]["projects"]);$i++) {
                        $project = $result["result"]["projects"][$i];
                        $price = $project["budget"]["maximum"] - $project["budget"]["minimum"];
                        $description = str_replace("\n", "<br>", $project["description"]);
                        $freelancer = $result["result"]["users"][$project["owner_id"]];
                ?>
                <div class="line-division"></div>
                <div class="job" data-id="<?php echo $project["id"]; ?>"> <!--a href="<?php echo (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/job" . "/" . $project["id"]; ?>"-->
                    <div class="job-title">
                        <div>
                            <h2><?php echo $project["title"]; ?></h2>
                            <div class="job-tags">
                                <?php
                                    if ($project["upgrades"]["recruiter"]) {
                                        echo '<div class="job-tag recrutamento">Recrutamento</div>';
                                    }

                                    if ($project["upgrades"]["urgent"]) {
                                        echo '<div class="job-tag urgente">Urgente</div>';
                                    }

                                    if ($project["upgrades"]["sealed"]) {
                                        echo '<div class="job-tag selado">Selado</div>';
                                    }

                                    if ($project["upgrades"]["featured"]) {
                                        echo '<div class="job-tag urgente">Urgente</div>';
                                    }
                                ?>
                            </div>
                            <!-- <p class="bids">32 Propostas</p> -->
                            <div class="job-price-phone">
                                <h3><?php echo $project["currency"]["sign"]. " " . $price . " " . $project["currency"]["code"]; ?></h3>
                                <span>Proposta média</span>
                            </div>
                        </div>
                        <?php 
                            if ($project["bid_stats"]["bid_count"] > 0) {
                        ?>
                        <div class="job-price">
                            <h3><?php echo $project["currency"]["sign"]. " " . $price . " " . $project["currency"]["code"]; ?></h3>
                            <span>Proposta média</span>
                            <img src="/images/salvar.png" style="z-index: 5;" alt="Icon para salvar job no seu perfil" class="salvar-img-phone background-hover">
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="job-price-be-first">
                            <div class="be-first">
                                Seja o primeiro!
                            </div>
                            <img src="/images/salvar.png" style="z-index: 5;" alt="Icon para salvar job no seu perfil" class="salvar-img-phone background-hover">
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="job-content">
                        <p>
                            <span><?php echo $description; ?></span>
                            <!-- <button class="more">More</button> -->
                        </p>
                    </div>
                    <nav>
                        <?php
                            for ($c=0;$c<sizeof($project["jobs"]);$c++) {
                        ?>
                        <span class="habilitie">
                            <?php echo $project["jobs"][$c]["name"]; ?>
                        </span>
                        <?php
                            }
                        ?>
                    </nav>
                    <div class="job-title classification-area" style="margin-top: 15px;">
                        <div class="classification">
                            <div class="classification-content">
                                <?php
                                    $stars = (int) ($freelancer["employer_reputation"]["entire_history"]["overall"]);
                                    for ($c=0;$c<$stars;$c++) {
                                        echo '<img src="/images/star-filled.png" alt="Icon de estrela cheia" class="job-star">';
                                    }

                                    for ($c=0;$c<5-$stars;$c++) {
                                        echo '<img src="/images/star.png" alt="Icon de estrela vazia" class="job-star">';
                                    }
                                ?>
                                <span><?php echo $stars;?></span>
                            </div>
                            <div class="classification-content">
                                <img src="/images/chat.png" alt="Icon de quantos comentários o post deu">
                                <span><?php echo $freelancer["reputation"]["entire_history"]["reviews"]; ?></span>
                            </div>
                            <?php
                                if ($project["bid_stats"]["bid_count"] > 0) {
                            ?>
                            <div class="classification-content bid-num">
                                <h3><?php echo $project["bid_stats"]["bid_count"]; ?> Propostas</h3>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="job-details">
                            <?php 
                                //Calculing time stamp
                                $date = new Datetime();
                                $timestamp = $date->getTimestamp();
                                $timeJob = $project["submitdate"];
                                $tempo = round(($timestamp - $timeJob) / 60, 0); //Minutos
                                $tempoText = "minuto";
                                if ($tempo >= 60) {
                                    $tempo = round($tempo / 60, 0); //Horas
                                    $tempoText = "hora";
                                    if ($tempo >= 24) {
                                        $tempo = round($tempo / 24, 0);
                                        $tempoText = "dia";
                                    }
                                }

                                if ($tempo > 1) {
                                    $tempoText ."s";
                                }

                                echo "<span>Há $tempo $tempoText</span>";
                            ?>
                            <img src="/images/salvar.png" style="z-index: 5;" alt="Icon para salvar job no seu perfil" class="salvar-img background-hover">
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
                <div class="job-more-area">
                    <div class="job-more">
                        <img src="../images/left-arrow.png" alt="Icon para voltar para os trabalhos anteriores" class="job-arrow" id="back-page">
                        <div class="number-select">1</div>
                        <?php
                            if(!isset($_GET["page"]) or !is_numeric($_GET["page"]) or $_GET["page"] == "1" or $_GET["page"] == "2") {
                        ?>
                        <div class="number-select">2</div>
                        <div class="number-select">3</div>
                        <div class="number-select">4</div>
                        <?php
                            } else {
                                $page = (int) ($_GET["page"]);
                                echo '<div class="number-select">'.($page - 1).'</div>';
                                echo '<div class="number-select">'.($page).'</div>';
                                echo '<div class="number-select">'.($page + 1).'</div>';
                            }
                        ?>
                        <img src="../images/left-arrow.png" alt="Icon para pegar os proximos trabalhos" class="job-arrow" style="transform: rotate(180deg);" id="next-page">
                    </div>
                </div>

            </div>
        </div>
    </main>
    <div class="hidden-filter-area">
        <div id="close-filter-area">X</div>
        <div class="filter-area-phone">
            <div class="filter-content">
                <div class="filter-block-title">
                    <h2>Filtro</h2>
                    <button id="search-filter">
                        Procurar
                    </button>
                </div>
                <div class="filter-block">
                    <div class="filter-block-title">
                        <h3>Tipo do projeto</h3>
                        <button class="button-clear" id="clear-type-project">
                            Clear
                        </button>
                    </div>
                    <div class="filter-block-content">
                        <div class="checkbox">
                            <input type="checkbox" name="fixed-price" id="fixed-price">
                            <span>Preço fixo</span>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="hourly-rate" id="hourly-rate">
                            <span>Preço por hora</span>
                        </div>
                    </div>
                </div>
                <div class="filter-block">
                    <div class="filter-block-title">
                        <h3>Preço fixo</h3>
                        <button class="button-clear" id="clear-fixed-price">
                            Clear
                        </button>
                    </div>
                    <div class="filter-block-content">
                        <div class="price-box">
                            <span>min</span>
                            <div class="search-area">
                                <span>$</span>
                                <input type="number" id="min-fixed-price" placeholder="0">
                                <span>USD</span>
                            </div>
                        </div>
                        <div class="price-box">
                            <span>max</span>
                            <div class="search-area">
                                <span>$</span>
                                <input type="number" id="max-fixed-price" placeholder="1500+">
                                <span>USD</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter-block">
                    <div class="filter-block-title">
                        <h3>Preço por hora</h3>
                        <button class="button-clear" id="clear-hourly-price">
                            Clear
                        </button>
                    </div>
                    <div class="filter-block-content">
                        <div class="price-box">
                            <span>min</span>
                            <div class="search-area">
                                <span>$</span>
                                <input type="number" id="min-hourly-price" placeholder="0">
                                <span>USD</span>
                            </div>
                        </div>
                        <div class="price-box">
                            <span>max</span>
                            <div class="search-area">
                                <span>$</span>
                                <input type="number" id="max-hourly-price" placeholder="80+">
                                <span>USD</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="filter-block">
                    <div class="filter-block-title">
                        <h3>Habilidades</h3>
                        <button class="button-clear">
                            Clear
                        </button>
                    </div>
                    <div class="filter-block-content">
                        <div class="search-area" style="align-items: center;display: flex;gap: 10px;">
                            <img src="../images/search.png" alt="Icon de busca">
                            <input type="text" name="skills-input" id="skills-input">
                        </div>
                    </div>
                </div> -->
                <div class="filter-block">
                    <div class="filter-block-title">
                        <h3>Linguagens</h3>
                        <button class="button-clear" id="clear-linguagem">
                            Clear
                        </button>
                    </div>
                    <div class="filter-block-content">
                        <div class="checkbox">
                            <input type="checkbox" name="br-lang" id="br-lang">
                            <span>Português</span>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="en-lang" id="en-lang">
                            <span>Inglês</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="logo">
            <a href="/">
                <img src="../images/logo_marca_branca.png" alt="Logo Code Company" class="logo">
                <h2>Code Company</h2>
            </a>
        </div>
        <div id="contato">
            <h3>Redes sociais e contato</h3>
            <a href="https://www.instagram.com/codecompanybrasil/" class="item" target="_blank">
                <img src="../images/instagram.svg" alt="Email Icon" class="icon">
                <p>Instagram</p>
            </a>
            <a href="https://github.com/Code-Company" class="item" target="_blank">
                <img src="../images/github.svg" alt="Email Icon" class="icon">
                <p>Git Hub</p>
            </a>
            <a href="mailto:support@codecompany.org" class="item" target="_blank">
                <img src="../images/envelope.svg" alt="Email Icon" class="icon">
                <p>support@codecompany.org</p>
            </a>
        </div>
    </footer>
    <script src="../js/functions.js"></script>
    <script src="../js/search-job.js"></script>
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
        const salvar = document.querySelectorAll(".salvar-img")
        const jobs = document.querySelectorAll(".job")
        
        function clickIn(c) {
            try {
                c = c.currentTarget.myParam
            } catch {
                c = c
            }
            let url = new URL(String(window.location.href))
            window.location.href = `${url.origin}/job/${jobs[c].dataset.id}`
        }

        for (let c=0;c<salvar.length;c++) {
            salvar[c].addEventListener("click", e => {
                for (let c=0;c<jobs.length;c++) {
                    jobs[c].removeEventListener("click", clickIn)
                    jobs[c].myParam = c
                }
                alert(1)
                setTimeout(e => {
                    for (let c=0;c<jobs.length;c++) {
                        jobs[c].addEventListener("click", clickIn)
                        jobs[c].myParam = c
                    }
                }, 100)
            })
        }

        for (let c=0;c<jobs.length;c++) {
            jobs[c].addEventListener("click", clickIn)
            jobs[c].myParam = c
        }
    </script>
</body>
</html>
<?php
    
    use \Bramus\Router\Router;

    function render($file) {
        if (file_exists(__DIR__."/$file")) {
            include __DIR__."/$file";
        }
    }

    function isCookie($name, $returnLink) {
        if ($_COOKIE[$name]) {
            return true;
        } else {
            header('Location: '. $returnLink);
        }
    }

    function getLink() {
        if (empty($_SERVER["HTTPS"])) {
            $method = "http";
        } else {
            $method = "https";
        }

        $link = $method . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return rtrim($link, "/");
    }

    function isFreelancer() {
        if (isCookie("user", $_ENV["LINK"]."login")) {
            return true;
        }
        return false;
    }
    
    $router = new Router();

    $router->get("/", function(){
        render("home.html");
    });

    $router->get("/job/{jobId}/details", function($jobId) {
        render("job.php");
    });

    $router->get("/job/{jobId}/proposals", function($jobId) {
        render("job-propostas.php");
    });

    $router->get("/job/{jobId}", function($jobId) {
        $link = getLink();
        header("location: ".$link . "/details");
    });

    $router->post("/api/bid", function() {
        $bid = new Bid();
        echo "belu";
        $place = $bid->place($_POST);
        if ($place == "no bid") {
            header("location: ". $_ENV["LINK"] . "404");
        }
    });

    $router->get("/search", function() {
        render("search.php");
    });

    $router->get("/inbox/thread/{thread}", function($thread) {
        render("chat-message.php");
    });

    $router->get("/inbox", function() {
        render("chat-message.php");
    });

    $router->get("/account", function() {
        if (isCookie("user", $_ENV["LINK"]."login")) {
            render("conta.html");
        }
    });

    $router->get("/logout", function() {
        unset($_COOKIE["user"]);
        setcookie('user', null, -1, '/');
        header("location: " . $_ENV["LINK"]);
    });

    $router->get("/auth", function() {
        render("auth.php");
    });

    $router->get("/login", function() {
        render("login.html");
    });

    $router->get("/freelance", function() {
        if (isFreelancer()) {
            render("dashboard.html");
        } else {
            render("freelance.html");
        }
    });

    $router->set404(function() {
        header('HTTP/1.1 404 Not Found');
        render("404.html");
    });

    $router->run();
 
?>
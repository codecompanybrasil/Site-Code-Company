<?php
    //echo str_replace("#", "?", "/auth/#token_type=Bearer&access_token=jhSfrKIX7VWleYq9hXF8vp2NBvXOLd&expires_in=604800&scope=identify")

    //echo $_SERVER["REQUEST_URI"];

    if (stripos($_SERVER["REQUEST_URI"], "access_token")) {
        echo "<br>Carregando...";

        $token = $_GET["access_token"];
        setcookie("user", $token, time() + intval($_GET["expires_in"]), "/");

        header("location: https://codecompany.org/account");
        
    }

    //setcookie("user", $_GET["access_token"], time() + intval($_GET["expires_in"]), "/");

    //token_type - Bearer
    //access_token - Token
    //expires_in - 604800
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect</title>
</head>
<body>
    <script>
        function getCookies() {
            var savedCookies = {}
            var cookies = String(document.cookie).split(";")
            for (let c=0;c<cookies.length;c++) {
                let values = cookies[c].split("=")
                let name = values[0].replace(" ", "")
                let value = values[1]
                savedCookies[name] = value
            }
            return savedCookies
        }


        var cookies = getCookies()

        let link = String(window.location.href)
        if (link.indexOf("access_token") != -1 && link.indexOf("#") != -1) {
            link = link.replace("#", "?")
            window.location.href = link
        }
    </script>
    <!-- <script>
        const fragment = new URLSearchParams(window.location.href.slice(1))
        const [accessToken, tokenType] = [fragment.get('access_token'), fragment.get('token_type')]
        if (!accessToken) {
            window.location.href("/")
        }
        fetch("https://discord.com/api/users/@me", {
            headers: {
                authorization: `Bearers ${accessToken}`
            }
        })
        .then(result => result.json())
        .then(response => {
            if (response.code != undefined) {
                console.log(response)
                //window.location.href = "http://127.0.0.1:3000/404"
            } else {
                window.location.href = "http://127.0.0.1:3000/account"
            }
        })
        .catch(console.error)
    </script> -->
</body>
</html>
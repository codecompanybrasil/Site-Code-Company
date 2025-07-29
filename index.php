<?php
    require __DIR__ . "/vendor/autoload.php";

    $_ENV = parse_ini_file(".env");

    // echo "<pre style='color: green;'>";
    // print_r($_COOKIE);
    // echo "</pre>";
    //print_r($_ENV);
    require __DIR__ . "/app/Api/Home.php";
    require __DIR__ . "/app/Api/Bid.php";
    require __DIR__ . "/app/Utils/URLController.php";

    require __DIR__ . "/app/db/db.php";

    // use \App\Api\Home;

    // $api = new Home("token");
    // $api->simpleReq("https://example.com/");

    // $api = new Home();

    // $api->simpleText();

    include __DIR__ . "/templates/index.php";
?>
<?php
    // namespace App\Utils;

    class UtilsFunctions {

        public function urlSearchParam($url) {
            $url = parse_url($url, PHP_URL_PATH);
            $url = explode("/", ltrim($url, "/"));
            if ($url[0] == "job") {
                return $url[1];
            }

            return false;
        }
    }
?>
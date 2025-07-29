<?php
    // namespace App\Api;

    class Home {
        public $token;

        public function __construct($token) {
            $this->token = $token ?? getenv('lFHXB5WT1f20WJEMCwU7vfvD3J9jPH');
        }

        public static function simpleText() {
            echo "<br><br><br><br>Testando123";
        }

        public function get($url) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://jsonplaceholder.typicode.com/todos/1",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "User-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/37.0.2062.94 Chrome/37.0.2062.94 Safari/537.36",
                    //"freelancer-oauth-v1: "
                ]
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            $responseArray = json_decode($response, true);

            // echo $responseArray["result"]["users"]["64842521"]["username"];
            // echo "<br><br><pre>";
            // print_r($responseArray);
            // echo "</pre>";

            $retorno = is_array($responseArray) ? $responseArray : [];
            echo "<br>Retorno:<br>";
            print_r($retorno);
            return $retorno;

        }

        public function simpleReq($url) {
            //self::get('https://api-publica.speedio.com.br/buscarcnpj?cnpj=00000000000191');
            self::get("https://www.freelancer.com/api/users/0.1/users/?usernames[]=code212");

            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_SSH_COMPRESSION, true);
            // curl_setopt_array($ch, [
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_URL => $url
            // ]);
            // $result = curl_exec($ch);
            // print_r($result);
            // echo "<br><br><br>";
            // $photoData = unserialize($result);

            // print_r($photoData);
            // echo "<br><br><br>";
            // curl_close($ch);

            // echo 'Finished';
        }
    }
?>
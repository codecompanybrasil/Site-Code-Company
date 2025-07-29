<?php

    class Bid {
        
        public function place($params) {
            $bidAmount = $params["bidAmount"];
            $prazo = $params["prazo"];
            $proposta = $params["proposta"];
            $tarefa = $params["tarefa"];

            if ($bidAmount == "" || $prazo == "" || $proposta == "" || $tarefa == "") {
                return "no data";
            }

            if (sizeof($proposta) < 100) {
                return "minus";
            }

            echo "<pre>";
            print_r($params);
            echo "<br>";
            var_dump($params);
            echo "</pre>";
        }
    }
?>
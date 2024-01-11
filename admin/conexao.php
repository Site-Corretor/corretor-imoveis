<?php
    function conectar() {
        global $pdo;
        try {
            //$pdo = new PDO("mysql:dbname=; host=labdados.c9jujwhlxlit.sa-east-1.rds.amazonaws.com", "sistema", "7847awse");
            // $pdo = new PDO('mysql:host=localhost;dbname=corretora', 'root');
            $pdo = new PDO("mysql:dbname="."u830382291_corretor".";host="."br-asc-web1181.main-hosting.eu", "u830382291_corretor", "Ricardosouza1");
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }
?>
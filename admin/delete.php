<?php
    require_once 'conexao.php';
    $idArquivo = $_POST["imageID"];
    $msgErro = "";

    global $pdo;

    try {
        conectar();
            $sql = $pdo->prepare('DELETE FROM regstro_anexo WHERE codigo = :codigo;');
            $sql->bindValue(':codigo', $idArquivo);
            $sql->execute();
        
            if ($sql->rowCount() > 0) {
                echo 'Arquivo deletado com sucesso';
            } else {
                echo 'Erro ao deletar o arquivo';
            }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
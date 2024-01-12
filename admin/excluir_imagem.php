
<?php
require_once 'clsControle.php';
$p = new User;
$p->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteImage']) && !empty($_POST['deleteImage'])) {
        // $codigo = $_GET['codigo'];
        // $img = $_POST['deleteImage'];


        // echo "Excluindo imagem: $imagemParaExcluir no código: $codigo";

        // $p->deleteImagem($codigo, $img);

        // echo "Imagem excluída com sucesso";

        // header("Location: imagem.php?codigo=" . $codigo);
        // exit;

        $ftp_connection = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");
        ftp_login($ftp_connection, $ftp_user, $ftp_pass) or die("Couldn't login to ftp server");
        ftp_pasv($ftp_connection, true);

        $remover = '/public_html/admin/upload/';

        ftp_close($conn_id);


        if (ftp_delete($conn_id, $remote_file)) {
            echo "Arquivo $img excluído do FTP com sucesso";
        } else {
            echo "Falha ao excluir o arquivo $img do FTP";
        }


        // Excluir arquivo do banco de dados
        $p->deleteImagem($codigo, $img);

        echo "Imagem excluída do banco de dados com sucesso";

        header("Location: imagem.php?codigo=" . $codigo);
    } else {
        echo "Nenhuma imagem para excluir";
    }
} else {
    echo "Método de solicitação inválido";
}
?>
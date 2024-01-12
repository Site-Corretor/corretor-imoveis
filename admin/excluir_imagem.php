<?php
require_once 'clsControle.php';
require_once 'conexao_ftp.php';
require_once 'ftp.php';
$p = new User;
$p->conectar();

$codigo = $_GET['codigo'];
$img = $_GET['img'];
echo $img;
?>
<?php
require_once 'clsControle.php';
require_once 'conexao_ftp.php';
require_once 'ftp.php';
$p = new User;
$p->conectar();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteImage']) && !empty($_POST['deleteImage'])) {

        $ftp_host = "62.72.62.235";
        $ftp_user = "u830382291";
        $ftp_pass = "Ricardosouza1";

        // $img = $_GET['img'];
        $codigo = $_GET['codigo'];
        $ftp_connection = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");
        ftp_login($ftp_connection, $ftp_user, $ftp_pass) or die("Couldn't login to ftp server");
        ftp_pasv($ftp_connection, true);

        $remover = '/public_html/admin/upload/';
        $remote_file = $remover . $img; // Combine o caminho do diretório remoto com o nome do arquivo

        if (ftp_delete($ftp_connection, $remote_file)) {
            echo "Arquivo $img excluído do FTP com sucesso";
        } else {
            echo "Falha ao excluir o arquivo $img do FTP. Erro: ";
        }

        ftp_close($ftp_connection);

        // Excluir arquivo do banco de dados
        $p->deleteImagem($codigo, $img);

        echo "Imagem excluída do banco de dados com sucesso";

        header("Location: imagem.php?codigo=" . $codigo);
        exit;

    } else {
        echo "Nenhuma imagem para excluir";
    }
} else {
    echo "Método de solicitação inválido";
}
?>
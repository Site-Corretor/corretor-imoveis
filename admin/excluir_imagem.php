
<?php
require_once 'clsControle.php';
$p = new User;
$p->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteImage']) && !empty($_POST['deleteImage'])) {
        $codigo = $_GET['codigo'];
        $img = $_POST['deleteImage'];


        echo "Excluindo imagem: $imagemParaExcluir no código: $codigo";

        $p->deleteImagem($codigo, $img);

        echo "Imagem excluída com sucesso";

        header("Location: imagem.php?codigo=" . $codigo);
        exit;
    } else {
        echo "Nenhuma imagem para excluir";
    }
} else {
    echo "Método de solicitação inválido";
}
?>
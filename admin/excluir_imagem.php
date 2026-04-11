<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
    exit;
}

require_once 'clsControle.php';
require_once 'conexao_ftp.php';
require_once 'ftp.php';

$p = new User;
$p->conectar();

$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';
$img = isset($_GET['img']) ? $_GET['img'] : '';

/* =========================================================
   EXCLUSÃO VIA AJAX
   ---------------------------------------------------------
   Exclui imagem sem recarregar a página e, se ela era capa,
   define automaticamente a próxima imagem como nova capa.
========================================================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax_action']) &&
    $_POST['ajax_action'] === 'excluir_imagem'
) {
    header('Content-Type: application/json; charset=utf-8');

    if (empty($codigo) || empty($img)) {
        echo json_encode([
            'success' => false,
            'message' => 'Dados inválidos para exclusão.'
        ]);
        exit;
    }

    try {
        $imagensAntes = $p->getImagens($codigo);
        $eraCapa = false;

        if (!empty($imagensAntes)) {
            foreach ($imagensAntes as $imagemAtual) {
                if (
                    isset($imagemAtual['img'], $imagemAtual['capa']) &&
                    $imagemAtual['img'] == $img &&
                    $imagemAtual['capa'] == 1
                ) {
                    $eraCapa = true;
                    break;
                }
            }
        }

        /* =========================================================
           EXCLUSÃO LOCAL ATIVA
        ========================================================= */
        $arquivoLocal = __DIR__ . '/upload/' . $img;

        if (file_exists($arquivoLocal)) {
            unlink($arquivoLocal);
        }

        /* =========================================================
           LÓGICA ANTIGA FTP - MANTIDA COMENTADA
        ========================================================= */
        /*
        $ftp_host = "62.72.62.235";
        $ftp_user = "u830382291.u830382291";
        $ftp_pass = "Ricardosouza1";

        $ftp_connection = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");
        ftp_login($ftp_connection, $ftp_user, $ftp_pass) or die("Couldn't login to ftp server");
        ftp_pasv($ftp_connection, true);

        $remover = '/admin/upload/';
        $remote_file = $remover . $img;

        if (ftp_delete($ftp_connection, $remote_file)) {
            // Arquivo excluído do FTP com sucesso
        } else {
            // Falha ao excluir arquivo do FTP
        }

        ftp_close($ftp_connection);
        */

        $p->deleteImagem($codigo, $img);

        $novaCapa = null;

        if ($eraCapa) {
            $imagensRestantes = $p->getImagens($codigo);

            if (!empty($imagensRestantes) && isset($imagensRestantes[0]['img'])) {
                $p->updateCapa($codigo, $imagensRestantes[0]['img']);
                $novaCapa = $imagensRestantes[0]['img'];
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Imagem excluída com sucesso.',
            'nova_capa' => $novaCapa
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível excluir a imagem.'
        ]);
    }

    exit;
}

/* =========================================================
   LÓGICA ANTIGA COM RELOAD - MANTIDA COMO RESERVA
========================================================= */
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteImage']) && !empty($_POST['deleteImage'])) {

        $imagensAntes = $p->getImagens($codigo);
        $eraCapa = false;

        if (!empty($imagensAntes)) {
            foreach ($imagensAntes as $imagemAtual) {
                if (
                    isset($imagemAtual['img'], $imagemAtual['capa']) &&
                    $imagemAtual['img'] == $img &&
                    $imagemAtual['capa'] == 1
                ) {
                    $eraCapa = true;
                    break;
                }
            }
        }

        $arquivoLocal = __DIR__ . '/upload/' . $img;

        if (file_exists($arquivoLocal)) {
            unlink($arquivoLocal);
        }

        $p->deleteImagem($codigo, $img);

        if ($eraCapa) {
            $imagensRestantes = $p->getImagens($codigo);

            if (!empty($imagensRestantes) && isset($imagensRestantes[0]['img'])) {
                $p->updateCapa($codigo, $imagensRestantes[0]['img']);
            }
        }

        header("Location: imagem.php?codigo=" . $codigo);
        exit;
    } else {
        echo "Nenhuma imagem para excluir";
    }
} else {
    echo "Método de solicitação inválido";
}
*/
?>
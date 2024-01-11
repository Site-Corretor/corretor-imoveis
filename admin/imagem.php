<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
    exit;
}
$codigo = $_GET['codigo'];


require_once 'clsControle.php';
$p = new User;
$p->conectar();

// Lógica para processar o envio de novas imagens
if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'][0])) {
    $uploadDirectory = 'upload/';

    // Loop através do array de arquivos
    for ($i = 0; $i < count($_FILES['imagem']['name']); $i++) {
        $fileName = $_FILES['imagem']['name'][$i];
        $fileTmpName = $_FILES['imagem']['tmp_name'][$i];

        $pathInfo = pathinfo($fileName);
        $fileExtension = $pathInfo['extension'];

        $fileDestination = $uploadDirectory . $codigo . "-" . $i . "." . $fileExtension;

        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $img = $fileDestination;
            $p->updateImagem($codigo, $img);
        } else {
            echo "Erro ao fazer upload do arquivo $fileName<br>";
        }
    }
}
$imagens = $p->getImagens($codigo);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Envio de Imagem</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        #page {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            color: #007bff;
        }

        .custom-file {
            margin-bottom: 20px;
        }

        .image-container {
            display: inline-block;
            margin: 10px;
            text-align: center;
            width: calc(33.33% - 20px);
            /* 33.33% para três imagens por linha com margens de 10px */
        }

        .image-container img {
            width: 150px;
            /* Largura desejada */
            height: 150px;
            /* Altura desejada */
            object-fit: cover;
            border-radius: 5px;
        }

        .delete-form {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div id="page" class="container">

        <h2 class="text-center">Upload de Imagem</h2>

        <form action="imagem.php?codigo=<?php echo $codigo ?>" method="post" enctype="multipart/form-data">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="imagem[]" accept="image/*" multiple>
                <label class="custom-file-label" for="customFile">Escolher arquivo</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Anexar Imagem</button>
        </form>

        <?php
        // Mostra as imagens existentes
        if (!empty($imagens)) {
            echo '<div class="row">';
            foreach ($imagens as $imagem) {
                echo '<div class="col-md-4 image-container">';
                echo '<img src="' . $imagem['img'] . '" alt="Pré-visualização da imagem">';
                echo '<form method="post" action="excluir_imagem.php?codigo=' . $codigo . '" class="delete-form">';
                echo '<input type="hidden" name="deleteImage" value="' . $imagem['img'] . '">';
                echo '<button type="submit" class="btn btn-danger">Excluir</button>';
                echo '</form>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
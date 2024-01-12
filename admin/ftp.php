<?php

function pre_r($array){
echo '<pre>';
print_r($array);
echo "</pre>";

}
function clean_scandir($dir){
    return array_values(array_diff(scandir($dir),array('..','.')));
}

function clean_ftp_nlist($ftp_connection, $server_dir){
    $files_on_server = ftp_nlist($ftp_connection,$server_dir);
    return array_values(array_diff($files_on_server,array('.','..')));
}

function upload_files($ftp_connection,$local_dir,$server_dir,$nome_arquivo){

    $files_on_server = clean_ftp_nlist($ftp_connection, $server_dir);

    if(!in_array($nome_arquivo, $files_on_server))
    {
        if(ftp_put($ftp_connection,"$server_dir/$nome_arquivo",$local_dir, FTP_BINARY)){

            echo "Arquivo $nome_arquivo Upload efetuado com sucesso<br>";

        }else{
            echo "Problema para fazer upload do arquivo $nome_arquivo <br>";
        }
    }else{
        echo "Arquivo $nome_arquivo existente no FTP<br>";
    }

    $files_on_server = clean_ftp_nlist($ftp_connection, $server_dir);
    ftp_close($ftp_connection);
    return $files_on_server;
}
?>
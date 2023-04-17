<?php

class Upload
{

    public function excluirImagens()
    {
        $dir = '../img-ppt/';

// abre o diretório para leitura
        if ($handle = opendir($dir)) {
            // percorre todos os arquivos da pasta
            while (false !== ($file = readdir($handle))) {
                // verifica se o arquivo é uma imagem
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), array('jpg', 'jpeg', 'png', 'gif'))) {
                    // remove o arquivo
                    unlink($dir . $file);
                }
            }
            closedir($handle); // fecha o diretório
        }
    }
}
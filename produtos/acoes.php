<?php

    require('../database/conexao.php');

    switch ($_POST["acao"]) {
        case 'inserir':
            
            /*Tratamento da imagem para upload*/

            $nomeArquivo = $_FILES["foto"]["name"];

            /*Recuperar a extensão do arquivo */

            $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

            /*Definir um novo nome para o arquivo de imagem*/

            $novoNome = md5(microtime()) . "." . $extensao;

            // echo $nomeArquivo;
            // echo '<br>';
            // echo $novoNome;

            move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNome");

            break;
        
        default:
            # code...
            break;
    }

?>
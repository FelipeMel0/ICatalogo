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

            /*Recebimento dos dados */

            $descricao = $_POST["descricao"];
            $peso = $_POST["peso"];
            $quantidade = $_POST["quantidade"];
            $cor = $_POST["cor"];
            $tamanho = $_POST["tamanho"];
            $valor = $_POST["valor"];
            $desconto = $_POST["desconto"];
            $categoriaId = $_POST["categoria"];

            /*Criação da insução sql de inserção */

            $sql = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) 
            VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, '$novoNome', $categoriaId)";

            /*Execução do SQL de inserção */

            $resultado = mysqli_query($conexao, $sql);

            header('location: index.php');

            break;
        
        default:
            # code...
            break;
    }

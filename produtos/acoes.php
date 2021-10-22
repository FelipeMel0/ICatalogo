<?php

session_start();

require('../database/conexao.php');

function validaCampos()
{

    //Array de mensagens de erro
    $erros = [];

    //Validação de descrição
    if ($_POST["descricao"] == "" || !isset($_POST["descricao"])) {

        $erros[] = "O campo descrição é um campo obrigatório";
    }

    //Validação de peso
    if ($_POST["peso"] == "" || !isset($_POST["peso"])) {

        $erros[] = "O campo peso é um campo obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))) {

        $erros[] = "O campo peso deve ser um número";
    }

    //Validação de quantidade
    if ($_POST["quantidade"] == "" || !isset($_POST["quantidade"])) {

        $erros[] = "O campo quantidade é um campo obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))) {

        $erros[] = "O campo quantidade deve ser um número";
    }

    //Validação de cor
    if ($_POST["cor"] == "" || !isset($_POST["cor"])) {

        $erros[] = "O campo cor é um campo obrigatório";
    }

    //Validação de tamanho
    if ($_POST["tamanho"] == "" || !isset($_POST["tamanho"])) {

        $erros[] = "O campo tamanho é um campo obrigatório";
    }

    //Validação de valor
    if ($_POST["valor"] == "" || !isset($_POST["valor"])) {

        $erros[] = "O campo valor é um campo obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))) {

        $erros[] = "O campo valor deve ser um número";
    }

    //Validação de desconto
    if ($_POST["desconto"] == "" || !isset($_POST["desconto"])) {

        $erros[] = "O campo desconto é um campo obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["desconto"]))) {

        $erros[] = "O campo desconto deve ser um número";
    }

    //Validação de categoria
    if ($_POST["categoria"] == "" || !isset($_POST["categoria"])) {

        $erros[] = "O campo categoria é um campo obrigatório";
    }

    //Validação da imagem
    if ($_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE) {

        $erros[] = "O arquivo precisa ser uma imagem";
    } else {

        $imagemInfos = getimagesize($_FILES["foto"]["tmp"]);

        if ($_FILES["fotos"]["size"] > 1024 * 1024 * 2) {

            $erros[] = "O arquivo não pode ser maior que 2MB";
        }

        $width = $imagemInfos[0];
        $height = $imagemInfos[1];

        if ($width != $height) {

            $erros[] = "A imagem precisa ser quadradona";
        }
    }

    return $erros;
}

switch ($_POST["acao"]) {
    case 'inserir':

        $erros = validaCampos();

        if (count($erros) > 0) {

            $_SESSION["erros"] = $erros;

            header("location: novo/index.php");

            exit;
        }

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

    case 'deletar':

        $produtoId = $_POST["produtoId"];

        $sql = "SELECT imagem FROM tbl_produto WHERE id = $produtoId";

        // $sql = "DELETE FROM tbl_produto WHERE id = $produtoId";

        $resultado = mysqli_query($conexao, $sql);

        $produto = mysqli_fetch_array($resultado);

        $sql = "DELETE FROM tbl_produto WHERE id = $produtoId";

        $resultado = mysqli_query($conexao, $sql);

        unlink("./fotos/" . $produto["imagem"]);

        header('location: index.php');

        break;

    case 'editar':

        /*Atualizando a imagem do produto */

        $produtoId = $_POST["produtoId"];

        if ($_FILES["foto"]["error"] != UPLOAD_ERR_NO_FILE) {

            $sqlImagem = "SELECT imagem FROM tbl_produto WHERE id = $produtoId";

            $resultado = mysqli_query($conexao, $sqlImagem);
            $produto = mysqli_fetch_array($resultado);

            //Exclusão da imagem (arquivo) antiga da pasta

            unlink("./fotos/" . $produto["imagem"]);

            $nomeArquivo = $_FILES["foto"]["name"];

            $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

            $novoNomeArquivo = md5(microtime()) . "." . $extensao;

            move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNomeArquivo");
        }

        /* Captura os dados de texto e de número */

        $descricao = $_POST["descricao"];

        $peso = str_replace(".", "", $_POST["peso"]);
        $peso = str_replace(",", ".", $peso);

        $valor = str_replace(".", "", $_POST["valor"]);
        $valor = str_replace(",", ".", $valor);

        $quantidade = str_replace(".", "", $_POST["quantidade"]);
        $quantidade = str_replace(",", ".", $quantidade);

        // $quantidade = $_POST["quantidade"];

        $cor = $_POST["cor"];

        $tamanho = $_POST["tamanho"];

        // $desconto = $_POST["desconto"];
        $desconto = str_replace(".", "", $_POST["desconto"]);
        $desconto = str_replace(",", ".", $desconto);

        $categoriaId = $_POST["categoria"];

        $sqlUpdate = "UPDATE tbl_produto SET descricao = '$descricao', peso = $peso,
                                            quantidade = $quantidade, cor = '$cor',
                                            tamanho = '$tamanho', valor = $valor,
                                            desconto = $desconto, categoria_id = $categoriaId";

        /*Verifica se tem imagem nova para atualizar*/
        $sqlUpdate .= isset($novoNomeArquivo) ? " , imagem = '$novoNomeArquivo'" : "";

        $sqlUpdate .= "WHERE id = $produtoId";

        $resultado = mysqli_query($conexao, $sqlUpdate);

        // echo $sqlUpdate; exit;

        header("location: index.php");

        break;

    default:
        # code...
        break;
}

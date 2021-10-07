<?php
session_start();

/*Conexão com o banco de dados*/
require("../database/conexao.php");

/*Função de validação */
function validaCampos()
{

    $erros = [];

    if (!isset($_POST['descricao']) || $_POST['descricao'] == "") {

        $erros[] = "O campo de descrição é de preenchimento obrigatório";
    }

    return $erros;
}

/*Tratamento dos dados vindos do formulário

- tipos da ação
- execução dos processos da ação solicitada*/
switch ($_POST["acao"]) {

    case 'inserir':

        $erros = validaCampos();

        if (count($erros) > 0) {

            $_SESSION["erros"] = $erros;

            header("location: index.php");

            exit();
        }

        // echo "inserir";
        // exit;
        $descricao = $_POST["descricao"];

        $sql = "INSERT INTO tbl_categoria (descricao) VALUES('$descricao')";

        // echo $sql; exit;

        /*
        mysqli_query parâmetros:
        1 - Uma conexão aberta e válida
        2 - Uma instrução sql válida 
        */

        $resultado = mysqli_query($conexao, $sql);

        header("location: index.php");

        // echo "<pre>";
        // var_dump($resultado);
        // echo "</pre>";

        break;

    case 'deletar':

        $categoriaID = $_POST['categoriaId'];

        // echo $categoriaID;exit;

        $sql = "DELETE FROM tbl_categoria WHERE id = $categoriaID";

        $resultado = mysqli_query($conexao, $sql);

        header('location: index.php');

        break;

    case 'editar':

        $id = $_POST["id"];
        $descricao = $_POST["descricao"];

        $sql = "UPDATE tbl_categoria SET descricao = '$descricao' WHERE id = $id";

        $resultado = mysqli_query($conexao, $sql);

        header('location: index.php');

        break;

    default:
        # code...
        break;
}

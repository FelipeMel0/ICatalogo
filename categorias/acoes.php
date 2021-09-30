<?php

/*Conexão com o banco de dados*/
require("../database/conexao.php");

/*Tratamento dos dados vindos do formulário

- tipos da ação
- execução dos processos da ação solicitada*/
switch ($_POST["acao"]) {
    case 'inserir':
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

    default:
        # code...
        break;
}

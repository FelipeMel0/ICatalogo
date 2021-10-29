<?php

session_start();

require_once('../../database/conexao.php');

function realizarLogin($usuario, $senha, $conexao){

    $sql = "SELECT * FROM tbl_administrador
            WHERE usuario = '$usuario' AND senha = '$senha'";

    $resultado =  mysqli_query($conexao, $sql);

    $dadosUsuario = mysqli_fetch_array($resultado);

    if (isset($dadosUsuario['usuario']) && isset($dadosUsuario['senha']) && password_verify($senha, $dadosUsuario['senha'])) {

        // echo "Narutinho";

        $_SESSION["usuarioId"] = $dadosUsuario["id"];
        $_SESSION["nome"] = $dadosUsuario["nome"];

        header("location: ../../produtos/index.php");

    } else {
        session_destroy();
        header("location: ../../produtos/index.php");
    }
}


switch ($_POST["acao"]) {
    case 'login':
        
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        realizarLogin($usuario, $senha, $conexao);

        break;

    case 'logout':

        // echo "Vc jogou fora... o amor que eu te dei... 😞😞";
        session_destroy();
        header("location: ../../produtos/index.php");

        break; 

    default:
        #code
        break;
}




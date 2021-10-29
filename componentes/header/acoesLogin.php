<?php

session_start();

require_once('../../database/conexao.php');

function realizarLogin($usuario, $senha, $conexao){

    $sql = "SELECT * FROM tbl_administrador
            WHERE usuario = '$usuario' AND senha = '$senha'";

    $resultado =  mysqli_query($conexao, $sql);

    $dadosUsuario = mysqli_fetch_array($resultado);

    if (isset($dadosUsuario['usuario']) || isset($dadosUsuario['senha'])) {

        // echo "Narutinho";

        $_SESSION["usuarioId"] = $dadosUsuario["id"];
        $_SESSION["nome"] = $dadosUsuario["nome"];

        // echo $_SESSION["usuarioId"];
        // echo $_SESSION["nome"];

        header("location: ../../produtos/index.php");

    } else {
        echo "Burro";
        //session_destroy() e manda para o index de novo
    }
}


switch ($_POST["acao"]) {
    case 'login':
        
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        realizarLogin('CelsoLinux', 'linux123', $conexao);

        break;

    case 'logout':

        echo "Vc jogou fora... o amor que te dei... 😞😞";

        break; 

    default:
        #code
        break;
}




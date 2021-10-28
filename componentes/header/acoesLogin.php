<?php

// session_start();

require_once('../../database/conexao.php');

function realizarLogin($usuario, $senha, $conexao) {

    $sql = "SELECT * FROM tbl_administrador
            WHERE usuario = '$usuario' AND senha = '$senha'";

    $resultado =  mysqli_query($conexao, $sql);

    $dadosUsuario = mysqli_fetch_array($resultado);

    if (isset($dadosUsuario['usuario']) || isset($dadosUsuario['senha'])) {

        echo "Narutinho";
        //armazenar variáveis de sessão e redirecionar para o index

    } else{
        echo "Burro";
        //session_destroy() e manda para o index de novo
    }

}

realizarLogin('MarcelEntidade', 'teste123', $conexao);

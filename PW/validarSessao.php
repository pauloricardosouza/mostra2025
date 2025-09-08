<?php
    session_start(); //Inicia uma sessão

    if(!isset($_SESSION['logado']) || $_SESSION['logado'] === false){ //Verifica de há sessão iniciada
        header('location:formLogin.php?pagina=formLogin&erroLogin=naoLogado');
    }else{
        $tipoUsuario = $_SESSION['tipoUsuario'];
        if(($_SESSION['tipoUsuario'] != "administrador")){
            header('location:formLogin.php?pagina=formLogin&erroLogin=acessoProibido');
        }
    }

?>

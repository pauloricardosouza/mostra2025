<?php
    session_start();
    session_unset();
    session_destroy();

    header('location:formLogin.php?pagina=formLogin');
    exit();
?>
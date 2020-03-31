<?php
    require_once("Banco_class.php");
    session_start();
    session_unset();
    $comando = new Banco();
    $comando->logout();
?>
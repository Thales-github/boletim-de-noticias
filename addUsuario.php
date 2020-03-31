<?php
    require_once("Banco_class.php");

    $comando = new Banco();
    $comando->adionarUsuario($_POST["txtLogin"], $_POST["txtEmail"], $_POST["txtSenha"]);
?>
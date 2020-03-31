<?php
    require_once('Banco_class.php');
    
    $comando = new Banco();
    $comando->verificaUsuario($_POST["txtLogin"], $_POST["txtSenha"]);
?>
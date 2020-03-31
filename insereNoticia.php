<?php
session_start();
    require_once('../php/Banco_class.php');
    $comando = new Banco();

    $comando->novaNoticia(
        $_POST["txtTitulo"],
        $_POST["txtSubTitulo"],
        $_SESSION["nomeUsuario"],
        $_FILES["txtImagem"],
        $_POST["txtConteudo"],
        $_POST["cmbCategoria"]
    );
?>
<?php
require_once('Banco_class.php');

    $comando = new Banco();

    $comando->gravarMensagemDeContato($_POST["txtNome"],$_POST["txtEmail"],$_POST["txtMensagem"],$_POST["txtTelefone"]);
?>
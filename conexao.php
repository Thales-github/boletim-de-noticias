<?php
    // dados localhost
    $banco = 'mysql:dbname=seu banco de dados;host=seu servidor;charset=utf8';
    $usuario = 'seu usuario';
    $senha = 'sua senha';
    
    $conexao = new PDO($banco,$usuario,$senha);
?>
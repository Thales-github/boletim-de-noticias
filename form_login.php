<?php
 if (isset($_GET["erro"])) {
    $erro = $_GET["erro"];

    if ($erro == 1) {
        echo "<script>alert('Login ou Senha inválidos!!!');</script>";
    }elseif ($erro == 2) {
        echo "<script>alert('Erro aoverificar suas credencias, por favor tente novamente');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body{background-color: rgb(131, 91, 160);}
        .navbar{background-color: black;}
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg sticky-top mb-3 navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand col-4 col-sm-4 col-md-4 text-white" href="../index.php">Boletim de Notícias</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link ml-5 text-white" href="form_contato.php">Contate-nos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ml-5 text-white" id="btnEntrar" href="form_login.php">Entrar</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white ml-5" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categorias
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php 
                            try {
                                $conexao = new PDO("mysql:host=seu servidor;dbname=nome do seu banco de dados;charset=utf8", "nome do usuario","nome da senha");
                            } catch (PDOException $e) {
                                echo "erro ao conectar no banco de dados, por favor contate o administrador do sistema";
                                exit();
                            }
                            $comando = $conexao->prepare("select distinct notCategoria from quebradaNews_noticias where datediff(CURRENT_DATE,notDtPublicacao) <= 30");
                            $comando->execute();
                            while($categoria = $comando->fetch(PDO::FETCH_ASSOC)){
                                //var_dump($categoria);
                                echo"<a class='dropdown-item' href='noticias_filtradas.php?categoria=" . $categoria["notCategoria"] . "'>" . $categoria["notCategoria"] . "</a>";
                            } 
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container-fluid col-12 col-sm-12 col-md-8">
        
        <div class="card col-12 col-sm-12 col-md-12 mt-4">
            <h3 class="titulo mt-2 text-center">Bem Vindo Escritor(a)</h3>  


            <!--action="validaLogin.php" method="POST"-->
            <form action="validaLogin.php" method="POST" class="form-group" onSubmit="validaCampos(); return false;" autocomplete="off">
                <input id="Login" type="text" name="txtLogin" class="form-control mt-2 col-12 col-sm-12 col-md-12" placeholder="Login ou Email*" required>
                <input id="Senha" type="password" name="txtSenha" class="form-control mt-2 col-12 col-sm-12 col-md-12" placeholder="Senha*" required>
                <div class="row">
                    <button type="submit" class="btn ml-4 btn-primary mt-2">Entrar</button>
                    <a class="btn btn-warning ml-2 mt-2" href="../index.php">Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="../javascript/eventos.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
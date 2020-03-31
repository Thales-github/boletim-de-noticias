<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <title>Boletim de Notícias</title>
    <style>
        .navbar{background-color: black;}
        body{background-color: rgb(131, 91, 160);}
        img{max-height: 350px;}
        footer{
           background-color: black;
           color: white;
       }
        @media screen and (min-width: 576px){
            .card{margin-left: 60px;}
        }
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

    <?php
        if (!isset($_GET["codigoNoticia"])) {
            echo "Erro ao buscar código da notícia, por favor contate o administrador do sistema";
            exit();
        }else {
            $codigoNoticia = $_GET["codigoNoticia"];
            try {
                $conexao = new PDO("mysql:host=seu servidor;dbname=nome do seu banco de dados;charset=utf8", "nome do usuario","nome da senha");
            } catch (PDOException $e) {
                echo "erro ao conectar no banco de dados, por favor contate o administrador do sistema";
                exit();
            }
            $comando = $conexao->prepare("select notTitulo, notSubTitulo,notAutor, date_format(notDtPublicacao, '%d/%c/%Y %H:%i') 	as notDtPublicacao, notImagem, notConteudo 
                from quebradaNews_noticias
                    where notCodigo = " . $codigoNoticia);
                //var_dump($comando);
            if($comando->execute()){
                $linha = $comando->fetch(PDO::FETCH_ASSOC);
                echo"<div class='container-fluid mb-3'>";
                echo"   <div class='col-12 col-sm-11 col-md-11'>";
                echo"       <div class='card'>";
                echo"               <div class='card-body'>";
                echo"                   <h3 class='card-title'>" . $linha["notTitulo"] . "</h3>";
                echo"                   <h5 class=''>" . $linha["notSubTitulo"] . "</h5>";
                echo"               </div>";
                echo"               <img src='imagens/" . $linha["notImagem"] . "'class='card-img-top col-12 col-sm-12 col-md-12' alt='...'>";
                echo"               <i class='mb-1 ml-3 mt-3'>Escrito por " . $linha["notAutor"] . "</i>";
                echo"               <label class='ml-3'>" . $linha["notConteudo"] . "</label>";
                echo"               <a class='btn-link ml-3 mb-3' href='../index.php'>Ver outras notícias...</a>";
                echo"       </div>";
                echo"   </div>";
                echo"</div>";
            }
        }
    ?>
    <footer class="col-12 mt-3 text-center">Desenvolvido por SystemForWeb©</footer>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" 
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" 
    crossorigin="anonymous"></script>
</body>
</html>
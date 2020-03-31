<?php
    if (!isset($_GET["categoria"])) {
        header("Location: ../index.php");
    }else {
        echo"";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="sortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <title>Boletim de Notícias</title>
    <style>
        .navbar{background-color: black;}
        body{background-color: rgb(131, 91, 160);}
        .noticia{
           border: 1px solid grey;
           display: inline;
           padding: 30px 10px;
           background-color: rgb(215, 175, 224);
           -moz-transition: all 0.3s;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
       }
       .noticia:hover{
        -moz-transform: scale(1.1);
	    -webkit-transform: scale(1.1);
	    transform: scale(1.1);
        cursor: pointer;
       }
       .titulo{color: black;}
       .titulo:hover{
        color: black;
        text-decoration: none;
       }
         /* aplica ainhamento à esquerda se a tela chegar na classe sm do bootstrap */
         @media screen and (min-width: 576px){
            .alinhamento{margin-left: 80px;}
            .noticia{box-shadow: 5px -5px 8px black;}
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
        try {
            $conexao = new PDO("mysql:host=seu servidor;dbname=nome do seu banco de dados;charset=utf8", "nome do usuario","nome da senha");
        } catch (PDOException $e) {
            echo "erro ao conectar no banco de dados, por favor contate o administrador do sistema";
            exit();
        }
        $categoria = $_GET["categoria"];
        $comando = $conexao->prepare("select notCodigo,notTitulo, notSubTitulo,notAutor, date_format(notDtPublicacao, '%d/%m/%Y') as notDtPublicacao, notImagem, notConteudo 
                                    from quebradaNews_noticias
                                        where notCategoria = '" . $categoria .
                                            "' and datediff(CURRENT_DATE,notDtPublicacao) <= 30 ORDER BY notCodigo DESC limit 30");
                                            //var_dump($comando);
        if($comando->execute()){
            //echo "executou";
            $qtdLinhasRetornadas = $comando->rowCount();
            //var_dump($qtdLinhasRetornadas);
            
            if($qtdLinhasRetornadas > 0){
                //echo "entrou no teste";
                
                echo "<div class='container-fluid mt-3'>";
                echo "<h2>Últimas Notícias...</h2>";
                echo "  <div class='alinhamento'>";
                echo "      <div class='row'>";
                while($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                    
                    echo "      <label onclick='recebeClickNoticia(this)' class='noticia col-12 col-sm-5 ml-sm-3 col-md-3 ml-md-4 mt-3 text-center'>";
                    echo "          <a class='titulo' href='noticia.php?codigoNoticia=" . $linha["notCodigo"] . "'><h3>" . $linha["notTitulo"] . "</h3></a><br />";
                    echo "          <strong class''>" . $linha["notSubTitulo"] . "</strong><br />";
                    echo "          <label class''>Por " . $linha["notAutor"] . " em " . $linha["notDtPublicacao"] ."</label><br />";
                    //echo "          <a class='continuarLendo' href='php/noticia.php?codigoNoticia=" . $linha["notCodigo"] . "'>Continuar lendo...</a>";
                    echo "      </label>";
                   //echo '<img src="php/imagens/' . $linha["notImagem"] . '">';
                }
                echo "      </div>";
                echo "  </div>";
                echo "</div>";
            }else {
                echo "<h1>Sem notícias no momento</h1>";
            } 
        }else {
            echo "<h1>Não foi possível consultar o banco de dados, por favor contate o administrador do sistema</h1>";
        }
    ?>

    <script src="../javascript/eventos.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
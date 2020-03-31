<?php
session_start();

    if (!isset($_SESSION["nomeUsuario"])) {
        echo "<script>document.location.href='form_login.php?erro=1'</script>";
    }else {
        $usuario = $_SESSION["nomeUsuario"];
    }
    require_once("Banco_class.php");

    if (isset($_GET["sucesso"])) {
        $erro = $_GET["sucesso"];
        
        if ($sucesso == 1) {
            echo "<script>alert('Notícia postada com sucesso');</script>";
        }else {
            echo "<script>alert('Erro ao postar notícia, tente novamente mais tarde oucontate o administrador do sistema');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nova Notícia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .container>.form-group {margin-left: 1%;}
        body {background-color: rgb(131, 91, 160);}
        .escondeBotao{display: none;}
        label{font-size: 20px;}
    </style>
</head>

<body>
<a class="btn btn-secondary btn-lg mt-3 ml-3" href="logout.php">Sair</a>

    <div class="container">
        <form action="insereNoticia.php" method="POST" class="form-group col-12 col-sm-12 col-md-12"
            enctype="multipart/form-data" autocomplete="off">
            <h3 class="mt-5"><?php echo "Bem Vindo(a) " . $usuario; ?></h3>
            <input type="text" maxlength=100 class="form-control mt-3" name="txtTitulo" placeholder="Título da notícia*" required>
            <input type="text" maxlength=100 class="form-control mt-2" name="txtSubTitulo" placeholder="Subtítulo da notícia*"
                required>
                <label>Qual é a categoria da notícia?</label><br />
                    <select class="form-control"  name="cmbCategoria">
                         <option value="Tecnologia">Tecnologia</option>
                         <option value="Desastres">Desastres</option>
                         <option value="Música">Música</option>
                         <option value="Política">Política</option>
                         <option value="Cultura geek">Cultura geek</option>
                         <option value="Entretenimento">Entretenimento</option>
                         <option value="Mundo">Mundo</option>
                         <option value="Economia">Economia</option>
                         <option value="Esportes">Esportes</option>
                         <option value="Cultura">Cultura</option>
                         <option value="Fofocas">Fofocas</option>
                         <option value="Ciência">Ciência</option>
                         <option value="Teevisão">Televisão</option>
                         <option value="Saúde e bem estar">Saúde e bem estar</option>
                         <option value="Beleza">Beleza</option>
                         <option value="Alternativo">Alternativo</option>
                         <option value="Humor">Humor</option>
                         <option value="Gastronomia">Gastronomia</option>
                         <option value="História">História</option>
                         <option value="Viagens">Viagens</option>
                         <option value="Educação">Educação</option>
                         <option value="Educação">Criminalidade</option>
                    </select>

            <label class="mt-2">Imagem da publicação</label>
            <input type="file" class="form-control col-12 col-sm-5 col-md-12" name="txtImagem" required aria-describedby="inputGroupFileAddon">

            <textarea type="text" class="form-control mt-2" rows="10" name="txtConteudo"
                placeholder="Conteúdo da notícia..." required></textarea>
            <div class="row">
                <button class="btn btn-primary btn-lg mt-2 col-5 ml-5" type="submit">Postar</button>
                <a class="<?= $_SESSION['nivelUsuario'] == 1? 'btn btn-secondary btn-lg mt-2 col-5 ml-4': 'escondeBotao' ?>" href="form_add_usuarios.php">Adicionar Usuário</a>
            </div>
        </form>
    </div>
</body>

</html>
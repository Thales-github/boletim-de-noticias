<?php
session_start();
if (!isset($_SESSION['nomeUsuario'])) {
  echo "<script>document.location.href='form_login.php'</script>";
} elseif($_SESSION['nivelUsuario'] != 1) {
    echo "<script>document.location.href='novaNoticia.php'</script>";
}
?>
  <html>
    <head>
      <title>Adicionar usuários</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
          body{background-color: rgb(101, 82, 119);}
          .form-group{
            background-color: rgb(121, 108, 133);
            margin-top: 80px;
            border: 5px solid grey;
            border-radius: 10px;
            padding: 20px;
        }
        label{
          margin-top: 20px;
        }
        .container{
          margin-left: 130px;
        }
        </style>
    </head>
    <body>
        <div class="container">
          <form class="form-group mt-5 col-12 col-sm-12 col-md-10" method="POST" action="addUsuario.php "autocomplete="off">
            <div class="">
              <label>Login</label>
              <input type="text" class="form-control" name="txtLogin" aria-describedby="emailHelp" placeholder="Login*" required>
            </div>
            <div class="">
              <label>Email</label>
              <input type="email" class="form-control" name="txtEmail" placeholder="E-mail*" required>
            </div>   
            <div class="">
              <label>Senha</label>
              <input type="password" class="form-control" name="txtSenha" placeholder="Senha*" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Adicionar</button>
            <a class="btn btn-warning ml-2 mt-2" href="novaNoticia.php">Voltar</a>
          </form>
        </div>
    </body>
</html>
<?php
class Banco{

    private $conexao;
    private $banco = "mysql:host=seu servidor;dbname=nome do seu banco de dados;charset=utf8";
    private $usuario = "nome do usuario";
    private $senha = "sua senha";
    
    public function getConexao(){
        return $this->conexao;
    }

    public function setConexao($valor){
        $this->conexao = $valor;
    }

    public function getBanco(){
        return $this->banco;
    }

    public function setBanco($valor){
        $this->banco = $valor;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setUsuario($valor){
        $this->usuario = $valor;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($valor){
        $this->senha = $valor;
    }

    public function __construct(){
            
        $banco = $this->getBanco();
        $usuario = $this->getUsuario();
        $senha = $this->getSenha();

       try {
            $conexao = new PDO($banco,$usuario,$senha);
            $this->setConexao($conexao);            
        } catch (PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
        }
    }
    
    public function adionarUsuario($login, $email, $senha){
        
        $conexao = $this->getConexao();
        $comando = $conexao->prepare("select usuLogin, usuEmail 
            from quebradaNews_usuarios 
                where usuLogin = '" . $login . "' or usuEmail = '" . $email . "'");

        $resultado = $comando->fetch(PDO::FETCH_ASSOC);

        if ($resultado["usuLogin"] == $login || $resultado["usuEmail"] == $email) {
            
            echo "<script>alert('Login ou e-mail já existe, tente novamente com novas informações');</script>";
            echo "<script>window.location.href='form_add_usuarios.php';</script>";
        }else {
            
            $comando = $conexao->prepare("insert into quebradaNews_usuarios 
                (usuNivel,usuLogin,usuEmail,usuSenha) values(2,:LOGIN, :EMAIL, :SENHA)");
            
            $comando->bindParam(":LOGIN",$login);
            $comando->bindParam(":EMAIL",$email);
            $comando->bindParam(":SENHA",$senha);

            if ($comando->execute()) {
                echo "<script>alert('Usuário cadastrado com sucesso no sistema!');</script>";
                echo "<script>window.location.href='form_add_usuarios.php';</script>";
            } else {
                echo "<script>alert('Usuário não cadastrado no sistema!');</script>";
                echo "<script>window.location.href='form_add_usuarios.php';</script>";
            }
        }
    }

    public function verificaUsuario($usuario, $senha){

        $conexao = $this->getConexao();
        $comando = $conexao->prepare("select usuCodigo, usuNivel,usuLogin, usuSenha, usuEmail from quebradaNews_usuarios where usuSenha = md5('" . $senha . "') and '" . $usuario . "' in (usuLogin,usuEmail)");

        if ($comando->execute()) {
            $resultado = $comando; 
            $linha = $resultado->fetch(PDO::FETCH_ASSOC);

            if ($usuario == $linha['usuLogin'] || $usuario == $linha['usuEmail']) {
                 if (md5($senha) == $linha['usuSenha']) { 
                      session_start();
                      $_SESSION['codUsuario'] = $linha['usuCodigo'];
                      $_SESSION['nomeUsuario'] = $linha['usuLogin'];
                      $_SESSION['nivelUsuario'] = $linha['usuNivel'];
                      echo "<script>window.location.href='novaNoticia.php'</script>";
                 }else {
                      echo "<script>window.location.href='form_login.php?erro=1'</script>";
                 }
            }else {
                 echo "<script>window.location.href='form_login.php?erro=1'</script>";
            }
       }else {
            echo "<script>window.location.href='form_login.php?erro=2'</script>";
       }
    }

    public function gravarImagem($imagem){

        $diretorio = "imagens";
        if(is_dir($diretorio)){
            move_uploaded_file($imagem['tmp_name'], "imagens/" . $imagem['name']);
            echo "<script>window.location.href='novaNoticia.php'</script>";
        }else {
            mkdir($diretorio);
            move_uploaded_file($imagem['tmp_name'], "imagens/" . $imagem['name']);
        }
    }

    public function novaNoticia($titulo,$subTitulo,$autor,$imagem,$conteudo,$categoria){

        $conexao = $this->getConexao();
        $comando = $conexao->prepare("insert into quebradaNews_noticias (notTitulo,notSubTitulo,notAutor,notDtPublicacao,notCategoria,notImagem,notConteudo)
            values(:TITULO,:SUBTITULO,:AUTOR, now(),:CATEGORIA,:IMAGEM, :CONTEUDO)");

        $comando->bindParam(":TITULO", $titulo);
        $comando->bindParam(":SUBTITULO",$subTitulo);
        $comando->bindParam(":AUTOR",$autor);
        $comando->bindParam(":CATEGORIA",$categoria);
        $comando->bindParam(":IMAGEM",$imagem["name"]);
        $comando->bindParam(":CONTEUDO",$conteudo);
        
        if($comando->execute()){
           $this->gravarImagem($imagem);
        }else {
            echo "<script>window.location.href='novaNoticia.php?sucesso=1'</script>";
        }
    }
    
    public function gravarMensagemDeContato($nome,$email,$telefone,$mensagem){
        
        $conexao = $this->getConexao();
        $comando = $conexao->prepare("insert into quebradaNews_mensagens (msgNome, msgEmail, msgTelefone, msgMensagem)
            values(:NOME,:EMAIL,:TELEFONE,:MENSAGEM)");

        $comando->bindParam(":NOME", $nome);
        $comando->bindParam(":EMAIL", $email);
        $comando->bindParam(":TELEFONE", $telefone);
        $comando->bindParam(":MENSAGEM", $mensagem);

       if ($comando->execute()) {
            echo"<script>alert('Mensagem enviada com sucesso!');</script>";
            echo "<script>window.location.href='../index.php';</script>";
        }else {
            echo"<script>alert('Falha ao enviar mensagem!, tente novamente ou contate o administrador do sistema');</script>";
            echo "<script>window.location.href='../index.php';</script>";
        }
    }

    public function logout(){
        echo "<script>document.location.href='../index.php';</script>";
    }
}
?>
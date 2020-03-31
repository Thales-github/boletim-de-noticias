
// ---------------------- eventos de redirecionamento das notícias -----------------------------
function redirecionaParaNoticia(link) {

    window.location.href = link;

}
function recuperaLinkDaNoticia(container) {
    /* pegando primeiro elemento filho do container passado como parâmetro para não pegar 
    sempre o código da notícia do primeiro container e sim pegar o codigo 
    notícia do painel em que o evento ocorreu*/
    let link = container.firstElementChild.href;

    redirecionaParaNoticia(link);
}
// --------------- fim eventos de redirecionamento das notícias -------------------------


//--------------------------- eventos do formuário de login -----------------------------

function validaCampos() {

    let formulario = document.querySelector(".form-group");

    let login = document.querySelector("#Login").value;
    let senha = document.querySelector("#Senha").value;

    if (login == "") {

        console.error("Preencha o campo Login!!!");
        return false;

    } else if (senha == "") {

        console.error("Preencha o campo Senha!!!");
        return false;

    } else {
        
        login.replace(/[ÁÉÍÓÚÃÕáéíóúãõ=]/g, "");
        senha.replace(/[ÁÉÍÓÚÃÕáéíóúãõ=]/g, "");
        /* utilizando método submit para enviar o formulário
         após validar se os campos não estão vazios e retirar
        os caracteres especiais*/
        formulario.submit();
    }
}
//---------------------- fim eventos do formuário de login ---------------------
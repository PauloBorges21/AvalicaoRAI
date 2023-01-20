const tbody = document.querySelector(".listar-pergunta");

const listarPerguntas = async (pagina) => {
    const dados = await fetch("./inc/questionario1-pag.php?pagina=" + pagina);
    const resposta = await dados.text();
    tbody.innerHTML = resposta;

}


listarPerguntas(1);
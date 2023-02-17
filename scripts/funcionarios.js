function buscaFuncionario() {
    //var funcionario = document.querySelector("#func");
    var funcionario = $("#func").val();
    let sanitize = splitHash(funcionario);

    $.ajax({
        url: "ajax/ajax_get_funcionario.php",
        method: "POST",
        data: { id: sanitize },
        dataType: "JSON",
        success: function (jsonStr) {
            dadosFuncionario(jsonStr);
        }
    });
}

function dadosFuncionario(jsonStr) {    
    $('#nomeFunc').text('Olá ' + jsonStr['NOME_FUNC']);
    $('#departamentoFunc').text('Departamento: ' + jsonStr['NOME_DEPARTAMENTO']);
    $('#gestorFunc').text('Gestor: ' + jsonStr['NOME_GERENTE']);
}

function splitHash(hash) {
    let sanitize = hash.split("b90a40fa2006a43f6844feab08f23b7bf");
    return sanitize[1];
}
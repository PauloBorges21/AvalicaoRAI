function buscaFuncionario() {
    //var funcionario = document.querySelector("#func");
    var funcionario = $("#func").val();
    console.log(funcionario);
    let sanitize =  splitHash(funcionario);

    $.ajax({
        url: "ajax/ajax_get_funcionario.php",
        method: "POST",
        data: { id: sanitize},
            dataType: "JSON",
            success: function (jsonStr) {                
            dadosFuncionario(jsonStr);
            }
    });
}

function dadosFuncionario(jsonStr)
{
    
    $('#nomeFunc').text('Olá '+jsonStr['Funcionario']);
    $('#departamentoFunc').text('Departamento: '+jsonStr['Departamento']);
    $('#gestorFunc').text('Gestor: '+jsonStr['Gestor']);
}

function splitHash(hash) {
    console.log(hash);
    let sanitize = hash.split("b90a40fa2006a43f6844feab08f23b7bf");
    return sanitize[1];
}
function buscaFuncionario() {
    var funcionario = document.getElementById('func').value; 
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
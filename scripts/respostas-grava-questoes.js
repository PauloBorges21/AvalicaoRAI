
$(document).ready(function () {
    buscaFuncionario();
})

var formDisabled;
var buttomDisabled;
function splitHash(hash) {
    let sanitize = hash.split("b90a40fa2006a43f6844feab08f23b7bf");
    return sanitize[1];
}
var result = {};
var resultFormFull = {};
//var form = document.querySelector('#form');
var botao = document.querySelectorAll('.sub__mit');
for (let i = 0; i < botao.length; i++) {
    botao[i].addEventListener('click', function (event) {
        event.preventDefault()        
        itemClick = event.target;
        itemGroup = itemClick.parentElement.parentElement;
        const q = $('#questionario').val();
        var quest = {
            idpergunta: itemGroup.querySelector('.pergunta').value,
            idusuario: itemGroup.querySelector('input[name="hash-rai"]').value
        };
        var form = Array.from(itemGroup.querySelectorAll("input:checked"));
        formDisabled = Array.from(itemGroup.querySelectorAll("input[type='radio']"));

        $(form).each(function (index, element) {
            var name = $(element).attr('name');
            var value = $(element).val();
            result[name] = value;
        });
        const idUsuario = splitHash($('#func').val());
        if (q == 1) {
            // Validando se os dois campos foram enviados;
            if (Object.keys(result).length == 2) {
                const newObj = { ...quest, ...result };
                gravaQuestoes(newObj, q);
                result = {};
                console.log(q + " " + idUsuario);
                atualizaPorcentagem(q,idUsuario);
            } else {
                alert("Por favor preencha com as duas respostas");
            }
        } else {
            if (Object.keys(result).length == 1) {
                const newObj = { ...quest, ...result };
                gravaQuestoes(newObj, q);
                result = {};
            } else {
                alert("Por favor preencha com um resposta");
            }
        }
    });
}





document.getElementById("btn-finalizar").addEventListener("click", function (event) {
    event.preventDefault();
    let input = $(':input:checked');
    const q = $('#questionario').val();
    if (input.length > 0) {
        let inputs = $('.perguntaRespondida');
        if (checarForm(inputs) === true) {
            var form = document.querySelector('#form');

            if(q == '1'){
            const formdatava = $('.va');
            const formdatave = $('.ve');
            var objVA = criarObj(formdatava);
            var objVE = criarObj(formdatave);

            } else {
                const formdatava = $('.va');
                var objVA = criarObj(formdatava);
            }
            
            
            finalizaQuestoes(objVA,q);

            // $(inputs).each(function (indexForm, elementForm) {
            //     var nameForm = $(elementForm).attr('name');
            //     var valueForm = $(elementForm).val();
            //     resultFormFull[nameForm] = valueForm;

            // });

            // console.log(formCompletoVA.find(":input[type=hidden]").val());


            // console.log(resultC);
            //console.log(resultVE);
            // var questForm = {
            //     idpergunta: 
            //     idusuario: 
            // };

            //const newObj = { ...quest, ...resultFormFull };


            //console.log(newObj);

        } else {
            alert("Preencher todas as respostas");
        }
    } else {
        alert("Preencher todas as respostas");
    }
});


function gravaQuestoes(newObj, q) {
    var dados = JSON.stringify(newObj);
    $.ajax({
        url: "ajax/ajax-grava-questoes.php",
        method: "POST",
        dataType: "json",
        data: { dados: dados, q: q },
        success: function (data) {
            //alert("Resposta registrada");
            $(formDisabled).each(function (index, element) {
                $(element).attr('disabled', true);
            });
            itemClick.disabled = true;
            $("#idPerguntaRespondida-" + data).val("checked");
        }
    });
}



// UPDATE FINALIZANDO O FORM
function finalizaQuestoes(newObj) {
    var dados = JSON.stringify(newObj);
    var url_atual = window.location.href;

    $.ajax({
        url: "ajax/ajax-grava-form.php",
        method: "POST",
        dataType: "json",
        data: { dados: dados, q: q },
        success: function (data) {
            alert("Questionário Finalizado");

            window.location = url_atual;

        }
    });
}

function checarForm(inputs) {

    var bool = true;
    inputs.each(function () {
        if ($(this).val() != "checked") {
            console.log($(this).val());
            bool = false;
            return bool;
        }
    });

    return bool;
}

function criarObj(obj) {
    obj.find(":input[type=hidden]").each(function (indexHiden, elementHiden) {
        var name = $(elementHiden).attr('name');
        var value = $(elementHiden).val();
        result[name] = value;
    });

    obj.find(":input:checked").each(function (index, element) {
        var name = $(element).attr('name');
        var value = $(element).val();
        result[name] = value;
    });
    return result;
}

function atualizaPorcentagem(q,usuario)
{
    $.ajax({
        url: "ajax/ajax-atualiza-porcentagem.php",
        method: "POST",
        dataType: "json",
        data: { usuario: usuario, q: q },
        success: function (arr){
        var respondidas = arr[0];
        var porcento = arr[1];

        $('#total-respondido').html("");
        $('#porcentagem').html("");

        $('#total-respondido').html(respondidas[0]);
        $('#porcentagem').html(porcento +'%');
        
            

        }
    });

}

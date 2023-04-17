
$(document).ready(async function  () {
    let inputs = $('.perguntaRespondida');
    if (checarForm(inputs) === true) {
        $('#status-pag').html("");
        $('#status-pag').html("Completo");
    } else {
        $('#status-pag').html("Incompleto");
    }
    buscaFuncionario();
    let q = $('#questionario').val();
    let iduser = splitHash($('#func').val());
    let getPorcentagem = await verificaPorcentagem(q, iduser,false);

    if(q == 1) {
            if (getPorcentagem[1] == 100) {
                $('button[type="submit"]').prop('disabled', false);
            } else {
                $('button[type="submit"]').prop('disabled', true);
            }
        }
})

var formDisabled;
var buttomDisabled;

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
        const avaliacao = $('#avaliacao').val();
        itemClick.disabled = true;
        var quest = {
            idpergunta: itemGroup.querySelector('.pergunta').value,
            idusuario: itemGroup.querySelector('input[name="hash-rai"]').value,
            idAvaliacao: avaliacao
        };
        console.log(quest)
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
                atualizaPorcentagem(q, idUsuario,true);
            } else {
                alert("Por favor preencha com as duas respostas");
                itemClick.disabled = false;
            }
        } else {
            if (Object.keys(result).length == 1) {
                const newObj = { ...quest, ...result };
                gravaQuestoes(newObj, q);
                result = {};
            } else {
                alert("Por favor preencha com um resposta");
                itemClick.disabled = false;
            }
        }
    });
}
if ($("#btn-finalizar").length) {
    document.getElementById("btn-finalizar").addEventListener("click", async function (event) {
        event.preventDefault();
        let input = $(':input:checked');
        let iduser = splitHash($('#func').val());
        let qs = $('#questionario').val();
        if (qs == '1') {
            const getPorcentagem = await verificaPorcentagem(qs, iduser,false);
            if (input.length > 0 && getPorcentagem[1] >= 100) {
                let inputs = $('.perguntaRespondida');
                if (checarForm(inputs) === true) {
                    var form = document.querySelector('#form');
                    const formdatava = $('.va');
                    const formdatave = $('.ve');
                    var objVA = criarObj(formdatava);
                    var objVE = criarObj(formdatave);
                    finalizaQuestoes(qs, iduser);
                } else {
                    alert("Preencher todas as respostas");
                }
            } else {
                alert("Preencher todas as respostas");
            }
        } else {
            if (input.length > 0) {
                let inputs = $('.perguntaRespondida');
                if (checarForm(inputs) === true) {
                    var form = document.querySelector('#form');
                    const formdatava = $('.va');
                    const formdatave = $('.ve');
                    var objVA = criarObj(formdatava);
                    var objVE = criarObj(formdatave);
                    finalizaQuestoes(qs, iduser);
                } else {
                    alert("Você não Preencheu todas as respostas");
                }
            } else {
                alert("Você não Preencheu todas as respostas");
            }
        }
    });
}

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

            let inputs = $('.perguntaRespondida');
            if (checarForm(inputs) === true) {
                $('#status-pag').html("");

                $('#status-pag').html("Completo");

            } else {
                $('#status-pag').html("Incompleto");
            }

        }
    });
}
// UPDATE FINALIZANDO O FORM
// function finalizaQuestoes(newObj,q) {
//     var dados = JSON.stringify(newObj);
//     var url_atual = window.location.href;
//     $.ajax({
//         url: "ajax/ajax-grava-form.php",
//         method: "POST",
//         dataType: "json",
//         data: { dados: dados, q: q },
//         success: function (data) {
//             alert("Questionário Finalizado");
//             window.location = url_atual;
//         }
//     });
// }

function finalizaQuestoes(qs, iduser) {
    //var dados = JSON.stringify(newObj);
    var url_atual = window.location.href;
    $.ajax({
        url: "ajax/ajax-grava-form1.php",
        method: "POST",
        dataType: "json",
        data: { iduser: iduser, qs: qs },
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

function atualizaPorcentagem(qs, iduser,boolean) {
    $.ajax({
        url: "ajax/ajax-verifica-porcentagem.php",
        method: "POST",
        dataType: "json",
        data: {
            iduser: iduser,
            qs: qs,
            boolean:boolean
        },
        success: function (arr) {
            var respondidas = arr[0];
            var porcento = arr[1];
            $('#total-respondido').html("");
            $('#porcentagem').html("");
            $('#total-respondido').html(respondidas[0]);
            $('#porcentagem').html(porcento + '%');

            console.log(arr)
            if(qs == 1) {
                if (arr[1] == 100) {
                    $('button[type="submit"]').prop('disabled', false);
                } else {
                    $('button[type="submit"]').prop('disabled', true);
                }
            }

        }
    });
}

async function verificaPorcentagem(qs, iduser,boolean) {
    const result = await $.ajax({
        url: "ajax/ajax-verifica-porcentagem.php",
        async: true,
        type: "POST",
        dataType: "json",
        data: {
            iduser: iduser,
            qs: qs,
            boolean:boolean
        },
        success: function (result) {
        },
        beforeSend: function () {
            $('.loader').css({ display: "block" });
        },
        complete: function () {
            $('.loader').css({ display: "none" });
        },
        error: function () {
            alert("Erro ao enviar dados");
        }
    });
 return result;
}



$(document).ready(function () {
    let textarea = document.getElementById("pergunta");
    let text = textarea.value.trim();
    textarea.value = text;
    $('input[type=text]').each(function () {
        $(this).val($(this).val().trim());
    });
});

function removeInputs(selectElement) {
    const inputsContainer = selectElement.parentNode;
    const selectedValue = selectElement.value;
    const inputsToRemove = [];
    let inputs = $('#input-respostas');
    buscaRespostas(selectedValue);
}

function buscaRespostas(selectedValue) {
    //var funcionario = document.querySelector("#func");
    $.ajax({
        url: "../rh/ajax/ajax-get-resposta.php",
        method: "POST",
        data: {questionario: selectedValue},
        dataType: "JSON",
        success: function (jsonStr) {
            monstaInput(jsonStr, selectedValue);
        }
    });
}

function monstaInput(jsonStr, selectedValue) {
    $('#input-respostas').find('input[type="checkbox"]').each(function () {
        this.remove();
    });

    $('#input-respostas').find('label').each(function () {
        this.remove();
    });


    const inputsContainer = document.getElementById('input-respostas');
    let inputCount = 1;
    jsonStr.forEach(value => {
        const label = document.createElement('label');
        label.classList.add('form-check-label');
        const input = document.createElement('input');
        input.type = 'checkbox';
        input.name = `input-${++inputCount}`;
        input.classList.add('form-check-input');
        input.value = value.id;
        if (selectedValue == 1) {
            input.checked = true;
        }
        if (selectedValue == 1) {
            input.disabled = true;
        }
        const textNode = document.createTextNode(value.resposta);
        const i = document.createElement('i');
        i.classList.add('input-helper');
        label.appendChild(input);
        label.appendChild(textNode);
        label.appendChild(i);
        inputsContainer.appendChild(label);
    });

}

const enviar = document.getElementById('btn-editarPerguntaResposta');

enviar.addEventListener('click', (event) => {
    event.preventDefault();
    enviar.disabled = true;
    const selectElement = document.getElementById("qs-edit");
    const selectedValue = selectElement.value;


    const selectedOptions = {};
    const dados = {};
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var checkboxOptions = {};
    var i = 1;
    var idPergunta = document.getElementById("id-pergunta").value;
    var perguntaText = document.getElementById("pergunta").value;
    var idAvaliacao = document.getElementById("id_avaliacao").value;
    let avaliacao = {
        idavaliacao: idAvaliacao
    }
    let pergunta = {
        pergunta: perguntaText,
        idpergunta: idPergunta
    }
    checkboxes.forEach(checkbox => {
        const name = checkbox.name;
        const checked = checkbox.checked;
        const valor = checkbox.value;
        if (checked) {
            checkboxOptions['resposta' + i] = valor;
        }
        i++;
    });
    document.querySelectorAll('select').forEach(select => {
        // Cria uma propriedade no objeto para o select atual
        selectedOptions[select.name] = [];
        // Percorre todas as opções do select atual
        select.querySelectorAll('option:checked').forEach(option => {
            // Adiciona o valor da opção ao array de opções selecionadas do select atual
            selectedOptions[select.name].push(option.value);
        });
    });
    dados['avaliacao'] = avaliacao;
    dados['selects'] = selectedOptions;
    dados['pergunta'] = pergunta;
    dados['respostas'] = checkboxOptions;
    updatePergunta(dados);
});


function updatePergunta(dados) {
    $.ajax({
        url: "../rh/ajax/ajax-updade-pergunta.php",
        method: "POST",
        data: {
            dados: dados
        },
        dataType: "JSON",
        success: function (jsonStr) {
            deletePerguntaRespostas(dados);
        }
    });

}

function deletePerguntaRespostas(dados) {

    $.ajax({
        url: "../rh/ajax/ajax-delete-pergunta-respostas.php",
        method: "POST",
        data: {
            dados: dados,
        },
        dataType: "JSON",
        success: function (jsonStr) {
            insertPerguntaResposta(dados);
        }
    });
}

function insertPerguntaResposta(dados) {
    const button = $('#btn-editarPerguntaResposta');
    $.ajax({
        url: "../rh/ajax/ajax-insert-pergunta-respostas.php",
        method: "POST",
        data: {
            dados: dados
        },
        dataType: "JSON",
        success: function (jsonStr) {
            button.prop('disabled', false);
        }
    });

}




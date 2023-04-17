$(document).ready(function () {
    objres = {};
    objfunc = {};
    objCompleto = {};
    for (let j = 0; j < document.querySelectorAll('[data-res]').length; j++) {
        let input = document.querySelectorAll('[data-res]')[j];
        let value = input.value;
        let dataDP = input.getAttribute('data-res');
        objres[dataDP] = value;
    }

    for (let l = 0; l < document.querySelectorAll('[data-f]').length; l++) {
        let input = document.querySelectorAll('[data-f]')[l];
        let value = input.value;
        let dataDP = input.getAttribute('data-f');
        objfunc[dataDP] = value;
    }
    objCompleto = { objfunc, objres }
    // console.log(objCompleto);
    atualizaPorcentagem(objCompleto)
})

function atualizaPorcentagem(objCompleto) {
    var objCompleto = JSON.stringify(objCompleto);
    $.ajax({
        url: "../rh/ajax/ajax-atualiza-porcentagem.php",
        method: "POST",
        dataType: "json",
        data: { objCompleto: objCompleto },
        success: function (arr) {
            let elementosH3 = document.querySelectorAll('[data-por]');
            for (let i = 0; i < elementosH3.length; i++) {
                let input = document.querySelectorAll('[data-por]')[i];
                let value = input.value;
                let dataDP = input.getAttribute('data-por');
                for (let j = 0; j < arr.length; j++) {
                    if (dataDP == arr[j].idDP) {
                        elementosH3[i].textContent = arr[j].porcentagem + '%';
                    }
                }
            }
        }
    });
}

$('select').on('change', function () {
    var selectedValue = $(this).val(); // Obtenha o valor selecionado
    var carouselItems = $('.carousel-item'); // Obtenha todos os itens do carrossel
    // Remova a classe .active de todos os itens do carrossel
    carouselItems.removeClass('active');
    // Adicione a classe .active aos itens do carrossel com data-id correspondente ao valor selecionado
    carouselItems.filter('[data-id="' + selectedValue + '"]').addClass('active');
});
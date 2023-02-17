// const tbody = document.querySelector(".listar-pergunta");

// const listarPerguntas = async (pagina) => {
//     const dados = await fetch("./inc/questionario1-pag.php?pagina=" + pagina);
//     const resposta = await dados.text();
//     tbody.innerHTML = resposta;

// }


// listarPerguntas(1);

$(document).ready(function () {

    // for (let i = 0; i < dpsObject.dp.length; i++) {
    //     let id = dpsObject.dp[i].id;
    //   // console.log(typeof id) ;
    //     //console.log(id);
    //     let valor = $("#qsFinalizado-"+id).val();
    //     window['g-' + i] = valor;
    //     console.log("g-" + i + ": " + valor);
    // }
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
    objCompleto = {objfunc , objres }
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
           console.log(arr);
           let elementosH3 = document.querySelectorAll('[data-por]');
            for (let i = 0; i < elementosH3.length; i++) {
                let input = document.querySelectorAll('[data-por]')[i];
                let value = input.value;
                let dataDP = input.getAttribute('data-por');

                for (let j = 0; j < arr.length; j++) {
                   if(dataDP == arr[j].idDP  ){
                    elementosH3[i].textContent = arr[j].porcentagem + '%';
                   }
                    
                }
                
            }
            // $('#total-respondido').html("");
            // $('#porcentagem').html("");

            // $('#total-respondido').html(respondidas[0]);
            // $('#porcentagem').html(porcento + '%');
        }
    });

}
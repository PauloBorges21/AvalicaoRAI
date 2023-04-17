var canvasResultado;
var presidencia;
var canvasResultado = [];
var canvasArray = [
    {
        campo: "barChartdp",
        url: "../rh/ajax/ajax-grafico-dimensoes-dp.php",
        fields: ['crediVA', 'respVA', 'imparVA', 'orguVA', 'camaraVA', 'crediVE', 'respVE', 'imparVE', 'orguVE', 'camaraVE']
    },
    {
        campo: "barChartdpTotal",
        url: "../rh/ajax/ajax-grafico-visao-global-dp.php",
    },
];

//Verificando a URL para Mandar o paramentro para o AJAX
let url = window.location.pathname;
if (url == '/rh/status-questionario-presidencia.php') {
    presidencia = 1;
} else {
    presidencia = 0;
}

$(document).ready(async function () {

    for (var i = 0; i < canvasArray.length; i++) {
        $('#loadingGif').show();
         canvasResultado = await ajaxGrafico(canvasArray[i].url, presidencia, 0);
        switch (canvasArray[i].campo) {
            case 'barChartdp':
                grafico = await creatChart(canvasResultado);
                break;
            case 'barChartdpTotal':
                grafico = await creatChartT(canvasResultado);
                break;
        }
        canvasResultado = "";
    }
});

function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}

function graficoD(array) {

    let dChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            tooltips: {
                enabled: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        steps: 30,
                        max: 100
                    }
                }]
            },
            legend: {
                display: true
            },
            elements: {
                point: {
                    radius: 0
                }
            },
        },
        plugins: {
            datalabels: {
                formatter: (value, ctx) => {
                    let percentage = (value).toFixed(2) + "%";
                    return percentage;
                },
                color: '#fff',
            }
        }
    });

    if ($("#barChart2").length) {
        resetGrafico("barChart2");
        var ctx = $("#barChart2").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart2 = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    }

}

function resetGrafico(nomeobj) {
    $("#Bar" + nomeobj + "").remove();

    $('#DIV' + nomeobj).append('<canvas id="Bar' + nomeobj + '"><canvas>');
}

//AJAX DOS GRÁFICOS
async function ajaxGrafico(ajaxUrl, presidencia, selectedValue) {

    const result = await $.ajax({
        url: ajaxUrl,
        type: 'GET',
        dataType: 'JSON',
        data: {
            action: "getData",
            selectedValue: selectedValue,
            presidencia: presidencia
        },
        success: function (response) {
            $('#loadingGif').hide();
        }
    });
    return result;
}

if ($("#criaPDF").length) {
    document.getElementById("criaPDF").addEventListener('click', function () {

        var canvasArray = [
            "barChart",
            "barChart2",
            "barChart3",
            "doughnutChart",
            "doughnutChartOpt",
            "doughnutChartFeed",
            "doughnutChartTimeW"
        ];
        var imagesObject = {};
// Loop para percorrer o array de elementos canvas
        for (var i = 0; i < canvasArray.length; i++) {
            imagesObject['image' + i] = document.getElementById(canvasArray[i]).toDataURL("image/png") + i;

        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../rh/ajax/ajax-relatorio-pdf.php');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(imagesObject));
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Criar um objeto Blob com o conteúdo da resposta da requisição

                    var link = document.createElement('a');
                    link.href = xhr.response.replace('../', '');
                    link.target = "_blank";

                    link.click();

                } else {
                    console.error(xhr.statusText);
                }
            }
        };
    });

}

if ($("#criaPPT").length) {
    document.getElementById("criaPPT").addEventListener('click', function () {
        var canvasArray = [

            "BarCredibilidadeChartOpt",
            "BarRespeitoChartOpt",
            "BarImparcialidadeChartOpt",
            "BarOrgulhoChartOpt",
            "BarCamaradagemChartOpt",
            "BarTotalChartOpt",
        ];

        var imagesObject = {};
        var tipopg = {tipo:2};
// Loop para percorrer o array de elementos canvas
        for (var i = 0; i < canvasArray.length; i++) {
            imagesObject['image' + i] = document.getElementById(canvasArray[i]).toDataURL("image/png") + i;

        }
        objNew ={imagens: imagesObject, tipo: tipopg}
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../rh/ajax/ajax-relatorio-ppt.php');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(objNew));
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Criar um objeto Blob com o conteúdo da resposta da requisição
                    var link = document.createElement('a');
                    link.href = xhr.response.replace('../', '');
                    link.target = "_blank";

                    link.click();

                } else {
                    console.error(xhr.statusText);
                }
            }
        };
    });
}

async function creatChart(obj) {

    var labels = [];
    var dataVa = [];
    var dataVe = [];

    let departamentos = [
        {id: 49, nome: 'Criação / Tráfego / RTV'},
        {id: 54, nome: 'Mídia / BI / Digital Insights'},
        {id: 44, nome: 'Arte Final / Revisão / Produção Gráfica'},
        {id: 45, nome: 'Atendimento'},
        {id: 46, nome: 'Atendimento Varejo'},
        {id: 47, nome: 'Comercial'},
        {id: 48, nome: 'Controladoria'},
        {id: 50, nome: 'Criação Varejo'},
        {id: 51, nome: 'Financeiro'},
        {id: 52, nome: 'Logística'},
        {id: 53, nome: 'Manutenção / Serviços'},
        {id: 55, nome: 'Tecnologia / Suporte'},
        {id: 56, nome: 'Planejamento e Conteúdo'},
        {id: 57, nome: 'Presidência'},
        {id: 58, nome: 'Press-Influenciadores'},
        {id: 59, nome: 'Promoção e Eventos'},
        {id: 60, nome: 'RH'},
        // {id: 64, nome: 'Diretoria'},
    ];
    let modelos = [
        {id: 1, nome: 'Credibilidade'},
        {id: 2, nome: 'Respeito'},
        {id: 3, nome: 'Imparcialidade'},
        {id: 4, nome: 'Orgulho'},
        {id: 5, nome: 'Camaradagem'},
    ];
    for (var indexModelo = 0; indexModelo < modelos.length; indexModelo++) {
        for (var d = 0; d < departamentos.length; d++) {
            var objectVA = obj.filter(el => el.modelo === modelos[indexModelo].id && el.id_departamento === departamentos[d].id && el.visao === 1);
            var objectVE = obj.filter(el => el.modelo === modelos[indexModelo].id && el.id_departamento === departamentos[d].id && el.visao === 2);
            // if (objectVA[0].id_departamento === 49) {
            //     objectVA[0].departamento = "Criação / Tráfego / RTV";
            // }else if(objectVA[0].id_departamento === 54){
            //     objectVA[0].departamento = "Mídia / BI / Digital Insights";
            // } else if(objectVA[0].id_departamento === 53){
            //     objectVA[0].departamento = "Serviços / Manutenção";
            // }

            // if (![57,61,62,63,65].includes(objectVA[0].id_departamento)) {
            //     dataVa.push(objectVA);
            // }

            // if (objectVE[0].id_departamento == 49) {
            //     objectVE[0].departamento = "Criação / Tráfego / RTV";
            // }else if(objectVE[0].id_departamento == 54){
            //     objectVE[0].departamento = "Mídia / BI / Digital Insights";
            // } else if(objectVE[0].id_departamento === 53){
            //     objectVE[0].departamento = "Serviços / Manutenção";
            // }

            // if (![57,61,62,63,65].includes(objectVE[0].id_departamento)) {
            //     dataVe.push(objectVE);
            // }
            dataVa.push(objectVA);
            dataVe.push(objectVE);

        }
        //console.log(dataVa.length +" "+ dataVe.length)
        f(dataVa,dataVe,modelos[indexModelo].nome);
        dataVa =[];
        dataVe =[];
    }
}
async function creatChartT(obj) {

    var labels = [];
    var dataVa = [];
    var dataVe = [];

    let departamentos = [
        {id: 49, nome: 'Criação / Tráfego / RTV'},
        {id: 54, nome: 'Mídia / BI / Digital Insights'},
        {id: 44, nome: 'Arte Final / Revisão / Produção Gráfica'},
        {id: 45, nome: 'Atendimento'},
        {id: 46, nome: 'Atendimento Varejo'},
        {id: 47, nome: 'Comercial'},
        {id: 48, nome: 'Controladoria'},
        {id: 50, nome: 'Criação Varejo'},
        {id: 51, nome: 'Financeiro'},
        {id: 52, nome: 'Logística'},
        {id: 53, nome: 'Manutenção / Serviços'},
        {id: 55, nome: 'Tecnologia / Suporte'},
        {id: 56, nome: 'Planejamento e Conteúdo'},
        {id: 57, nome: 'Presidência'},
        {id: 58, nome: 'Press-Influenciadores'},
        {id: 59, nome: 'Promoção e Eventos'},
        {id: 60, nome: 'RH'},
        // {id: 64, nome: 'Diretoria'},
    ];
    let modelos = [
        {id: 6, nome: 'Total'},
    ];
    for (var indexModelo = 0; indexModelo < modelos.length; indexModelo++) {
        for (var d = 0; d < departamentos.length; d++) {
            var objectVA = obj.filter(el => el.modelo === modelos[indexModelo].id && el.id_departamento === departamentos[d].id && el.visao === 1);
            var objectVE = obj.filter(el => el.modelo === modelos[indexModelo].id && el.id_departamento === departamentos[d].id && el.visao === 2);
            dataVa.push(objectVA);
            dataVe.push(objectVE);
        }
        //console.log(dataVa.length +" "+ dataVe.length)
        f(dataVa,dataVe,modelos[indexModelo].nome);
        dataVa =[];
        dataVe =[];
    }
}

function Dataset() {
    this.dataset = {
        label: '',
        data: [],
        backgroundColor: '',
        borderColor: '',
        borderWidth: 1
    }
}

function f(objectVA,objectVE,NomeModelo) {

    if ($("#DIV"+ NomeModelo + "ChartOpt").length) {
        resetGrafico(NomeModelo + "ChartOpt");

        var barChartCanvas = $("#Bar" + NomeModelo + "ChartOpt").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: {
                labels: [],
                datasets: []
            }
        });


        let dataVA = new Dataset;
        dataVA.dataset.label = 'Visão Area';
        dataVA.dataset.backgroundColor = 'rgba(90,18,226,0.33)';
        dataVA.dataset.borderColor = 'rgba(87,14,232,0.24)';

        let dataVE = new Dataset;
        dataVE.dataset.label = 'Visão Empresa';
        dataVE.dataset.backgroundColor = 'rgba(4,13,3,0.25)';
        dataVE.dataset.borderColor = 'rgba(4,13,3,0.27)';

        for (var index = 0; index < objectVA.length; index++) {
            if(objectVA[index][0] != undefined){
                dataVA.dataset.data.push((objectVA[index][0].total).toFixed(2));
                barChart.data.labels.push((objectVA[index][0].departamento));
            }

        }

        for (var index = 0; index < objectVE.length; index++) {
            if (objectVA[index][0] != undefined) {
                dataVE.dataset.data.push((objectVE[index][0].total).toFixed(2));
            }
        }

        barChart.data.datasets.push(
            dataVA.dataset,
            dataVE.dataset);

        var options = {
            tooltips: {
                enabled: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        steps: 30,
                        max: 100
                    }
                }]
            },
            legend: {
                display: true
            },
            elements: {
                point: {
                    radius: 0
                }
            },
            plugins: {
                datalabels: {
                    formatter: (value, barChartCanvas) => {
                        let percentage = (value) + "%";
                        return percentage;
                    },
                    color: '#000',
                }
            }
        };

        barChart.options = options;

        barChart.update();
    }
}
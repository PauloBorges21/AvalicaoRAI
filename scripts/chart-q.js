var canvasFieldName;
var canvasResultado;
var presidencia;
var canvasArray = [
    {
        campo: "barChart", url: "../rh/ajax/ajax-grafico-confianca.php", fields: ["confVA", "confVE"]
    },
    {
        campo: "barChart2",
        url: "../rh/ajax/ajax-grafico-dimensoes.php",
        fields: ['crediVA', 'respVA', 'imparVA', 'orguVA', 'camaraVA', 'crediVE', 'respVE', 'imparVE', 'orguVE', 'camaraVE']
    },
    {
        campo: "barChart3",
        url: "../rh/ajax/ajax-grafico-culturais.php",
        fields: ['contratarRecVA', 'inspVA', 'falarVA', 'estudarVA', 'agradecerVA', 'desenVA', 'cuidarVA', 'compartVA', 'celebVA', 'contratarRecVE', 'inspVE', 'falarVE', 'estudarVE', 'agradecerVE', 'desenVE', 'cuidarVE', 'compartVE', 'celebVE']
    },
    {
        campo: "doughnutChart",
        url: "../rh/ajax/ajax-grafico-permanencia.php",
        fields: ['respo1', 'respo2', 'respo3', 'respo4', 'respo5']
    },
    {
        campo: "doughnutChartFeed",
        url: "../rh/ajax/ajax-grafico-feedback.php",
        fields: ['respofb1', 'respofb2', 'respofb3', 'respofb4', 'respofb5']
    },
    {
        campo: "doughnutChartOpt",
        url: "../rh/ajax/ajax-grafico-qtd-oportunidade.php",
        fields: ['respoOP1', 'respoOP2', 'respoOP3', 'respoOP4']
    },

    {
        campo: "doughnutChartTimeW",
        url: "../rh/ajax/ajax-grafico-time.php",
        fields: ['respoTime1', 'respoTime2', 'respoTime3', 'respoTime4', 'respoTime5', 'respoTime6', 'respoTime7']
    },
    {
        campo: "barChart4", url: "../rh/ajax/ajax-grafico-visao-global.php",
        fields: ["confVA", "confVE"]
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
        for (var j = 0; j < canvasResultado.length; j++) {
            window[canvasArray[i].fields[j]] = parseFloat(parseFloat(canvasResultado[j]).toFixed(2));
        }
        switch (canvasArray[i].campo) {
            case 'barChart':
                grafico(confVA, confVE)
                break;
            case 'barChart2':
                graficoD(crediVA, crediVE, respVA, respVE, imparVA, imparVE, orguVA, orguVE, camaraVA, camaraVE);
                break;
            case 'barChart3':
                graficoCulturais(contratarRecVA, inspVA, falarVA, estudarVA, agradecerVA, desenVA, cuidarVA, compartVA, celebVA, contratarRecVE, inspVE, falarVE, estudarVE, agradecerVE, desenVE, cuidarVE, compartVE, celebVE);
                break;
            case 'doughnutChart':
                graficoPer(respo1, respo2, respo3, respo4, respo5);
                break;
            case 'doughnutChartOpt':
                graficoOpt(respoOP1, respoOP2, respoOP3, respoOP4);
                break;
            case 'doughnutChartFeed':
                graficoFeed(respofb1, respofb2, respofb3, respofb4, respofb5);
                break;
            case 'doughnutChartTimeW':
                graficoTime(respoTime1, respoTime2, respoTime3, respoTime4, respoTime5, respoTime6, respoTime7);
                break;
            case 'barChart4':
                graficoGlobal(confVA, confVE)
                break;
        }
        canvasResultado = "";
    }
});

$("#grafic_p_dp").change(async function () {
    var selectedValue = $(this).val();
    // Remove os eventos de mouse
    $("#doughnutChartTimeW").off('mouseenter mouseleave');
    for (var i = 0; i < canvasArray.length; i++) {
        $('#loadingGif').show();
        canvasResultado = await ajaxGrafico(canvasArray[i].url, presidencia, selectedValue);
        for (var j = 0; j < canvasResultado.length; j++) {
            canvasFieldName = canvasArray[i].fields[j];
            window[canvasArray[i].fields[j]] = parseFloat(parseFloat(canvasResultado[j]).toFixed(2));
        }
        switch (canvasArray[i].campo) {
            case 'barChart':
                grafico(confVA, confVE)
                break;
            case 'barChart2':
                graficoD(crediVA, crediVE, respVA, respVE, imparVA, imparVE, orguVA, orguVE, camaraVA, camaraVE);
                break;
            case 'barChart3':
                graficoCulturais(contratarRecVA, inspVA, falarVA, estudarVA, agradecerVA, desenVA, cuidarVA, compartVA, celebVA, contratarRecVE, inspVE, falarVE, estudarVE, agradecerVE, desenVE, cuidarVE, compartVE, celebVE);
                break;
            case 'doughnutChart':
                graficoPer(respo1, respo2, respo3, respo4, respo5);

                break;
            case 'doughnutChartOpt':
                graficoOpt(respoOP1, respoOP2, respoOP3, respoOP4);

                break;
            case 'doughnutChartFeed':
                graficoFeed(respofb1, respofb2, respofb3, respofb4, respofb5);

                break;
            case 'doughnutChartTimeW':
                graficoTime(respoTime1, respoTime2, respoTime3, respoTime4, respoTime5, respoTime6, respoTime7);
                break;
            case 'barChart4':
                graficoGlobal(confVA, confVE)
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

function grafico(va, ve) {
    //  Grafico Barras Índice de Confiança
    var multiLineData = {
        labels: ["No gestor imediato(VA)", "Nas lideranças da empresa(Gestores e CEO)(VE)"],
        datasets: [{
            data: [va, ve],
            backgroundColor: [
                'rgb(87,14,231)',
                'rgba(4, 13, 3)',
                'rgba(255, 206, 86)',
                'rgba(75, 192, 192)',
                'rgba(153, 102, 255)',
                'rgba(255, 159, 64)'
            ],
            borderColor: [
                'rgba(87, 14, 232)',
                'rgba(4, 13, 3)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            fill: false
        },
        ]
    };
    var options = {
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
            display: false
        },
        elements: {
            point: {
                radius: 0
            }
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
    };
    if ($("#barChart").length) {
        resetGrafico("barChart");
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: multiLineData,
            options: options
        });
    }
    ;
}

function graficoD(crediVA, crediVE, respVA, respVE, imparVA, imparVE, orguVA, orguVE, camaraVA, camaraVE) {
    //  Grafico Rosquinha

    // var data = {
    //   labels: ['Credibilidade','Respeito', 'Imparcialidade','Orgulho','Camaradagem'],
    //     datasets: [{
    //         label: 'Credibilidade',

    //         data: [crediVA,crediVE],
    //         borderColor: ['rgba(255, 200, 125, 0.8)'],
    //         backgroundColor: ['rgba(255, 200, 125, 0.8)'],
    //         borderWidth: 1,
    //         //fill: true
    //       },
    //     //  {
    //     //   label: 'Credibilidade Mídia On VE',
    //     //   data: [crediVE],
    //     //   borderColor: ['rgba(255, 200, 125, 0.8)'],
    //     //   backgroundColor: ['rgba(255, 200, 125, 0.8)'],
    //     //   borderWidth: 1,
    //     //   fill: true
    //     // },
    //       {
    //         label: 'Respeito',
    //         data: [respVA,respVE],
    //         borderColor: ['rgba(125, 255, 200, 0.8)'],
    //         backgroundColor: ['rgba(125, 255, 200, 0.8)'],
    //         borderWidth: 1,
    //         fill: true
    //       },
    //       // {
    //       //   label: 'Respeito Mídia On VE',
    //       //   data: [respVE],
    //       //   borderColor: ['rgba(125, 255, 200, 0.8)'],
    //       //   backgroundColor: ['rgba(125, 255, 200, 0.8)'],
    //       //   borderWidth: 1,
    //       //   fill: true
    //       // },
    //       {
    //         label: 'Imparcialidade',
    //         data: [ imparVA,imparVE],
    //         borderColor: ['rgba(200, 125, 255, 0.8)'],
    //         backgroundColor: ['rgba(200, 125, 255, 0.8)'],
    //         borderWidth: 1,
    //         fill: true
    //       },
    //       // {
    //       //   label: 'Imparcialidade Mídia On VE',
    //       //   data: [ imparVE],
    //       //   borderColor: ['rgba(200, 125, 255, 0.8)'],
    //       //   backgroundColor: ['rgba(200, 125, 255, 0.8)'],
    //       //   borderWidth: 1,
    //       //   fill: true
    //       // },
    //       {
    //         label: 'Orgulho',
    //         data: [orguVA,orguVE],
    //         borderColor: ['rgba(255, 125, 200, 0.8)'],
    //         backgroundColor: ['rgba(255, 125, 200, 0.8)'],
    //         borderWidth: 1,
    //         fill: true
    //       },
    //       // {
    //       //   label: 'Orgulho Mídia On VE',
    //       //   data: [ orguVE],
    //       //   borderColor: ['rgba(255, 125, 200, 0.8)'],
    //       //   backgroundColor: ['rgba(255, 125, 200, 0.8)'],
    //       //   borderWidth: 1,
    //       //   fill: true
    //       // },
    //       {
    //         label: 'Camaradagem',
    //         data: [camaraVA,camaraVE],
    //         borderColor: ['rgba(125, 200, 255, 0.8)'],
    //         backgroundColor: ['rgba(125, 200, 255, 0.8)'],
    //         borderWidth: 1,
    //         fill: true
    //       },
    //       // {
    //       //   label: 'Camaradagem Mídia On VE',
    //       //   data: [camaraVE],
    //       //   borderColor: ['rgba(125, 200, 255, 0.8)'],
    //       //   backgroundColor: ['rgba(125, 200, 255, 0.8)'],
    //       //   borderWidth: 1,
    //       //   fill: true
    //       // }
    //     ],


    //   };

    var data = {
        labels: ['Credibilidade', 'Respeito', 'Imparcialidade', 'Orgulho', 'Camaradagem'],
        datasets: [{
            label: 'VA',
            data: [crediVA, respVA, imparVA, orguVA, camaraVA],
            backgroundColor: 'rgba(87, 14, 232)',
            borderColor: 'rgba(87, 14, 232)',
            borderWidth: 1
        },
            {
                label: 'VE',
                data: [crediVE, respVE, imparVE, orguVE, camaraVE],
                backgroundColor: 'rgba(4, 13, 3)',
                borderColor: 'rgba(4, 13, 3)',
                borderWidth: 1
            }]
    }
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
                formatter: (value, ctx) => {
                    let percentage = (value).toFixed(2) + "%";
                    return percentage;
                },
                color: '#fff',
            }
        }

    };
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

function graficoCulturais(contratarRecVA, inspVA, falarVA, estudarVA, agradecerVA, desenVA, cuidarVA, compartVA, celebVA, contratarRecVE, inspVE, falarVE, estudarVE, agradecerVE, desenVE, cuidarVE, compartVE, celebVE) {
    //  Grafico Rosquinha

    var data = {
        labels: ['Contratar e receber', 'Inspirar', 'Falar', 'Escultar', 'Agradecer', 'Desenvolver', 'Cuidar', 'Compartilhar', 'Celebrar'],
        datasets: [{
            label: 'VA',
            data: [contratarRecVA, inspVA, falarVA, estudarVA, agradecerVA, desenVA, cuidarVA, compartVA, celebVA],
            backgroundColor: 'rgba(87, 14, 232)',
            borderColor: 'rgba(87, 14, 232)',
            borderWidth: 1
        },
            {
                label: 'VE',
                data: [contratarRecVE, inspVE, falarVE, estudarVE, agradecerVE, desenVE, cuidarVE, compartVE, celebVE],
                backgroundColor: 'rgba(4, 13, 3)',
                borderColor: 'rgba(4, 13, 3)',
                borderWidth: 1
            }]
    }
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
                formatter: (value, ctx) => {
                    let percentage = (value).toFixed(2) + "%";
                    return percentage;
                },
                color: '#fff',
            }
        }

    };
    if ($("#barChart3").length) {
        resetGrafico("barChart3");
        var ctx = $("#barChart3").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart3 = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    }

}

function graficoPer(respo1, respo2, respo3, respo4, respo5) {
    //  Grafico Rosquinha
    var data = {
        labels: ['O fato dela me proporcionar equilíbrio entre minha vida pessoal e profissional',
            'A remuneração e benefícios oferecidos pela organização',
            'O fato de saber que só serei demitido em último caso',
            'A oportunidade que tenho de crescer e me desenvolver',
            'O alinhamento dos meus valores com os valores da organização'],
        datasets: [{
            label: 'Percentual de Respondentes',
            data: [respo1, respo2, respo3, respo4, respo5],
            backgroundColor: [
                'rgba(153, 102, 255, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(200, 125, 255, 0.8)',
                'rgba(255, 125, 200, 0.8)'
            ],
            borderColor: [
                'rgba(153, 102, 255, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(200, 125, 255, 0.8)',
                'rgba(255, 125, 200, 0.8)'
            ],
            borderWidth: 1
        },
        ]
    }
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
                formatter: (value, ctx) => {
                    let percentage = (value).toFixed(2) + "%";
                    return percentage;
                },
                color: '#000',
            }
        }

    };
    if ($("#doughnutChart").length) {
        resetGrafico("doughnutChart");
        var ctx = $("#doughnutChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart2 = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });
    }

    // Final Grafico Rosquinha

    //  Grafico Barras Índice de Confiança
    //  var multiLineData = {
    //   labels: ["No gestor imediato(VA)", "Nas lideranças da empresa(Gestores e CEO)(VE)"],
    //   datasets: [{
    //       data: [va,ve],
    //       backgroundColor: [
    //         'rgba(153, 102, 255, 0.2)',
    //         'rgba(54, 162, 235, 0.2)',
    //         'rgba(255, 206, 86, 0.2)',
    //         'rgba(75, 192, 192, 0.2)',
    //         'rgba(153, 102, 255, 0.2)',
    //         'rgba(255, 159, 64, 0.2)'
    //       ],
    //       borderColor: [
    //         'rgba(153, 102, 255, 1)',
    //         'rgba(54, 162, 235, 1)',
    //         'rgba(255, 206, 86, 1)',
    //         'rgba(75, 192, 192, 1)',
    //         'rgba(153, 102, 255, 1)',
    //         'rgba(255, 159, 64, 1)'
    //       ],
    //       borderWidth: 1,
    //       fill: false
    //     },
    //   ]
    // };

    //   var options = {
    //     scales: {
    //       yAxes: [{
    //         ticks: {
    //           beginAtZero: true,
    //           steps: 30,
    //           max: 100
    //         }
    //       }]
    //     },
    //     legend: {
    //       display: false
    //     },
    //     elements: {
    //       point: {
    //         radius: 0
    //       }
    //     }  ,

    //     plugins: {
    //       datalabels: {
    //           formatter: (value, ctx) => {
    //               let percentage = (value).toFixed(2) + "%";
    //               return percentage;

    //             },
    //             color: '#000',
    //       }
    //   }
    //   };
    //   if ($("#barChart").length) {
    //   var barChartCanvas = $("#barChart").get(0).getContext("2d");
    //   // This will get the first returned node in the jQuery collection.
    //   var barChart = new Chart(barChartCanvas, {
    //     type: 'bar',
    //     data:  multiLineData,
    //     options: options
    //   });
    // };
}

function graficoFeed(respo1, respo2, respo3, respo4, respo5) {
    //  Grafico Rosquinha
    var data = {
        labels: ['Nenhuma',
            'Uma',
            'Duas',
            'Três',
            'Mais de três'
        ],
        datasets: [{
            label: 'Percentual de Respondentes',
            data: [respo1, respo2, respo3, respo4, respo5],
            backgroundColor: [
                'rgb(153, 102, 255)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(75, 192, 192)',
                'rgb(200, 125, 255)',
                'rgb(255, 125, 200)'
            ],
            borderColor: [
                'rgba(153, 102, 255)',
                'rgba(54, 162, 235)',
                'rgba(255, 206, 86)',
                'rgba(75, 192, 192)',
                'rgba(200, 125, 255)',
                'rgba(255, 125, 200)'
            ],
            borderWidth: 1
        },
        ]
    }
    var options = {
        tooltips: {
            enabled: true
        },
        // animation: {
        //   onComplete: function () {
        //     console.log(this.toBase64Image());
        //   },
        // },
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
                formatter: (value, ctx) => {
                    let percentage = (value).toFixed(2) + "%";
                    return percentage;
                },
                color: '#000',
            },
            afterRender: function (chart, args, options) {
                var img = new Image();
                img.src = chart.toBase64Image('image/png', 1);
                chart.canvas.parentNode.insertBefore(img, chart.canvas.nextSibling);
                chart.canvas.style.display = 'none'; // Hide the chart canvas
                chart.canvas.remove(); // To remove the chart canvas
            }
        }

    };
    if ($("#doughnutChartFeed").length) {
        resetGrafico("doughnutChartFeed");
        var ctx = $("#doughnutChartFeed").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart2 = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });

    }
    // var image = barChart2.toBase64Image();
    // console.log(image);
    // var a = document.createElement('a');
    // a.href = barChart2.toBase64Image();
    // a.download = 'my_file_name.jgp';
    // document.getElementById('imgWrap').src = barChart2.toBase64Image();
    // // Trigger the download
    // a.click();
}

function graficoOpt(respo1, respo2, respo3, respo4) {
    //  Grafico Rosquinha
    var data = {
        labels: [
            'Várias oportunidades',
            'Algumas oportunidades',
            'Poucas oportunidades',
            'Nenhuma oportunidade'
        ],
        datasets: [{
            label: 'Percentual de Respondentes',
            data: [respo1, respo2, respo3, respo4],
            backgroundColor: [
                'rgb(153, 102, 255)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(75, 192, 192)',
                'rgb(200, 125, 255)',
                'rgb(255, 125, 200)'
            ],
            borderColor: [
                'rgba(153, 102, 255)',
                'rgba(54, 162, 235)',
                'rgba(255, 206, 86)',
                'rgba(75, 192, 192)',
                'rgba(200, 125, 255)',
                'rgba(255, 125, 200)'
            ],
            borderWidth: 1
        },
        ]
    }
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
                formatter: (value, ctx) => {
                    let percentage = (value).toFixed(2) + "%";
                    return percentage;
                },
                color: '#000',
            }
        }

    };
    if ($("#doughnutChartOpt").length) {
        resetGrafico("doughnutChartOpt");
        var canvas = $("#doughnutChartOpt");
        canvas[0].getContext("2d").clearRect(0, 0, canvas[0].width, canvas[0].height);
        var ctx = $("#doughnutChartOpt").get(0).getContext("2d");

        // This will get the first returned node in the jQuery collection.
        var barChart2 = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });
        barChart2.update();
    }
}

function graficoTime(respo1, respo2, respo3, respo4, respo5, respo6, respo7) {
    //  Grafico Rosquinha
    var data;
    var options;
    data = {
        labels: [
            'Até 1 ano',
            'Entre 1 e 2 anos',
            'Entre 3 e 5 anos',
            'Entre 6 e 10 anos',
            'Entre 11 e 15 anos',
            'Entre 16 e 20 anos',
            'Mais de 20 anos'
        ],
        datasets: [{
            label: 'Percentual de Respondentes',
            data: [respo1, respo2, respo3, respo4, respo5, respo6, respo7],
            backgroundColor: [
                'rgb(153, 102, 255)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(75, 192, 192)',
                'rgb(200, 125, 255)',
                'rgb(255, 125, 200)'
            ],
            borderColor: [
                'rgba(153, 102, 255)',
                'rgba(54, 162, 235)',
                'rgba(255, 206, 86)',
                'rgba(75, 192, 192)',
                'rgba(200, 125, 255)',
                'rgba(255, 125, 200)'
            ],
            borderWidth: 1
        },
        ]
    }
    options = {
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
                formatter: (value, ctx) => {
                    let percentage = (value).toFixed(2) + "%";
                    return percentage;
                },
                color: '#000',
            }
        }

    };

    if ($("#doughnutChartTimeW").length) {
        resetGrafico("doughnutChartTimeW");
        var ctx = $("#doughnutChartTimeW").get(0).getContext("2d");
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
        // Cria o novo gráfico
        var barChart2 = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });
        barChart2.update();
        removeData(barChart2)
        // Destroi o gráfico atual
        barChart2.chart.destroy();
        var barChart2 = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });
        barChart2.update();

    }

    // if ($("#doughnutChartTimeW").length) {
    //     var ctx = $("#doughnutChartTimeW").get(0).getContext("2d");
    //     $("#doughnutChartTimeW").off('mousemove');
    //     // This will get the first returned node in the jQuery collection.
    //     var barChart2 = new Chart(ctx, {
    //         type: 'doughnut',
    //         data: data,
    //         options: options
    //     });
    //     barChart2.destroy(); // remove o gráfico atual
    //     barChart2 = new Chart(ctx, {
    //         type: 'doughnut',
    //         data: data,
    //         options: options
    //     });
    //     barChart2.update();
    //
    // }


}

function graficoGlobal(va,ve) {
    //  Grafico Barras Índice de Confiança
    var multiLineData = {
        labels: ["Visão Global(VA)", "Visão Global(VE)"],
        datasets: [{
            data: [va,ve],
            backgroundColor: [
                'rgba(87, 14, 232)',
                'rgba(4, 13, 3)',
            ],
            borderColor: [
                'rgba(87, 14, 232)',
                'rgba(4, 13, 3)',
            ],
            borderWidth: 1,
            fill: false
        },
        ]};
    var options = {
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
            display: false
        },
        elements: {
            point: {
                radius: 0
            }
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
    };
    if ($("#barChart4").length) {
        resetGrafico("barChart4");
        var barChartCanvas4 = $("#barChart4").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart4 = new Chart(barChartCanvas4, {
            type: 'bar',
            data: multiLineData,
            options: options
        });
    };
}

// $("#grafic_dp").change(async function () {
//     var selectedValue = $(this).val();
//     var canvas = $("#doughnutChartOpt");
//     canvas.html("");
//     canvas[0].getContext("2d").clearRect(0, 0, canvas[0].width, canvas[0].height);
//     const retorno = await ajaxQtdOportunidade(selectedValue);
//     console.log(retorno);
//     if (retorno == 0) {
//
//         canvas[0].getContext("2d").clearRect(0, 0, canvas[0].width, canvas[0].height);
//         alert("Não existem dados para fazer o gráfico.");
//     } else {
//         var oportunidadesNames = ['respoOP1', 'respoOP2', 'respoOP3', 'respoOP4'];
//         for (var i = 0; i < retorno.length; i++) {
//             window[oportunidadesNames[i]] = parseFloat(parseFloat(retorno[i]).toFixed(2));
//         }
//         graficoOpt(respoOP1, respoOP2, respoOP3, respoOP4);
//     }
//
// });
//
// $("#grafic_tw").change(async function () {
//     var selectedValue = $(this).val();
//     const retorno = await ajaxTime(selectedValue);
//     console.log(retorno);
//     if (retorno == 0) {
//         var canvas = $("#doughnutChartTimeW");
//         canvas[0].getContext("2d").clearRect(0, 0, canvas[0].width, canvas[0].height);
//         alert("Não existem dados para fazer o gráfico.");
//     } else {
//         var timeNames = ['respoTime1', 'respoTime2', 'respoTime3', 'respoTime4', 'respoTime5', 'respoTime6', 'respoTime7'];
//         for (var i = 0; i < resultadohomeworktime.length; i++) {
//             window[timeNames[i]] = parseFloat(parseFloat(resultadohomeworktime[i]).toFixed(2));
//         }
//         graficoTime(respoTime1, respoTime2, respoTime3, respoTime4, respoTime5, respoTime6, respoTime7);
//
//     }
//
// });
function resetGrafico(nomeobj) {
    $("#" + nomeobj + "").remove();

    $('#DIV' + nomeobj).append('<canvas id="' + nomeobj + '"><canvas>');
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
        console.log(imagesObject)
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', '../rh/ajax/ajax-relatorio-pdf.php');
    //     xhr.setRequestHeader('Content-Type', 'application/json');
    //     xhr.send(JSON.stringify(imagesObject));
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === 4) {
    //             if (xhr.status === 200) {
    //                 // Criar um objeto Blob com o conteúdo da resposta da requisição
    //
    //                 var link = document.createElement('a');
    //                 link.href = xhr.response.replace('../', '');
    //                 link.target = "_blank";
    //
    //                 link.click();
    //
    //             } else {
    //                 console.error(xhr.statusText);
    //             }
    //         }
    //     };
     });

}
if ($("#criaPPT").length) {
    document.getElementById("criaPPT").addEventListener('click', function () {


        var imagesObject = {};
        var tipopg = {tipo:1};
// Loop para percorrer o array de elementos canvas
        for (var i = 0; i < canvasArray.length; i++) {
            imagesObject['image' + i] = document.getElementById(canvasArray[i].campo).toDataURL("image/png") + i;

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

// for (var i = 0; i < canvasArray.length; i++) {
//    // console.log(canvasArray[i].campo + " " + canvasArray[i].url);
//     canvasFieldName = canvasArray[i].campo;
//     canvasFieldValue = ajaxGrafico(canvasArray[i].url);
//     window[canvasFieldName] = canvasFieldValue;
//     for (var i = 0; i < window[canvasFieldName].length; i++) {
//         window[dimensoesNames[i]] = parseFloat(parseFloat(resultadoD[i]).toFixed(2));
//     }
// }

// let resultadoC = await ajaxConfianca(0);
// let resultadoD = await ajaxDimensoes(0);
// let resultadoPCultu = await ajaxCulturais(0);
// let resultadoMPer = await ajaxPermanencia(0);
// let resultadoFedback = await ajaxFeedback(0);
// let resultadoOpt = await ajaxQtdOportunidade(0);
// let resultadohomeworktime = await ajaxTime(0);

// Confiança
// var ConfiancaNames = ['confVA', 'confVE'];
// for (var i = 0; i < resultadoD.length; i++) {
//     window[dimensoesNames[i]] = parseFloat(parseFloat(resultadoD[i]).toFixed(2));
// }
//grafico(confVA, confVE);
// var va = parseFloat(parseFloat(resultadoC[0]).toFixed(2));
// var ve = parseFloat(parseFloat(resultadoC[1]).toFixed(2));

//Fim Grafico Confiança
//grafico(va, ve);

// Dimemsões
// var dimensoesNames = ['crediVA', 'respVA', 'imparVA', 'orguVA', 'camaraVA', 'crediVE', 'respVE', 'imparVE', 'orguVE', 'camaraVE'];
// for (var i = 0; i <   window[canvasFieldName].length; i++) {
//     window[dimensoesNames[i]] = parseFloat(parseFloat(resultadoD[i]).toFixed(2));
// }
// graficoD(crediVA, crediVE, respVA, respVE, imparVA, imparVE, orguVA, orguVE, camaraVA, camaraVE);
//
// // Práticas Culturais
// var praticasCulturaisNames = ['contratarRecVA', 'inspVA', 'falarVA', 'estudarVA', 'agradecerVA', 'desenVA', 'cuidarVA', 'compartVA', 'celebVA', 'contratarRecVE', 'inspVE', 'falarVE', 'estudarVE', 'agradecerVE', 'desenVE', 'cuidarVE', 'compartVE', 'celebVE'];
// for (var i = 0; i < resultadoPCultu.length; i++) {
//     window[praticasCulturaisNames[i]] = parseFloat(parseFloat(resultadoPCultu[i]).toFixed(2));
// }
// graficoCulturais(contratarRecVA, inspVA, falarVA, estudarVA, agradecerVA, desenVA, cuidarVA, compartVA, celebVA, contratarRecVE, inspVE, falarVE, estudarVE, agradecerVE, desenVE, cuidarVE, compartVE, celebVE);
//
// //Permanência
// var permanenciaNames = ['respo1', 'respo2', 'respo3', 'respo4', 'respo5'];
// for (var i = 0; i < resultadoMPer.length; i++) {
//     window[permanenciaNames[i]] = parseFloat(parseFloat(resultadoMPer[i]).toFixed(2));
// }
// graficoPer(respo1, respo2, respo3, respo4, respo5);
//
// //FeedBack
// var feedbackNames = ['respofb1', 'respofb2', 'respofb3', 'respofb4', 'respofb5'];
// for (var i = 0; i < resultadoFedback.length; i++) {
//     window[feedbackNames[i]] = parseFloat(parseFloat(resultadoFedback[i]).toFixed(2));
// }
// graficoFeed(respofb1, respofb2, respofb3, respofb4, respofb5);
//
// //Oportunidade
// var oportunidadesNames = ['respoOP1', 'respoOP2', 'respoOP3', 'respoOP4'];
// for (var i = 0; i < resultadoOpt.length; i++) {
//     window[oportunidadesNames[i]] = parseFloat(parseFloat(resultadoOpt[i]).toFixed(2));
// }
// graficoOpt(respoOP1, respoOP2, respoOP3, respoOP4);
//
// // Tempo de Casa
// var timeNames = ['respoTime1', 'respoTime2', 'respoTime3', 'respoTime4', 'respoTime5', 'respoTime6', 'respoTime7'];
// for (var i = 0; i < resultadohomeworktime.length; i++) {
//     window[timeNames[i]] = parseFloat(parseFloat(resultadohomeworktime[i]).toFixed(2));
// }
// graficoTime(respoTime1, respoTime2, respoTime3, respoTime4, respoTime5, respoTime6, respoTime7);
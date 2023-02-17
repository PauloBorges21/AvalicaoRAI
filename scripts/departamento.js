
var btn_gravar_dp = $("#btn-gravar-dp");
if (btn_gravar_dp.length > 0) {
    document.getElementById("btn-gravar-dp").addEventListener("click", function (event) {
        event.preventDefault();      
        var nome = $('#nome-dp').val();       
        if (nome) {
            $.ajax(
                {
                    type: "POST",
                    url: "../rh/ajax/ajax-grava-dp.php",
                    dataType: "JSON",
                    data: {
                       nome: nome,                        
                    },
                    success: function (result) {                        
                        alert("Departamento: Cadastrado!");
                        $('#nome-dp').val("");                         
                    },
                    error: function () {
                        alert("não deu para completar a requisição");
                    }
                }
            );
        } else {
            alert("Verifique os campos e tente novamente");
        }
    });
}


// Relacionamento do Usuário Gerência. 


$("#usu_setor_dp").change(function () {
    var selectedValue = $(this).val();
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-verifica-gerente.php",
            dataType: "TEXT",
            data: {
                setor: selectedValue,
            },
            success: function (result) {
                if (result != 'false') {
                    $("#formceditar").hide();
                    $("#formceditar").empty();
                    $("#usu_user").empty();
                    $('#usu_user').html(result);
                } else {
                    $("#formceditar").hide();
                    $("#formceditar").empty();
                    $("#usu_user").empty();
                    $("#usu_user").append($("<option SELECTED disabled='disabled'>").text("Selecione").val("Selecione"));
                    alert('Não existe Funcionários relacionados nesse setor');
                }
            },
            error: function () {
                alert("não deu para completar a requisição");
            }
        }
    );
});


$("#usu_setor_dp").change(function () {
    var selectedValue = $(this).val();
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-verifica-gerente.php",
            dataType: "TEXT",
            data: {
                setor: selectedValue,
            },
            success: function (result) {
                if (result != 'false') {
                    $("#formceditar").hide();
                    $("#formceditar").empty();
                    $("#usu_user").empty();
                    $('#usu_user').html(result);
                } else {
                    $("#formceditar").hide();
                    $("#formceditar").empty();
                    $("#usu_user").empty();
                    $("#usu_user").append($("<option SELECTED disabled='disabled'>").text("Selecione").val("Selecione"));
                    alert('Não existe Funcionários relacionados nesse setor');
                }
            },
            error: function () {
                alert("não deu para completar a requisição");
            }
        }
    );
});


var btn_gravar_dp = $("#btn-gravar-dp-usu");
if (btn_gravar_dp.length > 0) {
    document.getElementById("btn-gravar-dp-usu").addEventListener("click", function (event) {
        event.preventDefault();      
        let iddepartamento = $('#usu_setor_dp').val();       
        let idusuario = $('#usu_dp_user').val();
        if (iddepartamento && idusuario) {
            $.ajax(
                {
                    type: "POST",
                    url: "../rh/ajax/ajax-relacionar-dp.php",
                    dataType: "JSON",
                    data: {
                        idusuario: idusuario,
                        iddepartamento: iddepartamento,                        
                    },
                    success: function (result) {
                        let selectedTextD = $('#usu_setor_dp option:selected').text();
                        let selectedTextU = $('#usu_dp_user option:selected').text();                        
                        alert(selectedTextU +' é Gerente do Setor' + selectedTextD);
                        $("#usu_setor_dp ").val($('option:contains("Selecione")').val());
                        $("#usu_dp_user").val($('option:contains("Selecione")').val());                         
                    },
                    error: function () {
                        alert("não deu para completar a requisição");
                    }
                }
            );
        } else {
            alert("Verifique os campos e tente novamente");
        }
    });
}
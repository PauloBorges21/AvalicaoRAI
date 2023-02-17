
$(document).ready(function () {
    $("#cpf-usuario").keypress(function (event) {
        var charCode = (event.which) ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        if ($(this).val().length >= 14) {
            return false;
        }
        var value = $(this).val().replace(/\D/g, "");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        $(this).val(value);
    });

    $("#email-usuario").blur(function () {
        var email = $(this).val();
        //var campoEmail = $('#email-usuario');
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            //alert("Endereço de e-mail inválido!");
            $("#cvemailV").css({ display: "inline", color: "red" }).fadeOut(6000);
            $('#email-usuario').focus();

        }
    });
});
var sucess;
var btn_cadastrar = $("#btn-gravar");

if (btn_cadastrar.length > 0) {
    document.getElementById("btn-gravar").addEventListener("click", function (event) {
        event.preventDefault();

        var nome = $('#nome-usuario').val();
        var email = $('#email-usuario').val();
        var cpf = $('#cpf-usuario').val();
        var setor = $('#usu_setor').val();
        var gestor = $('#usu_gestorD').val();
        var radio = $('input[name="membergerente"]:checked').val();
        let campos = tratarCampo(nome, email, cpf, setor,gestor);
        if (cpf === '') {
            $("#cvcpf").css("display", "inline").fadeOut(5000);
            $('#cpf-usuario').focus();
        } else {

            let campoUnico = TestaCPF(cpf);
            let validaC = validaCampoUnico(cpf);

            if (campos && campoUnico && validaC) {
                $.ajax(
                    {
                        type: "POST",
                        url: "../rh/ajax/ajax-grava-usuario.php",
                        dataType: "JSON",

                        data: {
                            nome: nome,
                            email: email,
                            cpf: cpf,
                            setor: setor,
                            gestor: gestor,
                            radio: radio
                        },
                        success: function (result) {
                            alert("Usuário Cadastrado:");
                            $('#nome-usuario').val("");
                            $('#email-usuario').val("");
                            $('#cpf-usuario').val("");
                            $("#usu_setor").val($('option:contains("Selecione")').val());
                            $("#usu_gestorD").val($('option:contains("Selecione")').val());
                        },
                        error: function () {
                            alert("não deu para completar a requisição");
                        }
                    }
                );

            } else {
                alert("Verifique os campos e tente novamente");
            }
        }
    });
}

function tratarCampo(nome, email, cpf, setor, gestor) {
    if (nome.length < 8) {
        $("#cvnome").css("display", "inline").fadeOut(5000);
        $('#nome-usuario').focus();
        return false

    } else if (email.length < 8) {
        $("#cvemail").css("display", "inline").fadeOut(5000);
        $('#email-usuario').focus();
        return false
    } else if (cpf.length < 8) {
        $("#cvcpf").css("display", "inline").fadeOut(5000);
        $('#cpf-usuario').focus();
        return false
    } else if (setor == "Selecione") {
        $("#cvdepar").css("display", "inline").fadeOut(5000);
        $('#usu_setor').focus();
        return false
    } else if (gestor == "Selecione") {
        $("#cvgestor").css("display", "inline").fadeOut(5000);
        $('#searchusu_gestorD').focus();
        return false        
    }
    return true;
}

$("#cpf-usuario").on("blur", function () {
    var cpf = $("#cpf-usuario").val();
    if (TestaCPF(cpf) === false) {
        $("#cvcpf").css("display", "inline").fadeOut(5000);
        $('#cpf-usuario').focus();
    } else {
        validaC = validaCampoUnico(cpf);
    }
});

function TestaCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf === '') {
        $("#cvcpfA").css("display", "inline").fadeOut(5000);
        $('#cpf-usuario').focus();
        return false;
    }

    var i;
    var add;
    var rev;

    // Elimina CPFs inválidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999") {
        $("#cvcpfA").css("display", "inline").fadeOut(5000);
        $('#cpf-usuario').focus();
        return false;
    }

    // Valida 1o digito
    add = 0;
    for (i = 0; i < 9; i++) {
        add += parseInt(cpf.charAt(i)) * (10 - i);
    }
    rev = 11 - (add % 11);
    if (rev === 10 || rev === 11) {
        rev = 0;
    }
    if (rev != parseInt(cpf.charAt(9))) {
        $("#cvcpfA").css("display", "inline").fadeOut(5000);
        $('#cpf-usuario').focus();
        return false;
    }

    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i++) {
        add += parseInt(cpf.charAt(i)) * (11 - i);
    }
    rev = 11 - (add % 11);
    if (rev === 10 || rev === 11) {
        rev = 0;
    }

    if (rev != parseInt(cpf.charAt(10))) {
        $("#cvcpfA").css("display", "inline").fadeOut(5000);
        $('#cpf-usuario').focus();
        return false;
    } else {
        return true;
    }

}

function validaCampoUnico(cpf) {
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-valida-campo-unico.php",
            dataType: "text",
            async: false,
            data: { cpf: cpf },
            success: function (data) {
                if (data == 'true') {
                    $("#cvcpfAT").css("display", "inline").fadeOut(5000);
                    sucess = true;
                } else if (data == 'false') {
                    alert("Usuário Cadastrado");
                    sucess = false;

                } else {
                    alert("Dado Inválido");
                    sucess = false;
                }


            },
            error: function () {
                alert("não deu para completar a requisição");
            }

        });

    return sucess;
}


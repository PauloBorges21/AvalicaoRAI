var url = window.location.pathname;
var ativo;
if (url == '/AvaliacaoRAI/rh/editar-list-users.php') {
    ativo = true;
} else {
    ativo = false;
}

$(document).ready(function () {
    $("#email-usuario-edit").blur(function () {
        var email = $(this).val();
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            $("#cvemailV").css({ display: "inline", color: "red" }).fadeOut(6000);
            $('#email-usuario-edit').focus();
        }
    });
});
var sucess;

$("#usu_setor").change(function () {
    var selectedValue = $(this).val();
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-get-dp.php",
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

$("#usu_tb_setor").change(function () {
    var selectedValue = $(this).val();
    //Verificando a URL para Mandar o paramentro para o AJAX
    console.log(ativo);
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax.pag-edit-user.php",
            dataType: "json",
            data: {
                departamento: selectedValue,
                ativo: ativo
            },
            success: function (result) {                
                $("#tb-striped tbody").html('');
                $("#pagination").html('');
                criaTabela(result);
                var total = result.length;
                console.log(total)        ;        
                criaPaginador(total);
            },
            error: function () {
                alert("não deu para completar a requisição");
            }
        }
    );
});


$("#usuario_tb").change(function () {
    var selectedValue = $(this).val();
    var selectedText = $(this).find('option:selected').text();
    console.log(selectedText);
    console.log(ativo);
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-pag-edit-user-name.php",
            dataType: "json",
            data: {
                nome: selectedText,
                ativo: ativo
            },
            success: function (result) {
                $("#tb-striped tbody").html('');
                $("#pagination").html('');
                criaTabela(result);
                var total = result.length;
                criaPaginador(total);
            },
            error: function () {
                alert("não deu para completar a requisição");
            }
        }
    );
});


function criaTabela(result) {
    $.each(result, function (index, pessoa) {
        $("#tb-striped").append("<tr><td>" + pessoa.departamento + "</td>" +
            "<td>" + pessoa.nome + "</td><td>" + pessoa.email + "</td><td>" +
            "<a href='editar-users.php?id_nome=" + pessoa.id + "&id_departamento=" + pessoa.id_departamento + "'><button type='button' class='btn btn-primary btn-sm'>Editar</button></a></td>" +
            "</tr>");
    });

}

var currentUrl = window.location.href;
var pageNumber = 1;

// $(document).on('click', '.pagination-link', function(e) {
//   e.preventDefault();
//   pageNumber = $(this).data('page');
//   var newUrl = updateQueryStringParameter(currentUrl, 'page', pageNumber);
//   window.location.href = newUrl;
// });

// function updateQueryStringParameter(uri, key, value) {
//   var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
//   var separator = uri.indexOf('?') !== -1 ? "&" : "?";
//   if (uri.match(re)) {
//     return uri.replace(re, '$1' + key + "=" + value + '$2');
//   }
//   else {
//     return uri + separator + key + "=" + value;
//   }
// }
// Cria Paginador numeral 
function criaPaginador(total) {
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-pag-number.php",            
            data: {
                total: total,
            },
            success: function (result) {
                console.log(result);
                $('#pagination').html(result);
            },
            error: function () {
                alert("não deu para completar a requisição");
            }
        }
    );
}

$("#usu_user").change(function () {
    var selectedValue = $(this).val();
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-get-usuario-editar.php",
            dataType: "TEXT",
            data: {
                usuario: selectedValue,
            },
            success: function (result) {
                if (result != 'false') {
                    //$("#formceditar").empty();                    
                    $("#formceditar").html('');
                    $('#formceditar').html(result);
                    $('#formceditar').css('display', 'flex');
                } else {
                    $("#formceditar").empty();
                    alert('Não existe Funcionários relacionados nesse setor');
                }
            },
            error: function () {
                alert("não deu para completar a requisição");
            }
        }
    );
});

var btn_editar = $("#btn-editar");
if (btn_editar.length > 0) {
    document.getElementById("btn-editar").addEventListener("click", function (event) {
        event.preventDefault();
        var id = $('#id-usuario-edit').val()
        var nome = $('#nome-usuario-edit').val()
        var email = $('#email-usuario-edit').val()
        var cpf = $('#cpf-usuario-edit').val()
        var setor = $('#dp-usuario-edit').val()
        var gestor = $('#dp-gestor-edit').val()
        var radio = $('input[name="membergerente"]:checked').val();

        let campos = tratarCampo(nome, email, cpf, setor, gestor);
        if (campos) {
            $.ajax(
                {
                    type: "POST",
                    url: "../rh/ajax/ajax-update-user.php",
                    dataType: "JSON",
                    data: {
                        id: id,
                        nome: nome,
                        email: email,
                        cpf: cpf,
                        setor: setor,
                        radio: radio,
                        gestor: gestor
                    },
                    success: function (result) {
                        alert("Usuário Editado:");
                        location.href = 'editar-list-users.php';
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

function tratarCampo(nome, email, cpf, setor, gestor) {
    if (nome.length < 8) {
        $("#cvnome").css("display", "inline").fadeOut(5000);
        $('#nome-usuario-edit').focus();
        return false
    } else if (email.length < 8) {
        $("#cvemail").css("display", "inline").fadeOut(5000);
        $('#email-usuario-edit').focus();
        return false
    } else if (cpf.length < 8) {
        $("#cvcpf").css("display", "inline").fadeOut(5000);
        $('#cpf-usuario-edit').focus();
        return false
    } else if (setor == "Selecione") {
        $("#cvdepar").css("display", "inline").fadeOut(5000);
        $('#dp-usuario-edit').focus();
        return false
    } else if (gestor == "Selecione") {
        $("#cvgestores").css("display", "inline").fadeOut(5000);
        $('#dp-gestor-edit').focus();
        return false
    }
    return true;
}
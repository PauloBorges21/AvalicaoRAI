var url = window.location.pathname;
var ativo;
if (url == '/AvaliacaoRAI/rh/editar-list-users.php') {
    ativo = true;
} else {
    ativo = false;
}
$("#searchdepertamento").keyup(function () {
    var inputValue = $(this).val().toLowerCase();
    $("#usu_tb_setor option").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(inputValue) > -1);
    });
});

$("#searchusuario").keyup(function () {
    var inputValue = $(this).val().toLowerCase();
    console.log(inputValue);
    $.ajax(
        {
            type: "POST",
            url: "../rh/ajax/ajax-pag-edit-user-name.php",
            dataType: "json",
            data: {
                nome: inputValue,
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


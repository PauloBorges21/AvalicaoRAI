$("#searchdepertamento").keyup(function () {
    var inputValue = $(this).val().toLowerCase();
    $("#usu_setor option").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(inputValue) > -1);
    });
});

$("#searchusuario").keyup(function () {
    var inputValue = $(this).val().toLowerCase();
    $("#usu_user option").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(inputValue) > -1);
    });
});


// function search_Experiencias() {
//     let input = document.getElementById('searchbar').value
//     input = input.toLowerCase();
//     let x = document.getElementsByClassName('experienciaNome');

//     for (i = 0; i < x.length; i++) {
//         if (!x[i].innerHTML.toLowerCase().includes(input)) {
//             x[i].parentNode.style.display = "none";
//         }
//         else {
//             x[i].parentNode.style.display = "table-row";
//         }
//     }
// }
// function search_ItemCardapio() {
//     let input = document.getElementById('searchbar').value
//     input = input.toLowerCase();
//     let x = document.getElementsByClassName('itemNome');

//     for (i = 0; i < x.length; i++) {
//         if (!x[i].innerHTML.toLowerCase().includes(input)) {
//             x[i].parentNode.style.display = "none";
//         }
//         else {
//             x[i].parentNode.style.display = "table-row";
//         }
//     }
// }
// function search_Item() {
//     let input = document.getElementById('searchbar').value
//     input = input.toLowerCase();
//     let x = document.getElementsByClassName('itemCI');

//     for (i = 0; i < x.length; i++) {
//         if (!x[i].innerHTML.toLowerCase().includes(input)) {
//             x[i].style.display = "none";
//         }
//         else {
//             x[i].style.display = "block";
//         }
//     }
// }
// function search_Hosp() {
//     let input = document.getElementById('searchbar').value
//     input = input.toLowerCase();
//     let x = document.getElementsByClassName('itemN');

//     for (i = 0; i < x.length; i++) {
//         if (!x[i].innerHTML.toLowerCase().includes(input)) {
//             x[i].style.display = "none";
//         }
//         else {
//             x[i].style.display = "table-row";
//         }
//     }
// }


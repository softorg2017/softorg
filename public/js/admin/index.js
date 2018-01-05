jQuery( function ($) {

    $(".admin-logout").on("click",function() {
        location.href = "/admin/logout";
    });


});


function select_menu()
{
    var vs = $('select option:selected').attr("data-id");
    $("#menu-selected").val(vs);
}
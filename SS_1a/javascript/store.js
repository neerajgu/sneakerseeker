var alreadyBought = false;

$(document).ready(function () {
    $(".cart").on("click", (event) => {
        $("#cartNotif").addClass("show");
        let id = $("#name").attr("id");
        var alreadyBought = true;
        $.post("store.php", { cart: id });

        setTimeout(function () {
            if ($("#cartNotif").hasClass("show"))
                $("#cartNotif").removeClass("show");
            $.post("store.php", { cart: id });
        }, 3000);
    });
});

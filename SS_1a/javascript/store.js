$(document).ready(function () {
    $(".cart").on("click", (event) => {
        $("#cartNotif").addClass("show");
        setTimeout(function () {
            if ($("#cartNotif").hasClass("show"))
                $("#cartNotif").removeClass("show");
        }, 3000);
    });
});
